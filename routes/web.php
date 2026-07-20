<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');
Route::get('/services', [PublicController::class, 'services'])->name('public.services');
Route::get('/projects', [PublicController::class, 'projects'])->name('public.projects');
Route::get('/projects/{project}', [PublicController::class, 'projectDetails'])->name('public.project-details');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/testimonials', [PublicController::class, 'testimonials'])->name('public.testimonials');
Route::get('/careers', [PublicController::class, 'careers'])->name('public.careers');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');

// Form Submissions
Route::post('/contact', [PublicController::class, 'submitContact'])->name('public.contact.submit');
Route::post('/quotation', [PublicController::class, 'submitQuotation'])->name('public.quotation.submit');
Route::post('/careers/{job}/apply', [PublicController::class, 'applyForJob'])->name('public.careers.apply');

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
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class)->only(['index', 'store']);
    
        // Phase 3: Submissions & HR
        Route::post('messages/bulk-delete', [\App\Http\Controllers\Admin\ContactMessageController::class, 'bulkDestroy'])->name('messages.bulk-delete');
        Route::post('quotations/bulk-delete', [\App\Http\Controllers\Admin\QuotationRequestController::class, 'bulkDestroy'])->name('quotations.bulk-delete');

        Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
        Route::resource('applications', \App\Http\Controllers\Admin\JobApplicationController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('quotations', \App\Http\Controllers\Admin\QuotationRequestController::class)->only(['index', 'show', 'update', 'destroy']);
    });
});

require __DIR__.'/auth.php';
