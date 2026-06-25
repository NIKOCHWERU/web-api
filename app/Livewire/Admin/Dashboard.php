<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Contact;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalArticles'     => Article::count(),
            'publishedArticles' => Article::where('status', 'published')->count(),
            'draftArticles'     => Article::where('status', 'draft')->count(),
            'totalCategories'   => Category::count(),
            'totalViews'        => Article::sum('views'),
            'totalContacts'     => Contact::count(),
            'unreadContacts'    => Contact::whereNull('read_at')->count(),
            'recentArticles'    => Article::with('category')->orderByDesc('views')->latest()->take(5)->get(),
            'topArticles'       => Article::where('status','published')->orderByDesc('views')->take(5)->get(),
            'recentContacts'    => Contact::latest()->take(5)->get(),
        ])->layout('layouts.admin');
    }
}
