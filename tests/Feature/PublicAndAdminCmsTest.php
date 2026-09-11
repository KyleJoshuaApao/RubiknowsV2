<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Project;
use App\Models\QuotationRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
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
        Storage::fake(config('filesystems.default'));

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
        ])->assertRedirect(route('admin.projects.index'));
        $project = Project::firstOrFail();

        $this->put(route('admin.projects.update', $project), [
            'title' => 'Bridge Retrofit Updated',
            'status' => 'Completed',
        ])->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['title' => 'Bridge Retrofit Updated']);

        $this->post(route('admin.gallery.store'), [
            'title' => 'Site Photo',
            'type' => 'Photo',
            'category' => 'General',
            'media_file' => UploadedFile::fake()->create('site.jpg', 10, 'image/jpeg'),
        ])->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_media', ['title' => 'Site Photo']);

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

        $disk = config('filesystems.default');
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

    private function superAdmin(): User
    {
        return User::factory()->create([
            'role' => 'Super Admin',
        ]);
    }
}
