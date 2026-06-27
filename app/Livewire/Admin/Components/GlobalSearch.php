<?php

namespace App\Livewire\Admin\Components;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $search = '';

    public function render()
    {
        $results = [
            'articles' => [],
            'categories' => [],
            'users' => []
        ];

        if (strlen($this->search) >= 2) {
            $results['articles'] = Article::where('title', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();

            $results['categories'] = Category::where('name', 'like', '%' . $this->search . '%')
                ->take(3)
                ->get();

            $results['users'] = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->take(3)
                ->get();
        }

        return view('livewire.admin.components.global-search', [
            'results' => $results
        ]);
    }
}
