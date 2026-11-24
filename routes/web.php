<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/education', fn () => view('education'))->name('education');

// Pertemuan 12: form contact, kirim pesan dibatasi 3 per menit per IP
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

// Pertemuan 10: halaman publik project (menggantikan route /projects yang statis)
// Pertemuan 11: detail project memakai slug, bukan ID
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/projects/{project:slug}', [PortfolioController::class, 'show'])->name('projects.show');

Route::get('/profile-saya', fn () => view('profile-saya'))
    ->middleware('auth')
    ->name('profile.saya');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');
    Route::resource('posts', PostController::class);
});

// Pertemuan 10: area admin (dashboard, project, gallery, skill)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::post('projects/{project}/images', [ProjectGalleryController::class, 'store'])->name('projects.images.store');
    Route::put('projects/{project}/images/{image}', [ProjectGalleryController::class, 'update'])->name('projects.images.update');
    Route::delete('projects/{project}/images/{image}', [ProjectGalleryController::class, 'destroy'])->name('projects.images.destroy');
    Route::resource('skills', SkillController::class)->only(['index', 'edit', 'update']);
    Route::resource('contacts', ContactAdminController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
