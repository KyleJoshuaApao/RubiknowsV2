<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Job;
use App\Models\Project;
use App\Models\QuotationRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_users_without_an_admin_role_cannot_use_the_cms(): void
    {
        foreach (['User', 'Administrator'] as $role) {
            $this->actingAs(User::factory()->create(['role' => $role]));

            $this->get(route('dashboard'))->assertForbidden();
            $this->get(route('admin.projects.index'))->assertForbidden();
            $this->get(route('admin.messages.index'))->assertForbidden();
            $this->post(route('admin.projects.store'), ['title' => 'Defaced'])->assertForbidden();
        }

        $this->assertDatabaseMissing('projects', ['title' => 'Defaced']);
    }

    public function test_admins_can_use_the_cms_but_not_super_admin_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));

        $this->get(route('dashboard'))->assertOk();
        $this->get(route('admin.projects.index'))->assertOk();
        $this->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_new_accounts_default_to_a_role_without_admin_access(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->fresh()->isAdmin());
    }

    public function test_the_only_super_admin_cannot_delete_their_own_account(): void
    {
        $superAdmin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);

        $this->actingAs($superAdmin)
            ->from(route('profile.edit'))
            ->delete(route('profile.destroy'), ['password' => 'password'])
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect(route('profile.edit'));

        $this->assertNotNull($superAdmin->fresh());
        $this->assertAuthenticatedAs($superAdmin);
    }

    public function test_a_super_admin_can_delete_their_account_when_another_remains(): void
    {
        User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);
        $superAdmin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);

        $this->actingAs($superAdmin)
            ->delete(route('profile.destroy'), ['password' => 'password'])
            ->assertRedirect('/');

        $this->assertNull($superAdmin->fresh());
    }

    public function test_responses_send_a_nonce_based_script_policy(): void
    {
        $response = $this->get(route('public.home'))->assertOk();

        $csp = $response->headers->get('Content-Security-Policy');
        preg_match("/script-src ([^;]+)/", $csp, $scriptSrc);

        $this->assertMatchesRegularExpression("/'nonce-[^']+'/", $scriptSrc[1]);
        $this->assertStringNotContainsString("'unsafe-inline'", $scriptSrc[1]);
        $this->assertStringContainsString("object-src 'none'", $csp);

        preg_match("/'nonce-([^']+)'/", $scriptSrc[1], $nonce);
        $response->assertSee('nonce="'.$nonce[1].'"', false);
    }

    public function test_about_story_html_is_sanitised_when_saved_and_rendered(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]));

        $this->post(route('admin.settings.store'), [
            'about_story_content' => '<p class="ql-align-center">Our story<img src=x onerror="alert(1)"></p><script>alert(2)</script>',
        ])->assertRedirect();

        $this->get(route('public.about'))
            ->assertOk()
            ->assertSee('<p class="ql-align-center">Our story</p>', false)
            ->assertDontSee('onerror', false)
            ->assertDontSee('alert(2)', false);
    }

    public function test_project_details_show_the_description(): void
    {
        $project = Project::create(['title' => 'River Bridge', 'description' => "Phase one <b>done</b>.\nPhase two next."]);

        $this->get(route('public.project-details', $project))
            ->assertOk()
            ->assertSee('Phase one &lt;b&gt;done&lt;/b&gt;.<br />', false)
            ->assertSee('Phase two next.');
    }

    public function test_job_applications_cannot_target_archived_jobs(): void
    {
        Storage::fake('local');
        $archived = Job::create(['title' => 'Old Role', 'is_archived' => true]);

        $this->from(route('public.careers'))
            ->post(route('public.careers.apply'), [
                'job_id' => $archived->id,
                'name' => 'Applicant',
                'email' => 'applicant@example.com',
                'resume' => UploadedFile::fake()->create('resume.pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHasErrors('job_id');

        $this->assertDatabaseCount('job_applications', 0);
    }

    public function test_general_applications_are_stored_without_a_job(): void
    {
        Storage::fake('local');

        $this->post(route('public.careers.apply'), [
            'job_id' => 'general',
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'resume' => UploadedFile::fake()->create('resume.pdf', 10, 'application/pdf'),
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('job_applications', ['email' => 'applicant@example.com', 'job_id' => null]);
    }

    public function test_quotation_attachments_are_private_and_downloadable_by_admins(): void
    {
        Mail::fake();
        Storage::fake('local');
        Storage::fake('public');

        $this->post(route('public.quotation.submit'), [
            'name' => 'Client',
            'email' => 'client@example.com',
            'service_needed' => 'Design',
            'project_location' => 'Davao',
            'description' => 'A new building.',
            'attachment' => UploadedFile::fake()->create('brief.pdf', 10, 'application/pdf'),
        ])->assertSessionHasNoErrors();

        $quotation = QuotationRequest::firstOrFail();
        Storage::disk('local')->assertExists($quotation->attachment_path);
        Storage::disk('public')->assertMissing($quotation->attachment_path);

        $this->get(route('admin.quotations.attachment.download', $quotation))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]))
            ->get(route('admin.quotations.attachment.download', $quotation))
            ->assertOk();
    }

    public function test_legacy_quotation_attachments_on_the_public_disk_still_download(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        config(['filesystems.default' => 'public']);
        Storage::disk('public')->put('quotations/old.pdf', 'old');

        $quotation = QuotationRequest::create([
            'name' => 'Client', 'email' => 'client@example.com', 'service_needed' => 'Design',
            'project_location' => 'Davao', 'description' => 'Old request.', 'attachment_path' => 'quotations/old.pdf',
        ]);

        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]))
            ->get(route('admin.quotations.attachment.download', $quotation))
            ->assertOk();
    }

    public function test_client_type_must_be_a_known_value(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));

        $this->post(route('admin.clients.store'), ['name' => 'Acme', 'type' => 'client'])
            ->assertSessionHasErrors('type');
        $this->post(route('admin.clients.store'), ['name' => 'Acme', 'type' => 'Client'])
            ->assertSessionHasNoErrors();

        $this->get(route('public.clients'))->assertOk()->assertSee('Acme');
        $this->assertSame(1, Client::where('type', 'Client')->count());
    }
}
