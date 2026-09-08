<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// TEMPORARY ROUTE TO MIGRATE SUPABASE ON VERCEL
Route::get('/migrate-supabase', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return 'Database Migrated Successfully! You can now visit the homepage.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Public Website Routes
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');
Route::get('/services', [PublicController::class, 'services'])->name('public.services');
Route::get('/projects', [PublicController::class, 'projects'])->name('public.projects');
Route::get('/projects/{project}', [PublicController::class, 'projectDetails'])->name('public.project-details');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/testimonials', [PublicController::class, 'testimonials'])->name('public.testimonials');
Route::get('/clients-and-partners', [PublicController::class, 'clients'])->name('public.clients');
Route::get('/careers', [PublicController::class, 'careers'])->name('public.careers');
Route::get('/privacy-policy', function() { return view('public.privacy'); })->name('public.privacy');
Route::get('/terms-of-service', function() { return view('public.terms'); })->name('public.terms');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');

// Form Submissions — Rate limited to prevent spam and disk exhaustion
Route::post('/contact', [PublicController::class, 'submitContact'])
    ->middleware('throttle:5,1')
    ->name('public.contact.submit');
Route::post('/quotation', [PublicController::class, 'submitQuotation'])
    ->middleware('throttle:3,1')
    ->name('public.quotation.submit');
Route::post('/careers/apply', [PublicController::class, 'applyForJob'])
    ->middleware('throttle:3,1')
    ->name('public.careers.apply');

// Admin Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin CMS Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
        Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryMediaController::class);
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);
        // Super Admin routes
        Route::middleware(['superadmin'])->group(function () {
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
            Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class)->only(['index', 'store']);
            Route::get('live-editor', [\App\Http\Controllers\Admin\LiveEditorController::class, 'index'])->name('live-editor.index');
            Route::post('live-editor', [\App\Http\Controllers\Admin\LiveEditorController::class, 'store'])->name('live-editor.store');
        });
        // Phase 3: Submissions & HR
        Route::post('messages/bulk-delete', [\App\Http\Controllers\Admin\ContactMessageController::class, 'bulkDestroy'])->name('messages.bulk-delete');
        Route::post('quotations/bulk-delete', [\App\Http\Controllers\Admin\QuotationRequestController::class, 'bulkDestroy'])->name('quotations.bulk-delete');

        Route::post('applications/{application}/reply', [\App\Http\Controllers\Admin\JobApplicationController::class, 'reply'])->name('applications.reply');
        Route::post('messages/{message}/reply', [\App\Http\Controllers\Admin\ContactMessageController::class, 'reply'])->name('messages.reply');
        Route::post('quotations/{quotation}/reply', [\App\Http\Controllers\Admin\QuotationRequestController::class, 'reply'])->name('quotations.reply');

        Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
        Route::resource('applications', \App\Http\Controllers\Admin\JobApplicationController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('quotations', \App\Http\Controllers\Admin\QuotationRequestController::class)->only(['index', 'show', 'update', 'destroy']);

        // Protected file downloads — files are on private disk, auth required
        Route::get('applications/{application}/resume', function(\App\Models\JobApplication $application) {
            $disk = \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'));
            abort_unless($disk->exists($application->resume_path), 404);
            return $disk->download($application->resume_path);
        })->name('admin.applications.resume.download');

        Route::get('applications/{application}/portfolio', function(\App\Models\JobApplication $application) {
            abort_unless($application->portfolio_path, 404);
            $disk = \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'));
            abort_unless($disk->exists($application->portfolio_path), 404);
            return $disk->download($application->portfolio_path);
        })->name('admin.applications.portfolio.download');

        Route::get('quotations/{quotation}/attachment', function(\App\Models\QuotationRequest $quotation) {
            abort_unless($quotation->attachment_path, 404);
            $disk = \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'));
            abort_unless($disk->exists($quotation->attachment_path), 404);
            return $disk->download($quotation->attachment_path);
        })->name('admin.quotations.attachment.download');
    });
});

require __DIR__.'/auth.php';
