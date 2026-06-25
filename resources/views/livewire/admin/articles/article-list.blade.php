@section('title', 'Articles')
@section('page-title', 'Articles')

@section('header-actions')
    <a href="{{ route('admin.articles.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors shadow-lg shadow-amber-500/20 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Create Article
    </a>
@endsection

<div>
    <!-- Filters -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-1/3 relative">
            <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search articles..."
                   class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:border-amber-500 transition-colors text-sm">
        </div>
        
        <div class="w-full md:w-auto flex gap-4">
            <select wire:model.live="categoryFilter" class="bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500 transition-colors text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <select wire:model.live="statusFilter" class="bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500 transition-colors text-sm">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="review">Review</option>
                <option value="published">Published</option>
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg text-sm mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-950/50 text-gray-400 border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-4 font-medium">Article</th>
                        <th class="px-6 py-4 font-medium">Category</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Last Updated</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-gray-300">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($article->image)
                                        <img src="{{ Storage::url($article->image) }}" alt="" class="w-10 h-10 rounded-md object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-md bg-gray-800 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-white">{{ $article->title }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($article->slug, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $article->category?->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>
                                @elseif($article->status === 'review')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">Review</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-500/10 text-gray-400 border border-gray-500/20">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $article->updated_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-gray-400 hover:text-amber-500 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button wire:click="delete({{ $article->id }})" wire:confirm="Are you sure you want to delete this article?" class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No articles found. Try adjusting your filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
