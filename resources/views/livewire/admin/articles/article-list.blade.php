@section('page-title', 'Articles')

@section('breadcrumb')
    <li class="text-brand-500">
        Articles
    </li>
@endsection

@section('header-actions')
    <!-- This can be moved inside the component if needed, but since it's an action, we can keep it as is, just styled -->
@endsection

<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h3 class="text-title-sm font-bold text-gray-800 dark:text-white/90">Article Management</h3>
        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Article
        </a>
    </div>

    <!-- Filters -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-1/3 relative">
            <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search articles..."
                   class="w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors">
        </div>
        
        <div class="w-full md:w-auto flex gap-4">
            <select wire:model.live="categoryFilter" class="rounded-lg border border-gray-200 bg-transparent py-2.5 px-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors appearance-none">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <select wire:model.live="statusFilter" class="rounded-lg border border-gray-200 bg-transparent py-2.5 px-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors appearance-none">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="review">Review</option>
                <option value="published">Published</option>
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 flex w-full border-l-4 border-success-500 bg-success-50 px-4 py-3 shadow-sm dark:bg-success-500/15">
            <p class="text-sm text-success-600 dark:text-success-500">
                {{ session('success') }}
            </p>
        </div>
    @endif

    <!-- Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 text-left dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Article</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Category</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Author</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Last Updated</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr class="border-b border-gray-100 dark:border-gray-800 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($article->image_url)
                                        <img src="{{ $article->image_url }}" alt="" class="w-10 h-10 rounded-md object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-md bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-white/90 text-sm">{{ $article->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($article->slug, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $article->category?->name ?? '-' }}</td>
                            <td class="px-5 py-4">
                                @if($article->author)
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $article->author->profile_photo_url }}" class="w-6 h-6 rounded-full object-cover">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $article->author->name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">Published</span>
                                @elseif($article->status === 'review')
                                    <span class="inline-flex rounded-full bg-warning-50 px-2.5 py-0.5 text-xs font-medium text-warning-600 dark:bg-warning-500/15 dark:text-warning-500">Review</span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-white/10 dark:text-gray-400">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $article->updated_at->diffForHumans() }}</td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-brand-500 hover:text-brand-600 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button wire:click="delete({{ $article->id }})" wire:confirm="Are you sure you want to delete this article?" class="text-error-500 hover:text-error-600 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-500 text-sm">No articles found. Try adjusting your filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($articles->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
