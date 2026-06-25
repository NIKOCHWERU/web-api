<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryManager extends Component
{
    public $categories;
    public $name = '';
    public $slug = '';
    public $categoryId = null;
    public $isEdit = false;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::withCount('articles')->get();
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->isEdit = true;
    }

    public function cancel()
    {
        $this->reset(['name', 'slug', 'categoryId', 'isEdit']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . ($this->categoryId ?: 'NULL'),
        ]);

        if ($this->isEdit) {
            Category::find($this->categoryId)->update([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);
            session()->flash('success', 'Category updated successfully.');
        } else {
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);
            session()->flash('success', 'Category created successfully.');
        }

        $this->cancel();
        $this->loadCategories();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('success', 'Category deleted successfully.');
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.admin.categories.category-manager')->layout('layouts.admin');
    }
}
