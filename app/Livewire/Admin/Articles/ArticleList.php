<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        session()->flash('success', 'Article deleted successfully.');
    }

    public function render()
    {
        $articles = Article::with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('livewire.admin.articles.article-list', [
            'articles' => $articles,
            'categories' => $categories,
        ])->layout('layouts.admin');
    }
}
