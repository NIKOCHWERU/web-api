<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\Articles\ArticleEditor;
use App\Livewire\Admin\Articles\ArticleList;
use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\UserManager;
use Illuminate\Support\Facades\Route;

// ── Public API routes (existing) ────────────────────────────────────────────
Route::get('/', function () {
    return response()->json(['status' => 'Narasumber Hukum API', 'version' => '2.0']);
});

// ── Admin Auth ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── Protected Admin Routes ───────────────────────────────────────────────
    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/',             Dashboard::class)->name('dashboard');
        Route::get('/articles',     ArticleList::class)->name('articles.index');
        Route::get('/articles/create', ArticleEditor::class)->name('articles.create');
        Route::get('/articles/{article}/edit', ArticleEditor::class)->name('articles.edit');
        Route::get('/categories',   CategoryManager::class)->name('categories.index');
        Route::get('/users',        UserManager::class)->name('users.index');
    });
});
