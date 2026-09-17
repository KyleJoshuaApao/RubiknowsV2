<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\GalleryMedia;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Project;
use App\Models\QuotationRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use App\Services\FileUploadService;
use App\Support\PublicContentCache;
use App\Support\MediaUrl;
use App\Support\MindanaoMap;
use App\Jobs\SendNewJobApplicationNotification;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicAndAdminCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_successfully(): void
    {
        foreach ([
            '/',
            '/about',
            '/services',
            '/projects',
            '/gallery',
            '/testimonials',
            '/clients-and-partners',
            '/careers',
            '/privacy-policy',
            '/terms-of-service',
            '/contact',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_homepage_uses_a_safe_careers_call_to_action_when_live_content_is_empty(): void
    {
        $this->get(route('public.home'))
            ->assertOk()
            ->assertSee('Build your career with the industry leaders.')
            ->assertSee('Admin CMS')
            ->assertSee(route('login'));
    }

    public function test_public_services_page_links_to_each_service_detail_page(): void
    {
        $service = Service::create([
            'title' => 'Structural Audit',
            'short_description' => 'Independent structural review.',
        ]);

        $this->get(route('public.services'))
            ->assertOk()
            ->assertSee(route('public.service-details', $service));

        $this->get(route('public.service-details', $service))
            ->assertOk()
            ->assertSee('Structural Audit');
    }

    public function test_public_gallery_renders_the_uploaded_media_title_and_url(): void
    {
        $media = GalleryMedia::create([
            'title' => 'Bridge construction progress',
            'type' => 'Photo',
            'category' => 'Construction Progress',
            'url' => 'gallery/bridge.webp',
        ]);

        $this->get(route('public.gallery'))
            ->assertOk()
            ->assertSee('Bridge construction progress')
            ->assertSee('/storage/gallery/bridge.webp')
            ->assertSee('rk-portfolio-mosaic')
            ->assertSee('rk-gallery-mosaic__cta');
    }

    public function test_public_projects_use_the_editorial_work_mosaic(): void
    {
        $this->get(route('public.projects'))
            ->assertOk()
            ->assertSee('rk-portfolio-mosaic')
            ->assertSee('rk-project-mosaic__cta')
            ->assertSee('Start the<br>next build.', false);
    }

    public function test_public_media_urls_are_same_origin_when_app_url_is_stale(): void
    {
        $this->assertSame('/storage/projects/site.webp', MediaUrl::for('projects/site.webp'));
        $this->assertSame('/storage/gallery/site.webp', MediaUrl::for('http://localhost:8000/storage/gallery/site.webp'));
        $this->assertSame('https://images.unsplash.com/photo-1?w=800', MediaUrl::for('https://images.unsplash.com/photo-1?w=800'));
    }

    public function test_admin_cms_pages_render_successfully(): void
    {
        $this->actingAs($this->superAdmin());

        foreach ([
            '/dashboard',
            '/admin/services',
            '/admin/services/create',
            '/admin/projects',
            '/admin/projects/create',
            '/admin/gallery',
            '/admin/gallery/create',
            '/admin/testimonials',
            '/admin/testimonials/create',
            '/admin/clients',
            '/admin/clients/create',
            '/admin/jobs',
            '/admin/jobs/create',
            '/admin/applications',
            '/admin/messages',
            '/admin/quotations',
            '/admin/users',
            '/admin/users/create',
            '/admin/settings',
            '/admin/live-editor',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_dashboard_charts_use_current_project_and_inquiry_activity(): void
    {
        $this->actingAs($this->superAdmin());
        Project::create(['title' => 'Dashboard activity project']);
        ContactMessage::create([
            'name' => 'Dashboard contact',
            'email' => 'dashboard-contact@example.com',
            'message' => 'A dashboard chart test inquiry.',
        ]);
        QuotationRequest::create([
            'name' => 'Dashboard quote',
            'email' => 'dashboard-quote@example.com',
            'service_needed' => 'Engineering',
            'project_location' => 'Manila',
            'description' => 'A dashboard chart test quotation.',
        ]);

        $response = $this->get(route('dashboard'))->assertOk();

        $response->assertViewHas('projectActivity', fn (array $activity) => array_sum($activity['data']) === 1);
        $response->assertViewHas('inquiriesOverview', fn (array $overview) =>
            array_sum($overview['messages']) === 1 && array_sum($overview['quotations']) === 1
        );
        $response->assertSee('z-40')->assertSee('z-[100]');
    }

    public function test_public_migration_endpoint_is_not_exposed_and_download_route_names_are_stable(): void
    {
        $this->get('/migrate-supabase')->assertNotFound();

        $this->assertTrue(Route::has('admin.applications.resume.download'));
        $this->assertTrue(Route::has('admin.applications.portfolio.download'));
        $this->assertTrue(Route::has('admin.quotations.attachment.download'));
        $this->assertFalse(Route::has('admin.admin.applications.resume.download'));
        $this->assertFalse(Route::has('admin.admin.quotations.attachment.download'));
    }

    public function test_admin_cms_can_create_and_update_content_records(): void
    {
        $this->actingAs($this->superAdmin());
        config(['filesystems.default' => 's3']);
        Storage::fake('public');
        Storage::fake('s3');

        $this->post(route('admin.services.store'), [
            'title' => 'Structural Audit',
            'short_description' => 'Audit short copy',
        ])->assertRedirect(route('admin.services.index'));
        $service = Service::firstOrFail();

        $this->put(route('admin.services.update', $service), [
            'title' => 'Structural Audit Updated',
            'short_description' => 'Updated short copy',
        ])->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['title' => 'Structural Audit Updated']);

        $this->post(route('admin.projects.store'), [
            'title' => 'Bridge Retrofit',
            'status' => 'Featured',
            'latitude' => '7.1907',
            'longitude' => '125.4553',
            'image_file' => UploadedFile::fake()->create('bridge.jpg', 10, 'image/jpeg'),
        ])->assertRedirect(route('admin.projects.index'));
        $project = Project::firstOrFail();
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'latitude' => 7.1907,
            'longitude' => 125.4553,
        ]);
        Storage::disk('public')->assertExists($project->image_url);
        Storage::disk('s3')->assertMissing($project->image_url);

        $this->put(route('admin.projects.update', $project), [
            'title' => 'Bridge Retrofit Updated',
            'status' => 'Completed',
            'latitude' => '7.0731',
            'longitude' => '125.6128',
        ])->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', [
            'title' => 'Bridge Retrofit Updated',
            'latitude' => 7.0731,
            'longitude' => 125.6128,
        ]);

        $this->post(route('admin.gallery.store'), [
            'title' => 'Site Photo',
            'type' => 'Photo',
            'category' => 'General',
            'media_file' => UploadedFile::fake()->create('site.jpg', 10, 'image/jpeg'),
        ])->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_media', ['title' => 'Site Photo']);
        $gallery = GalleryMedia::where('title', 'Site Photo')->firstOrFail();
        Storage::disk('public')->assertExists($gallery->url);
        Storage::disk('s3')->assertMissing($gallery->url);

        $this->post(route('admin.testimonials.store'), [
            'client_name' => 'Ava Santos',
            'quote' => 'Excellent delivery.',
            'is_published' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));
        $testimonial = Testimonial::firstOrFail();

        $this->put(route('admin.testimonials.update', $testimonial), [
            'client_name' => 'Ava Santos',
            'quote' => 'Excellent delivery and follow-through.',
        ])->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['quote' => 'Excellent delivery and follow-through.']);

        $this->post(route('admin.clients.store'), [
            'name' => 'Northwind Builders',
            'type' => 'Client',
            'success_story_url' => 'https://example.com/story',
        ])->assertRedirect(route('admin.clients.index'));
        $client = Client::firstOrFail();

        $this->put(route('admin.clients.update', $client), [
            'name' => 'Northwind Partners',
            'type' => 'Partner',
        ])->assertRedirect(route('admin.clients.index'));
        $this->assertDatabaseHas('clients', ['name' => 'Northwind Partners', 'type' => 'Partner']);

        $this->post(route('admin.jobs.store'), [
            'title' => 'Site Engineer',
            'type' => 'Full-time',
            'location' => 'Manila',
            'description' => 'Coordinate field work.',
        ])->assertRedirect(route('admin.jobs.index'));
        $job = Job::firstOrFail();

        $this->put(route('admin.jobs.update', $job), [
            'title' => 'Senior Site Engineer',
            'type' => 'Full-time',
            'location' => 'Manila',
            'description' => 'Coordinate field work.',
        ])->assertRedirect(route('admin.jobs.index'));
        $this->assertDatabaseHas('career_jobs', ['title' => 'Senior Site Engineer']);
    }

    public function test_project_upload_failures_return_a_field_error_instead_of_a_server_error(): void
    {
        $this->actingAs($this->superAdmin());
        $this->app->instance(FileUploadService::class, new class extends FileUploadService {
            public function upload(?UploadedFile $file, string $directory = 'uploads', ?string $oldFilePath = null, string $disk = self::PUBLIC_UPLOAD_DISK): ?string
            {
                throw new \RuntimeException('The upload disk is unavailable.');
            }
        });

        $this->post(route('admin.projects.store'), [
            'title' => 'Project with unavailable upload disk',
            'image_file' => UploadedFile::fake()->create('bridge.jpg', 10, 'image/jpeg'),
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('image_file');

        $this->assertDatabaseMissing('projects', ['title' => 'Project with unavailable upload disk']);
    }

    public function test_public_project_map_links_coordinates_to_project_details(): void
    {
        $project = Project::create([
            'title' => 'Davao Civic Center',
            'location' => 'Davao City',
            'latitude' => 7.1907,
            'longitude' => 125.4553,
        ]);

        $this->get(route('public.home'))
            ->assertOk()
            ->assertSee('home-project-map')
            ->assertSee('Projects across')
            ->assertSee('Mindanao.')
            ->assertSee('RubiKnows engineering and construction projects across Mindanao')
            ->assertSee('Davao Civic Center')
            ->assertSee(json_encode(route('public.project-details', $project)), false)
            ->assertSee('window.location.assign(point.url);', false)
            ->assertSee('tile.openstreetmap.org', false)
            ->assertSee('maxBounds', false)
            ->assertDontSee('basemaps.cartocdn.com', false)
            ->assertDontSee('google.com/maps', false)
            ->assertDontSee('API KEY REQUIRED', false)
            ->assertDontSee('grayscale', false)
            ->assertDontSee('src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"', false);
    }

    public function test_project_maps_are_scoped_to_mindanao(): void
    {
        $this->get(route('public.home'))
            ->assertOk()
            ->assertSee('Projects across<br><em>Mindanao.', false)
            ->assertDontSee('Projects across<br><em>the Philippines.', false);

        $this->actingAs($this->superAdmin());

        $this->get(route('admin.projects.create'))
            ->assertOk()
            ->assertSee('Mindanao');

        $this->post(route('admin.projects.store'), [
            'title' => 'Out of bounds project',
            'latitude' => '14.5995',
            'longitude' => '110.9842',
        ])->assertSessionHasErrors(['latitude', 'longitude']);

        $this->assertDatabaseMissing('projects', ['title' => 'Out of bounds project']);
    }

    public function test_demo_content_seeder_is_repeatable_and_renders_remote_media(): void
    {
        $this->seed(\Database\Seeders\DemoContentSeeder::class);
        $this->seed(\Database\Seeders\DemoContentSeeder::class);

        $this->assertSame(6, Project::where('slug', 'like', 'demo-%')->count());
        $this->assertSame(6, Service::where('slug', 'like', 'demo-%')->count());
        $this->assertSame(8, GalleryMedia::where('title', 'like', '[Demo]%')->count());
        $this->assertSame(5, Testimonial::where('client_name', 'like', '[Demo]%')->count());
        $this->assertSame(6, Client::where('name', 'like', '[Demo]%')->count());
        $this->assertSame(6, Project::where('slug', 'like', 'demo-%')->whereNotNull('latitude')->whereNotNull('longitude')->count());
        Project::where('slug', 'like', 'demo-%')->get()->each(function (Project $project): void {
            $this->assertTrue(MindanaoMap::contains($project->latitude, $project->longitude));
        });
        $this->assertSame(6, Service::where('slug', 'like', 'demo-%')->whereNotNull('image_url')->count());
        $this->assertSame(5, Testimonial::where('client_name', 'like', '[Demo]%')->whereNotNull('avatar_url')->count());

        $this->get(route('public.projects'))
            ->assertOk()
            ->assertSee('[Demo] Bayline Transit Hub')
            ->assertSee('images.unsplash.com', false);

        $this->get(route('public.clients'))
            ->assertOk()
            ->assertSee('placehold.co', false);
    }

    public function test_admin_project_map_picker_lists_existing_pins_and_enforces_mindanao_bounds(): void
    {
        $this->actingAs($this->superAdmin());
        Project::create([
            'title' => 'Davao Reference Site',
            'latitude' => 7.0731,
            'longitude' => 125.6128,
        ]);

        $this->get(route('admin.projects.create'))
            ->assertOk()
            ->assertSee('project-location-picker')
            ->assertSee('Davao Reference Site')
            ->assertSee('Click anywhere in Mindanao to place a pin.');

        $this->post(route('admin.projects.store'), [
            'title' => 'Invalid map location',
            'latitude' => '42.0000',
            'longitude' => '120.9842',
        ])->assertSessionHasErrors('latitude');

        $this->assertDatabaseMissing('projects', ['title' => 'Invalid map location']);
    }

    public function test_cms_writes_invalidate_the_public_home_and_project_map_caches(): void
    {
        $this->actingAs($this->superAdmin());
        Cache::put(PublicContentCache::HOME, ['stale' => true], now()->addMinutes(5));
        Cache::put(PublicContentCache::PROJECT_MAP, collect(), now()->addMinutes(5));

        $this->post(route('admin.projects.store'), [
            'title' => 'Cache clearing project',
            'latitude' => '7.1907',
            'longitude' => '125.4553',
        ])->assertRedirect(route('admin.projects.index'));

        $this->assertFalse(Cache::has(PublicContentCache::HOME));
        $this->assertFalse(Cache::has(PublicContentCache::PROJECT_MAP));
    }

    public function test_gallery_upload_failures_return_a_field_error_instead_of_a_server_error(): void
    {
        $this->actingAs($this->superAdmin());
        $this->app->instance(FileUploadService::class, new class extends FileUploadService {
            public function upload(?UploadedFile $file, string $directory = 'uploads', ?string $oldFilePath = null, string $disk = self::PUBLIC_UPLOAD_DISK): ?string
            {
                throw new \RuntimeException('The upload disk is unavailable.');
            }
        });

        $this->post(route('admin.gallery.store'), [
            'title' => 'Gallery item with unavailable upload disk',
            'type' => 'Photo',
            'category' => 'General',
            'media_file' => UploadedFile::fake()->create('site.jpg', 10, 'image/jpeg'),
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('media_file');

        $this->assertDatabaseMissing('gallery_media', ['title' => 'Gallery item with unavailable upload disk']);
    }

    public function test_super_admin_can_create_users_and_update_settings(): void
    {
        $this->actingAs($this->superAdmin());
        Setting::create(['key' => 'company_name', 'value' => 'RubiKnows']);

        $this->post(route('admin.users.store'), [
            'name' => 'CMS Editor',
            'email' => 'editor@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'editor@example.com', 'role' => 'Admin']);

        $this->post(route('admin.settings.store'), [
            'company_name' => 'RubiKnows Engineering',
            'unexpected_key' => 'ignored',
        ])->assertRedirect(route('admin.settings.index'));

        $this->assertDatabaseHas('settings', ['key' => 'company_name', 'value' => 'RubiKnows Engineering']);
        $this->assertDatabaseMissing('settings', ['key' => 'unexpected_key']);
    }

    public function test_blank_company_notification_email_falls_back_to_the_configured_sender(): void
    {
        config(['mail.from.address' => 'notifications@example.com']);
        Setting::create(['key' => 'contact_email', 'value' => '   ']);

        $this->assertSame('notifications@example.com', Setting::getAdminEmail());
    }

    public function test_admin_replies_and_workflow_updates_persist(): void
    {
        Mail::fake();
        $admin = $this->superAdmin();
        $this->actingAs($admin);

        $message = ContactMessage::create([
            'name' => 'Client One',
            'email' => 'client@example.com',
            'subject' => 'Inquiry',
            'message' => 'Hello',
            'status' => 'New',
        ]);

        $this->post(route('admin.messages.reply', $message), [
            'reply_message' => 'Thanks for reaching out.',
            'sender_name' => 'Support',
            'status' => 'Replied',
        ])->assertRedirect();
        $message->refresh();
        $this->assertSame('Thanks for reaching out.', $message->reply_message);
        $this->assertSame('Replied', $message->status);
        $this->assertNotNull($message->replied_at);

        $quotation = QuotationRequest::create([
            'name' => 'Client Two',
            'email' => 'quote@example.com',
            'service_needed' => 'Design',
            'project_location' => 'Cebu',
            'description' => 'Need a quote.',
            'status' => 'Pending',
        ]);

        $this->put(route('admin.quotations.update', $quotation), [
            'status' => 'Under Review',
            'assigned_engineer_id' => $admin->id,
        ])->assertRedirect();
        $quotation->refresh();
        $this->assertSame('Under Review', $quotation->status);
        $this->assertSame($admin->id, $quotation->assigned_engineer_id);

        $this->post(route('admin.quotations.reply', $quotation), [
            'reply_message' => 'We are reviewing this.',
            'sender_name' => 'Support',
            'status' => 'Sent',
        ])->assertRedirect();
        $quotation->refresh();
        $this->assertSame('We are reviewing this.', $quotation->reply_message);
        $this->assertSame('Sent', $quotation->status);
        $this->assertNotNull($quotation->replied_at);
    }

    public function test_application_delete_removes_files_from_configured_disk(): void
    {
        $this->actingAs($this->superAdmin());

        $disk = JobApplication::UPLOAD_DISK;
        Storage::fake($disk);
        Storage::disk($disk)->put('applications/resumes/resume.pdf', 'resume');
        Storage::disk($disk)->put('applications/portfolios/portfolio.pdf', 'portfolio');

        $application = JobApplication::create([
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'resume_path' => 'applications/resumes/resume.pdf',
            'portfolio_path' => 'applications/portfolios/portfolio.pdf',
            'status' => 'Received',
        ]);

        $this->delete(route('admin.applications.destroy', $application))
            ->assertRedirect(route('admin.applications.index'));

        Storage::disk($disk)->assertMissing('applications/resumes/resume.pdf');
        Storage::disk($disk)->assertMissing('applications/portfolios/portfolio.pdf');
        $this->assertDatabaseMissing('job_applications', ['id' => $application->id]);
    }

    public function test_public_job_application_can_be_submitted_with_files(): void
    {
        Bus::fake();
        Setting::create(['key' => 'contact_email', 'value' => 'hr@example.com']);
        config(['filesystems.default' => 's3']);
        Storage::fake('local');
        Storage::fake('s3');

        $this->post(route('public.careers.apply'), [
            'job_title' => 'Site Engineer',
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'phone' => '09171234567',
            'message' => 'I would like to apply.',
            'resume' => UploadedFile::fake()->create('resume.pdf', 10, 'application/pdf'),
            'portfolio' => UploadedFile::fake()->create('portfolio.zip', 10, 'application/zip'),
        ])->assertRedirect();

        $this->assertDatabaseHas('job_applications', [
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'status' => 'Received',
        ]);
        Bus::assertDispatched(SendNewJobApplicationNotification::class, function (SendNewJobApplicationNotification $job) {
            return $job->recipient === 'hr@example.com';
        });

        $application = JobApplication::where('email', 'applicant@example.com')->firstOrFail();
        Storage::disk('local')->assertExists($application->resume_path);
        Storage::disk('local')->assertExists($application->portfolio_path);
        Storage::disk('s3')->assertMissing($application->resume_path);
        Storage::disk('s3')->assertMissing($application->portfolio_path);
    }

    public function test_career_application_validation_restores_entered_values_and_shows_the_resume_error(): void
    {
        $this->followingRedirects()
            ->from(route('public.careers'))
            ->post(route('public.careers.apply'), [
                'job_title' => 'General Application',
                'name' => 'Applicant',
                'email' => 'applicant@example.com',
            ])
            ->assertOk()
            ->assertSee('value="Applicant"', false)
            ->assertSee('The resume field is required.');
    }

    public function test_job_application_notification_uses_resend_over_https_with_attachments(): void
    {
        config([
            'services.resend.key' => 're_test_key',
            'mail.from.address' => 'careers@rubiknows.test',
            'mail.from.name' => 'RubiKnows Careers',
        ]);
        Storage::fake(JobApplication::UPLOAD_DISK);
        Storage::disk(JobApplication::UPLOAD_DISK)->put('applications/resumes/resume.pdf', 'resume file');

        $application = JobApplication::create([
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'resume_path' => 'applications/resumes/resume.pdf',
            'status' => 'Received',
        ]);

        Http::fake([
            'https://api.resend.com/emails' => Http::response(['id' => 'email-id'], 200),
        ]);

        (new SendNewJobApplicationNotification($application->id, 'hr@example.com'))->handle();

        Http::assertSent(function ($request) {
            $data = $request->data();

            return $request->url() === 'https://api.resend.com/emails'
                && $request->hasHeader('Authorization', 'Bearer re_test_key')
                && $request->hasHeader('Idempotency-Key')
                && $data['to'] === ['hr@example.com']
                && $data['attachments'][0]['filename'] === 'resume.pdf'
                && $data['attachments'][0]['content'] === base64_encode('resume file');
        });
    }

    private function superAdmin(): User
    {
        return User::factory()->create([
            'role' => 'Super Admin',
        ]);
    }
}
