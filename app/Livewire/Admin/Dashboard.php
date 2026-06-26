<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Contact;
use App\Models\ActivityLog;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Weekly top articles: published within last 7 days, sorted by views
        // Fallback to all-time top if no recent articles
        $weeklyTopArticles = Article::where('status', 'published')
            ->where('updated_at', '>=', now()->subDays(7))
            ->orderByDesc('views')
            ->take(5)
            ->get();

        if ($weeklyTopArticles->isEmpty()) {
            $weeklyTopArticles = Article::where('status', 'published')
                ->orderByDesc('views')
                ->take(5)
                ->get();
        }

        return view('livewire.admin.dashboard', [
            'totalArticles'      => Article::count(),
            'publishedArticles'  => Article::where('status', 'published')->count(),
            'draftArticles'      => Article::where('status', 'draft')->count(),
            'totalCategories'    => Category::count(),
            'totalViews'         => Article::sum('views'),
            'totalContacts'      => Contact::count(),
            'unreadContacts'     => Contact::whereNull('read_at')->count(),
            'recentArticles'     => Article::with('category')->orderByDesc('views')->latest()->take(5)->get(),
            'recentContacts'     => Contact::latest()->take(5)->get(),
            'recentActivities'   => ActivityLog::with('user')->latest()->take(10)->get(),
            'weeklyTopArticles'  => $weeklyTopArticles,
        ])->layout('layouts.admin');
    }
}
