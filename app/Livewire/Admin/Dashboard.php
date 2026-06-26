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
        $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->toDateString());

        // Top articles (published, sorted by total views, max 5)
        $topArticles = Article::where('status', 'published')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // Build chart data: for each article, views per day for last 7 days
        $chartSeries = $topArticles->map(function ($article) use ($days) {
            $dailyMap = \App\Models\ArticleDailyView::where('article_id', $article->id)
                ->whereBetween('view_date', [$days->first(), $days->last()])
                ->pluck('views', 'view_date');

            return [
                'id'    => $article->id,
                'label' => \Illuminate\Support\Str::limit($article->title, 30),
                'data'  => $days->map(fn($d) => (int) ($dailyMap[$d] ?? 0))->values()->toArray(),
            ];
        });

        $chartLabels = $days->map(fn($d) => \Carbon\Carbon::parse($d)->locale('id')->isoFormat('ddd, D MMM'))->values()->toArray();

        return view('livewire.admin.dashboard', [
            'totalArticles'     => Article::count(),
            'publishedArticles' => Article::where('status', 'published')->count(),
            'draftArticles'     => Article::where('status', 'draft')->count(),
            'totalCategories'   => \App\Models\Category::count(),
            'totalViews'        => Article::sum('views'),
            'totalContacts'     => \App\Models\Contact::count(),
            'unreadContacts'    => \App\Models\Contact::whereNull('read_at')->count(),
            'recentArticles'    => Article::with('category')->orderByDesc('views')->latest()->take(5)->get(),
            'recentContacts'    => \App\Models\Contact::latest()->take(5)->get(),
            'recentActivities'  => \App\Models\ActivityLog::with('user')->latest()->take(10)->get(),
            'weeklyTopArticles' => $topArticles,
            'chartSeries'       => $chartSeries,
            'chartLabels'       => $chartLabels,
        ])->layout('layouts.admin');
    }

}
