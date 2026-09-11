<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\GalleryMediaController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LiveEditorController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\QuotationRequestController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Models\JobApplication;
use App\Models\QuotationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::get('/privacy-policy', function () {
    return view('public.privacy');
})->name('public.privacy');
Route::get('/terms-of-service', function () {
    return view('public.terms');
})->name('public.terms');
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
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('gallery', GalleryMediaController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('clients', ClientController::class)->except(['show']);
        // Super Admin routes
        Route::middleware(['superadmin'])->group(function () {
            Route::resource('users', UserController::class)->except(['show']);
            Route::resource('settings', SettingController::class)->only(['index', 'store']);
            Route::get('live-editor', [LiveEditorController::class, 'index'])->name('live-editor.index');
            Route::post('live-editor', [LiveEditorController::class, 'store'])->name('live-editor.store');
        });
        // Phase 3: Submissions & HR
        Route::post('messages/bulk-delete', [ContactMessageController::class, 'bulkDestroy'])->name('messages.bulk-delete');
        Route::post('quotations/bulk-delete', [QuotationRequestController::class, 'bulkDestroy'])->name('quotations.bulk-delete');

        Route::post('applications/{application}/reply', [JobApplicationController::class, 'reply'])->name('applications.reply');
        Route::post('messages/{message}/reply', [ContactMessageController::class, 'reply'])->name('messages.reply');
        Route::post('quotations/{quotation}/reply', [QuotationRequestController::class, 'reply'])->name('quotations.reply');

        Route::resource('jobs', JobController::class);
        Route::resource('applications', JobApplicationController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('quotations', QuotationRequestController::class)->only(['index', 'show', 'update', 'destroy']);

        // Protected file downloads — files are on private disk, auth required
        Route::get('applications/{application}/resume', function (JobApplication $application) {
            $disk = Storage::disk(config('filesystems.default'));
            abort_unless($disk->exists($application->resume_path), 404);

            return $disk->download($application->resume_path);
        })->name('applications.resume.download');

        Route::get('applications/{application}/portfolio', function (JobApplication $application) {
            abort_unless($application->portfolio_path, 404);
            $disk = Storage::disk(config('filesystems.default'));
            abort_unless($disk->exists($application->portfolio_path), 404);

            return $disk->download($application->portfolio_path);
        })->name('applications.portfolio.download');

        Route::get('quotations/{quotation}/attachment', function (QuotationRequest $quotation) {
            abort_unless($quotation->attachment_path, 404);
            $disk = Storage::disk(config('filesystems.default'));
            abort_unless($disk->exists($quotation->attachment_path), 404);

            return $disk->download($quotation->attachment_path);
        })->name('quotations.attachment.download');
    });
});

require __DIR__.'/auth.php';
