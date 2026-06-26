@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-gray-400 font-medium">Total Articles</p>
                <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalArticles }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $publishedArticles }} published · {{ $draftArticles }} draft</p>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-gray-400 font-medium">Total Views</p>
                <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ number_format($totalViews) }}</p>
            <p class="text-xs text-gray-500 mt-1">Across all articles</p>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-gray-400 font-medium">Categories</p>
                <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalCategories }}</p>
            <p class="text-xs text-gray-500 mt-1">Active categories</p>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 relative">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-gray-400 font-medium">Contacts</p>
                <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalContacts }}</p>
            @if($unreadContacts > 0)
                <p class="text-xs text-amber-400 mt-1 font-medium">{{ $unreadContacts }} unread messages</p>
            @else
                <p class="text-xs text-gray-500 mt-1">All messages read</p>
            @endif
            @if($unreadContacts > 0)
                <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
            @endif
        </div>
    </div>

    <!-- Weekly Stats & Activity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Weekly Reader Statistics -->
        <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-xl overflow-hidden p-5 shadow-lg">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-sm font-semibold text-white">Statistik Pembaca</h2>
                    <p class="text-xs text-gray-500 mt-0.5">7 hari terakhir — artikel paling banyak dibaca</p>
                </div>
                <span class="text-xs text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-full font-medium">1 Minggu</span>
            </div>

            @php
                $maxViews = $weeklyTopArticles->max('views') ?: 1;
            @endphp

            @forelse($weeklyTopArticles as $i => $article)
                <div class="mb-3.5">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2 min-w-0 flex-1">
                            <span class="text-[10px] font-mono text-gray-600 w-4 shrink-0">{{ $i + 1 }}</span>
                            <p class="text-xs text-gray-300 truncate">{{ Str::limit($article->title, 48) }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 ml-3 shrink-0">
                            <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span class="text-xs font-bold text-white">{{ number_format($article->views) }}</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                        @php
                            $colors = ['bg-amber-500','bg-orange-500','bg-emerald-500','bg-blue-500','bg-purple-500'];
                            $pct = round(($article->views / $maxViews) * 100);
                        @endphp
                        <div class="{{ $colors[$i % 5] }} h-1.5 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-gray-500 text-sm">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Belum ada data pembaca.
                </div>
            @endforelse
        </div>

        <!-- Real-Time Activity Feed -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden shadow-lg flex flex-col">
            <div class="px-5 py-4 border-b border-gray-800 flex justify-between items-center bg-gray-950/30">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <h2 class="text-sm font-semibold text-white">Live Activity</h2>
                </div>
            </div>
            <div class="divide-y divide-gray-800 overflow-y-auto max-h-72">
                @forelse($recentActivities as $activity)
                    <div class="px-5 py-3 hover:bg-gray-800/30 transition">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 mt-0.5 border border-gray-700">
                                @if($activity->user)
                                    <img src="{{ $activity->user->profile_photo_url }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-400 text-xs">?</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-300">
                                    <span class="font-medium text-white">{{ $activity->user ? $activity->user->name : 'System' }}</span>
                                    <br>
                                    <span class="text-gray-400">{{ $activity->description }}</span>
                                </p>
                                <p class="text-[10px] text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-gray-500 text-xs">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Articles by Views -->
        <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
                <h2 class="text-sm font-semibold text-white">Top Articles by Views</h2>
                <a href="{{ route('admin.articles.index') }}" class="text-xs text-amber-400 hover:underline">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-950/50 text-gray-500 text-xs">
                        <tr>
                            <th class="px-6 py-3 font-medium">#</th>
                            <th class="px-6 py-3 font-medium">Article</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 text-gray-300">
                        @forelse($recentArticles as $i => $article)
                            <tr class="hover:bg-gray-800/50 transition">
                                <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $i + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-white text-sm">{{ Str::limit($article->title, 45) }}</p>
                                    <p class="text-xs text-gray-500">{{ $article->category?->name ?? 'Uncategorized' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($article->status === 'published')
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>
                                    @elseif($article->status === 'review')
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-amber-500/10 text-amber-400 border border-amber-500/20">Review</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-gray-500/10 text-gray-400 border border-gray-500/20">Draft</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="font-semibold text-white">{{ number_format($article->views) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No articles yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Contacts -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-800 flex justify-between items-center">
                <h2 class="text-sm font-semibold text-white">Recent Messages</h2>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-amber-400 hover:underline">View all →</a>
            </div>
            <div class="divide-y divide-gray-800">
                @forelse($recentContacts as $contact)
                    <div class="px-5 py-3 hover:bg-gray-800/50 transition {{ !$contact->read_at ? 'border-l-2 border-l-amber-500' : '' }}">
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold uppercase shrink-0 mt-0.5">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-white truncate">{{ $contact->name }}</p>
                                <p class="text-[10px] text-gray-500 truncate">{{ $contact->subject }}</p>
                                <p class="text-[10px] text-gray-600">{{ $contact->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$contact->read_at)
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-1.5 shrink-0"></div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-gray-500 text-sm">No messages yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>


