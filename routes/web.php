<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'))->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/education', fn () => view('education'))->name('education');

// Pertemuan 10: halaman publik project (menggantikan route /projects yang statis)
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [PortfolioController::class, 'show'])->name('projects.show');

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
});

require __DIR__.'/auth.php';
