<?php

namespace Tests\Feature;

use App\Mail\NewContactMessageNotification;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\GalleryMedia;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\MediaUrl;
use App\Support\SpamGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SiteInfrastructureTest extends TestCase
{
    use RefreshDatabase;

    private function contactMessage(array $overrides = []): array
    {
        return [
            'name' => 'Client',
            'email' => 'client@example.com',
            'subject' => 'New house',
            'message' => 'We would like a quotation for a two-storey house.',
            ...$overrides,
        ];
    }

    public function test_honeypot_submissions_look_successful_but_are_not_saved(): void
    {
        Mail::fake();

        $this->from(route('public.contact'))
            ->post(route('public.contact.submit'), $this->publicForm($this->contactMessage([SpamGuard::HONEYPOT_FIELD => 'http://spam.example'])))
            ->assertRedirect(route('public.contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingQueued();
    }

    public function test_forms_sent_faster_than_a_person_could_type_are_returned(): void
    {
        $this->from(route('public.contact'))
            ->post(route('public.contact.submit'), [SpamGuard::TOKEN_FIELD => SpamGuard::token(), ...$this->contactMessage()])
            ->assertRedirect(route('public.contact'))
            ->assertSessionHasErrors('form');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_forms_without_a_valid_start_token_are_returned(): void
    {
        $this->from(route('public.contact'))
            ->post(route('public.contact.submit'), [SpamGuard::TOKEN_FIELD => 'tampered', ...$this->contactMessage()])
            ->assertSessionHasErrors('form');

        $this->from(route('public.contact'))
            ->post(route('public.contact.submit'), $this->contactMessage())
            ->assertSessionHasErrors('form');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_genuine_messages_are_saved_and_notify_the_company(): void
    {
        Mail::fake();
        Setting::create(['key' => 'contact_email', 'value' => 'office@example.com']);

        $this->from(route('public.contact'))
            ->post(route('public.contact.submit'), $this->publicForm($this->contactMessage()))
            ->assertRedirect(route('public.contact'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', ['email' => 'client@example.com']);
        Mail::assertQueued(NewContactMessageNotification::class, fn ($mail) => $mail->hasTo('office@example.com'));
    }

    public function test_a_validation_error_keeps_the_original_form_start_time(): void
    {
        $token = SpamGuard::token(now()->subMinute());

        $this->followingRedirects()
            ->from(route('public.contact'))
            ->post(route('public.contact.submit'), [SpamGuard::TOKEN_FIELD => $token, '_tab' => 'general', 'name' => 'Client'])
            ->assertOk()
            ->assertSee('value="'.$token.'"', false);
    }

    public function test_rate_limits_count_each_visitor_separately_behind_the_proxy(): void
    {
        Mail::fake();
        $from = fn (string $ip) => $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.5'])->withHeader('X-Forwarded-For', $ip);

        foreach (range(1, 5) as $attempt) {
            $from('203.0.113.10')->post(route('public.contact.submit'), $this->publicForm($this->contactMessage()))->assertRedirect();
        }

        $from('203.0.113.10')->post(route('public.contact.submit'), $this->publicForm($this->contactMessage()))->assertStatus(429);
        $from('198.51.100.20')->post(route('public.contact.submit'), $this->publicForm($this->contactMessage()))->assertRedirect();
    }

    public function test_sitemap_lists_pages_and_services_and_skips_empty_sections(): void
    {
        $service = Service::create(['title' => 'Site Development']);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.route('public.services').'</loc>', false)
            ->assertSee('<loc>'.route('public.service-details', $service).'</loc>', false)
            ->assertDontSee('<loc>'.route('public.gallery').'</loc>', false)
            ->assertDontSee('<loc>'.route('public.projects').'</loc>', false);
    }

    public function test_robots_txt_points_to_the_sitemap_without_naming_private_pages(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap: '.route('sitemap'))
            ->assertDontSee('admin')
            ->assertDontSee(config('auth.login_path'));
    }

    public function test_hsts_is_only_sent_in_production(): void
    {
        $this->get('/')->assertHeaderMissing('Strict-Transport-Security');

        $this->app['env'] = 'production';

        $this->get('/')->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }

    public function test_content_security_policy_pins_leaflet_and_allows_the_storage_host(): void
    {
        config(['filesystems.disks.media.url' => 'https://abc123.supabase.co/storage/v1/object/public/media']);

        $csp = $this->get('/')->headers->get('Content-Security-Policy');

        $this->assertStringContainsString('https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/', $csp);
        $this->assertStringNotContainsString('cdn.jsdelivr.net ', str_replace('cdn.jsdelivr.net/npm', '', $csp));
        $this->assertStringContainsString("img-src 'self' data: blob: https://images.unsplash.com", $csp);
        $this->assertStringContainsString('https://abc123.supabase.co', $csp);
        $this->assertStringNotContainsString('media-src *', $csp);
    }

    public function test_mail_is_delivered_through_the_resend_api(): void
    {
        Http::fake(['api.resend.com/*' => Http::response(['id' => 'email_123'])]);
        config([
            'mail.default' => 'resend',
            'mail.mailers.resend.key' => 're_test_key',
            'mail.from.address' => 'website@rubiknows.test',
            'mail.from.name' => 'RubiKnows',
        ]);

        $message = ContactMessage::create($this->contactMessage());
        Mail::to('office@example.com')->send(new NewContactMessageNotification($message));

        Http::assertSent(function (HttpRequest $request) {
            return $request->url() === 'https://api.resend.com/emails'
                && $request->hasHeader('Authorization', 'Bearer re_test_key')
                && $request['to'] === ['office@example.com']
                && str_contains($request['from'], 'website@rubiknows.test')
                && $request['subject'] !== ''
                && str_contains((string) $request['html'], 'two-storey house');
        });
    }

    public function test_mail_from_a_free_mailbox_uses_the_resend_shared_sender(): void
    {
        Http::fake(['api.resend.com/*' => Http::response(['id' => 'email_456'])]);
        config([
            'mail.default' => 'resend',
            'mail.mailers.resend.key' => 're_test_key',
            'mail.from.address' => 'rubiknows.office@gmail.com',
            'mail.from.name' => 'RubiKnows',
        ]);

        $message = ContactMessage::create($this->contactMessage(['email' => 'owner@example.com', 'name' => 'Home Owner']));
        Mail::to('office@example.com')->send(new NewContactMessageNotification($message));

        $sent = Http::recorded()->first()[0];

        $this->assertSame('"RubiKnows" <onboarding@resend.dev>', $sent['from']);
        $this->assertSame(['"Home Owner" <owner@example.com>'], $sent['reply_to']);
        $this->assertStringContainsString('New house', $sent['subject']);
    }

    public function test_a_resend_key_takes_over_from_an_unusable_smtp_setting(): void
    {
        $env = ['RESEND_API_KEY' => 're_live_key', 'MAIL_MAILER' => 'smtp'];
        $previous = array_map(fn ($key) => $_SERVER[$key] ?? null, array_combine(array_keys($env), array_keys($env)));

        foreach ($env as $key => $value) {
            $_ENV[$key] = $_SERVER[$key] = $value;
        }

        try {
            $config = require config_path('mail.php');
        } finally {
            foreach ($previous as $key => $value) {
                unset($_ENV[$key], $_SERVER[$key]);
                if ($value !== null) {
                    $_ENV[$key] = $_SERVER[$key] = $value;
                }
            }
        }

        $this->assertSame('resend', $config['default']);
    }

    public function test_uploads_switch_to_supabase_storage_when_keys_are_configured(): void
    {
        $env = [
            'SUPABASE_URL' => 'https://abc123.supabase.co',
            'SUPABASE_S3_ACCESS_KEY_ID' => 'key-id',
            'SUPABASE_S3_SECRET_ACCESS_KEY' => 'secret',
        ];

        foreach ($env as $key => $value) {
            $_ENV[$key] = $_SERVER[$key] = $value;
        }

        try {
            $config = require config_path('filesystems.php');
        } finally {
            foreach (array_keys($env) as $key) {
                unset($_ENV[$key], $_SERVER[$key]);
            }
        }

        $this->assertSame('s3', $config['disks']['media']['driver']);
        $this->assertSame('media', $config['disks']['media']['bucket']);
        $this->assertSame('https://abc123.supabase.co/storage/v1/s3', $config['disks']['media']['endpoint']);
        $this->assertSame('https://abc123.supabase.co/storage/v1/object/public/media', $config['disks']['media']['url']);
        $this->assertSame('documents', $config['disks']['documents']['bucket']);
        $this->assertArrayNotHasKey('url', $config['disks']['documents']);

        $local = require config_path('filesystems.php');
        $this->assertSame('local', $local['disks']['media']['driver']);
    }

    public function test_media_urls_come_from_the_storage_bucket_when_it_is_remote(): void
    {
        config(['filesystems.disks.media' => [
            'driver' => 's3',
            'key' => 'key-id',
            'secret' => 'secret',
            'region' => 'ap-northeast-2',
            'bucket' => 'media',
            'endpoint' => 'https://abc123.supabase.co/storage/v1/s3',
            'url' => 'https://abc123.supabase.co/storage/v1/object/public/media',
            'use_path_style_endpoint' => true,
        ]]);

        $this->assertSame(
            'https://abc123.supabase.co/storage/v1/object/public/media/projects/house.webp',
            MediaUrl::for('projects/house.webp')
        );
    }

    public function test_placeholder_content_migration_cleans_up_and_rewrites_services(): void
    {
        Setting::create(['key' => 'nvidia_nim_api_key', 'value' => 'leftover-secret']);
        Setting::create(['key' => 'seo_description', 'value' => 'Top-tier engineering, construction, and consultancy services.']);
        Project::create(['title' => '[Demo] North Channel Bridge']);
        Project::create(['title' => 'Real Project']);
        Testimonial::create(['client_name' => '[Demo] Elena Ramos', 'quote' => 'Placeholder', 'is_published' => true]);
        Testimonial::create(['client_name' => 'Larry Y. Rubinos', 'quote' => 'Real quote', 'is_published' => true]);
        $testEntry = Testimonial::create(['client_name' => 'Test Client', 'quote' => 'qwerty qwerty', 'is_published' => true]);
        Client::create(['name' => '[Demo] Summit Estates', 'type' => 'Client']);
        GalleryMedia::create(['title' => '[Demo] Site team', 'type' => 'Photo', 'url' => 'https://images.unsplash.com/photo-1']);
        Service::create(['title' => 'QWERTY', 'short_description' => 'qwerty']);
        $service = Service::create(['title' => '[Demo] Site Development', 'short_description' => 'Placeholder']);
        $edited = Service::create(['title' => 'Our own service']);
        $job = Job::create(['title' => 'Project Engineer', 'type' => 'Full-time', 'location' => 'Tagum', 'description' => 'qwerty', 'requirements' => 'qwerty']);

        (require database_path('migrations/2026_10_28_000000_replace_placeholder_content.php'))->up();

        $this->assertDatabaseMissing('settings', ['key' => 'nvidia_nim_api_key']);
        $this->assertStringContainsString('Tagum City', Setting::where('key', 'seo_description')->value('value'));
        $this->assertSame(['Real Project'], Project::pluck('title')->all());
        $this->assertSame(['Larry Y. Rubinos'], Testimonial::where('is_published', true)->pluck('client_name')->all());
        $this->assertFalse((bool) $testEntry->fresh()->is_published);
        $this->assertSame(0, Client::count());
        $this->assertSame(0, GalleryMedia::count());
        $this->assertDatabaseMissing('services', ['title' => 'QWERTY']);
        $this->assertSame('Site Development', $service->fresh()->title);
        $this->assertStringNotContainsString('[Demo]', (string) $service->fresh()->content);
        $this->assertFileExists(public_path(ltrim($service->fresh()->image_url, '/')));
        $this->assertSame('Our own service', $edited->fresh()->title);
        $this->assertStringContainsString('Project Engineer', $job->fresh()->description);
        $this->assertStringContainsString('Licensed Civil Engineer', $job->fresh()->requirements);
    }

    public function test_job_requirements_accept_long_qualification_lists(): void
    {
        // A 255-character column made longer lists fail on Postgres.
        $this->assertSame('text', \Illuminate\Support\Facades\Schema::getColumnType('career_jobs', 'requirements'));

        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $requirements = str_repeat("- Licensed Civil Engineer with site experience\n", 12);

        $this->post(route('admin.jobs.store'), [
            'title' => 'Project Engineer',
            'type' => 'Full-time',
            'location' => 'Tagum City',
            'description' => 'Run projects from our Tagum City office.',
            'requirements' => $requirements,
        ])->assertSessionHasNoErrors();

        $this->assertSame(trim($requirements), trim(Job::where('title', 'Project Engineer')->value('requirements') ? Job::first()->requirements : ''));
    }

    public function test_phone_numbers_are_grouped_for_reading(): void
    {
        $this->assertSame('0945 411 6141', \App\Support\ContactDetails::formatPhone('09454116141'));
        $this->assertSame('+63 945 411 6141', \App\Support\ContactDetails::formatPhone('+639454116141'));
        $this->assertSame('(084) 123 4567', \App\Support\ContactDetails::formatPhone('(084) 123 4567'));

        Setting::create(['key' => 'contact_phone', 'value' => '09454116141']);

        $this->get(route('public.home'))
            ->assertSee('0945 411 6141')
            ->assertSee('href="tel:09454116141"', false);
    }

    public function test_missing_pages_use_the_branded_error_page(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('We couldn’t find that page.')
            ->assertSee('Go to the home page');
    }

    public function test_homepage_editor_saves_figures_and_careers_text(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]));

        $this->post(route('admin.live-editor.store'), [
            'home_stats_bar' => [
                ['value' => '120+', 'label' => 'Houses built'],
                ['value' => '', 'label' => 'Half-filled row'],
            ],
            'home_careers' => ['title' => 'Build with us', 'description' => 'We are hiring foremen.'],
        ])->assertRedirect();

        $this->assertSame([['value' => '120+', 'label' => 'Houses built']], Setting::getJson('home_stats_bar'));

        $this->get(route('public.home'))
            ->assertOk()
            ->assertSee('Houses built')
            ->assertDontSee('Half-filled row')
            ->assertSee('Build with us');
    }

    public function test_homepage_preview_listener_is_only_loaded_for_admins(): void
    {
        $this->get(route('public.home', ['preview' => 'true']))->assertDontSee('live-editor-update', false);

        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]))
            ->get(route('public.home', ['preview' => 'true']))
            ->assertSee('live-editor-update', false)
            ->assertSee('event.origin !== window.location.origin', false);
    }

    public function test_social_links_must_be_web_addresses_and_show_in_the_footer(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]));

        $this->post(route('admin.settings.store'), ['social_facebook' => 'javascript:alert(1)'])
            ->assertSessionHasErrors('social_facebook');

        $this->post(route('admin.settings.store'), ['social_facebook' => 'https://facebook.com/rubiknows'])
            ->assertSessionHasNoErrors();

        $this->get(route('public.home'))->assertSee('href="https://facebook.com/rubiknows"', false);
    }

    public function test_admin_job_page_links_application_files_through_the_secure_routes(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $job = Job::create(['title' => 'Site Foreman', 'type' => 'Full-time', 'location' => 'Tagum', 'description' => 'Lead the crew.']);
        $application = JobApplication::create([
            'job_id' => $job->id,
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'resume_path' => 'applications/resumes/resume.pdf',
            'portfolio_path' => 'applications/portfolios/portfolio.pdf',
            'status' => 'Received',
        ]);

        $this->get(route('admin.jobs.show', $job))
            ->assertOk()
            ->assertSee(route('admin.applications.resume.download', $application))
            ->assertSee(route('admin.applications.portfolio.download', $application))
            ->assertDontSee('/storage/applications', false);
    }

    public function test_public_pages_make_no_database_writes(): void
    {
        DB::enableQueryLog();

        foreach (['/', '/about', '/services', '/contact', '/careers'] as $uri) {
            $this->get($uri)->assertOk();
        }

        $writes = collect(DB::getQueryLog())
            ->pluck('query')
            ->filter(fn (string $sql) => preg_match('/^\s*(insert|update|delete)/i', $sql) && ! str_contains($sql, '"cache"') && ! str_contains($sql, '"sessions"'));

        $this->assertSame([], $writes->values()->all());
    }
}
