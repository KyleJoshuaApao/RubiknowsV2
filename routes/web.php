<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\GalleryMediaController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LiveEditorController;
use App\Http\Controllers\Admin\NewsPostController;
use App\Http\Controllers\Admin\PreviewContentController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\QuotationRequestController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');
Route::get('/services', [PublicController::class, 'services'])->name('public.services');
Route::get('/services/{service}', [PublicController::class, 'serviceDetails'])->name('public.service-details');
Route::get('/projects', [PublicController::class, 'projects'])->name('public.projects');
Route::get('/projects/{project}', [PublicController::class, 'projectDetails'])->name('public.project-details');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/testimonials', [PublicController::class, 'testimonials'])->name('public.testimonials');
Route::get('/clients-and-partners', [PublicController::class, 'clients'])->name('public.clients');
Route::get('/careers', [PublicController::class, 'careers'])->name('public.careers');
Route::view('/privacy-policy', 'public.privacy')->name('public.privacy');
Route::view('/terms-of-service', 'public.terms')->name('public.terms');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

// Public forms are rate limited per visitor and filtered for bots.
Route::post('/contact', [PublicController::class, 'submitContact'])
    ->middleware(['throttle:5,1', 'spam'])
    ->name('public.contact.submit');
Route::post('/quotation', [PublicController::class, 'submitQuotation'])
    ->middleware(['throttle:3,1', 'spam'])
    ->name('public.quotation.submit');
Route::post('/careers/apply', [PublicController::class, 'applyForJob'])
    ->middleware(['throttle:3,1', 'spam'])
    ->name('public.careers.apply');

// Admin Dashboard Route
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin CMS Routes — admin role required, not just a login
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('gallery', GalleryMediaController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('clients', ClientController::class)->except(['show']);
        Route::resource('news', NewsPostController::class)->except(['show']);
        Route::patch('preview/{type}/{id}', [PreviewContentController::class, 'publish'])->whereNumber('id')->name('preview.publish');
        Route::patch('preview/{type}', [PreviewContentController::class, 'publishAll'])->name('preview.publish-all');
        // Super Admin routes
        Route::middleware(['superadmin'])->group(function () {
            Route::resource('users', UserController::class)->except(['show']);
            Route::resource('settings', SettingController::class)->only(['index', 'store']);
            Route::get('live-editor', [LiveEditorController::class, 'index'])->name('live-editor.index');
            Route::post('live-editor', [LiveEditorController::class, 'store'])->name('live-editor.store');
        });
        // Inbound submissions and hiring
        Route::post('messages/bulk-delete', [ContactMessageController::class, 'bulkDestroy'])->name('messages.bulk-delete');
        Route::post('quotations/bulk-delete', [QuotationRequestController::class, 'bulkDestroy'])->name('quotations.bulk-delete');

        Route::post('applications/{application}/reply', [JobApplicationController::class, 'reply'])->name('applications.reply');
        Route::post('messages/{message}/reply', [ContactMessageController::class, 'reply'])->name('messages.reply');
        Route::post('quotations/{quotation}/reply', [QuotationRequestController::class, 'reply'])->name('quotations.reply');

        Route::resource('jobs', JobController::class);
        Route::resource('applications', JobApplicationController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('quotations', QuotationRequestController::class)->only(['index', 'show', 'update', 'destroy']);

        // Applicant and quotation files live on the private documents disk
        Route::get('applications/{application}/resume', [JobApplicationController::class, 'downloadResume'])->name('applications.resume.download');
        Route::get('applications/{application}/portfolio', [JobApplicationController::class, 'downloadPortfolio'])->name('applications.portfolio.download');
        Route::get('quotations/{quotation}/attachment', [QuotationRequestController::class, 'downloadAttachment'])->name('quotations.attachment.download');
        Route::get('quotations/{quotation}/files/{index}', [QuotationRequestController::class, 'downloadFile'])->whereNumber('index')->name('quotations.files.download');
        Route::get('messages/{message}/files/{index}', [ContactMessageController::class, 'downloadAttachment'])->whereNumber('index')->name('messages.files.download');
    });
});

require __DIR__.'/auth.php';
