@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1 -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-400 text-sm font-medium">Total Articles</h3>
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalArticles }}</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-400 text-sm font-medium">Published</h3>
                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $publishedArticles }}</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-400 text-sm font-medium">Drafts</h3>
                <div class="w-10 h-10 rounded-lg bg-gray-500/10 flex items-center justify-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $draftArticles }}</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-400 text-sm font-medium">Categories</h3>
                <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalCategories }}</p>
        </div>
    </div>

    <!-- Recent Articles -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800">
            <h2 class="text-lg font-semibold text-white">Recent Articles</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-950/50 text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">Title</th>
                        <th class="px-6 py-3 font-medium">Category</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-gray-300">
                    @forelse($recentArticles as $article)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $article->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($article->summary, 50) }}</div>
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
                            <td class="px-6 py-4 text-gray-400">{{ $article->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">No articles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
