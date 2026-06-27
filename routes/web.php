<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\Articles\ArticleEditor;
use App\Livewire\Admin\Articles\ArticleList;
use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Contacts\ContactManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\UserManager;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── Root redirect ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ── Login Alias Fallback for default Authenticate Middleware ──────────────────
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');

// ── Admin Auth ────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/',                              Dashboard::class)->name('dashboard');
        Route::get('/articles',                      ArticleList::class)->name('articles.index');
        Route::get('/articles/create',               ArticleEditor::class)->name('articles.create');
        Route::get('/articles/{article}/edit',       ArticleEditor::class)->name('articles.edit');
        Route::get('/categories',                    CategoryManager::class)->name('categories.index');
        Route::get('/users',                         \App\Livewire\Admin\Users\UserManager::class)->name('users.index');
        Route::get('/contacts',                      \App\Livewire\Admin\Contacts\ContactManager::class)->name('contacts.index');
        Route::get('/profile',                       \App\Livewire\Admin\Profile\ProfileManager::class)->name('profile');
    });
});


