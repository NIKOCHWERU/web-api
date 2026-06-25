<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleEditor extends Component
{
    use WithFileUploads;

    public ?Article $article = null;
    
    // Form fields
    public $title = '';
    public $slug = '';
    public $summary = '';
    public $content = '';
    public $status = 'draft';
    public $published_at;
    public $category_id = '';
    public $tags = [];
    public $image;
    public $meta_title = '';
    public $meta_description = '';
    public $focus_keyword = '';
    public $canonical_url = '';

    public $existingImage = null;

    public function mount(?Article $article = null)
    {
        if ($article && $article->exists) {
            $this->article = $article;
            $this->title = $article->title;
            $this->slug = $article->slug;
            $this->summary = $article->summary;
            $this->content = $article->content;
            $this->status = $article->status;
            $this->published_at = $article->published_at ? $article->published_at->format('Y-m-d') : null;
            $this->category_id = $article->category_id;
            $this->tags = $article->tags ?? [];
            $this->existingImage = $article->image;
            $this->meta_title = $article->meta_title;
            $this->meta_description = $article->meta_description;
            $this->focus_keyword = $article->focus_keyword;
            $this->canonical_url = $article->canonical_url;
        } else {
            $this->published_at = now()->format('Y-m-d');
        }
    }

    public function updatedTitle()
    {
        if (!$this->article) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function addTag($tag)
    {
        $tag = trim($tag);
        if ($tag && !in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
    }

    public function removeTag($index)
    {
        array_splice($this->tags, $index, 1);
    }

    public function save($setStatus = null)
    {
        if ($setStatus) {
            $this->status = $setStatus;
        }

        $this->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:articles,slug,' . ($this->article ? $this->article->id : 'NULL'),
            'content' => 'required',
            'status' => 'required|in:draft,review,published',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'category_id' => $this->category_id ?: null,
            'tags' => $this->tags,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'focus_keyword' => $this->focus_keyword,
            'canonical_url' => $this->canonical_url,
            // is_published di-handle oleh boot method model Article
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('articles', 'public');
        }

        if ($this->article) {
            $this->article->update($data);
            session()->flash('success', 'Article updated successfully.');
        } else {
            $this->article = Article::create($data);
            session()->flash('success', 'Article created successfully.');
        }

        return redirect()->route('admin.articles.index');
    }

    public function render()
    {
        return view('livewire.admin.articles.article-editor', [
            'categories' => Category::all(),
            'recentArticles' => Article::latest()->take(3)->get(),
        ])->layout('layouts.admin');
    }
}
