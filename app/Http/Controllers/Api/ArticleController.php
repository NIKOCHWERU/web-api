<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::with('category')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(12);
    }

    public function show($slug)
    {
        return Article::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }
}
