<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::post('/contact', [ContactController::class, 'store']);

// Get categories
Route::get('/categories', function () {
    return response()->json(\App\Models\Category::withCount('articles')->get());
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
