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

// ── Admin Auth ────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/',                              Dashboard::class)->name('dashboard');
        Route::get('/articles',                      ArticleList::class)->name('articles.index');
        Route::get('/articles/create',               ArticleEditor::class)->name('articles.create');
        Route::get('/articles/{article}/edit',       ArticleEditor::class)->name('articles.edit');
        Route::get('/categories',                    CategoryManager::class)->name('categories.index');
        Route::get('/users',                         UserManager::class)->name('users.index');
        Route::get('/contacts',                      ContactManager::class)->name('contacts.index');
    });
});

// ── Public API ────────────────────────────────────────────────────────────────
Route::prefix('api')->name('api.')->group(function () {

    // Submit contact form
    Route::post('/contact', function (Request $request) {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda telah diterima. Kami akan segera menghubungi Anda.',
            'data'    => ['id' => $contact->id],
        ], 201);
    });

    // Track article view
    Route::post('/articles/{slug}/view', function (string $slug) {
        $article = \App\Models\Article::where('slug', $slug)
                        ->where('status', 'published')
                        ->first();

        if ($article) {
            $article->incrementViews();
            return response()->json(['views' => $article->views]);
        }

        return response()->json(['error' => 'Not found'], 404);
    });

    // Get articles list (public)
    Route::get('/articles', function (Request $request) {
        $articles = \App\Models\Article::with('category')
            ->where('status', 'published')
            ->select('id','title','slug','summary','image','published_at','category_id','tags','views')
            ->when($request->category, fn($q,$c) => $q->whereHas('category',fn($cq) => $cq->where('slug',$c)))
            ->latest('published_at')
            ->paginate(12);

        return response()->json($articles);
    });

    // Get single article (public)
    Route::get('/articles/{slug}', function (string $slug) {
        $article = \App\Models\Article::with('category')
            ->where('slug', $slug)
            ->where('status','published')
            ->firstOrFail();

        return response()->json($article);
    });

    // Get categories
    Route::get('/categories', function () {
        return response()->json(\App\Models\Category::withCount('articles')->get());
    });
});
