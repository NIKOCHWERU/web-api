@section('page-title', 'Dashboard')

<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 md:gap-6 mb-6">
        
        <!-- Total Articles -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800 text-brand-500 dark:text-brand-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Articles</span>
                    <h4 class="mt-1 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $totalArticles }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ $publishedArticles }} published · {{ $draftArticles }} draft</p>
                </div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800 text-success-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Views</span>
                    <h4 class="mt-1 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ number_format($totalViews) }}</h4>
                    <p class="text-xs text-gray-500 mt-1">Across all articles</p>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800 text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Categories</span>
                    <h4 class="mt-1 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $totalCategories }}</h4>
                    <p class="text-xs text-gray-500 mt-1">Active categories</p>
                </div>
            </div>
        </div>

        <!-- Contacts -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 relative">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800 text-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Contacts</span>
                    <h4 class="mt-1 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $totalContacts }}</h4>
                    @if($unreadContacts > 0)
                        <p class="text-xs text-error-500 mt-1 font-medium">{{ $unreadContacts }} unread messages</p>
                    @else
                        <p class="text-xs text-gray-500 mt-1">All messages read</p>
                    @endif
                </div>
            </div>
            @if($unreadContacts > 0)
                <span class="absolute top-5 right-5 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-error-500"></span>
                </span>
            @endif
        </div>
    </div>

    <!-- Charts and Activity Grid -->
    <div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">
        
        <!-- Weekly Reader Chart -->
        <div class="col-span-12 xl:col-span-8 rounded-2xl border border-gray-200 bg-white px-5 pt-5 pb-6 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Statistik Pembaca Mingguan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Views per hari — 7 hari terakhir</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-sm font-medium text-brand-500 dark:bg-brand-500/15 dark:text-brand-500">1 Minggu</span>
            </div>

            <div class="h-[300px]">
                <canvas id="weeklyChart"></canvas>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-x-4 gap-y-2 mt-5 justify-center">
                @php $chartColors = ['#f59e0b','#10b981','#3b82f6','#a855f7','#ef4444']; @endphp
                @foreach($weeklyTopArticles as $i => $article)
                    <div class="flex items-center gap-2">
                        <span class="block w-3 h-3 rounded-full" style="background:{{ $chartColors[$i % 5] }}"></span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px]">{{ Str::limit($article->title, 28) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Live Activity -->
        <div class="col-span-12 xl:col-span-4 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-success-500"></span>
                </span>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Live Activity</h3>
            </div>
            <div class="p-4 flex-1 overflow-y-auto max-h-[350px]">
                <div class="relative before:absolute before:left-[17px] before:top-2 before:h-full before:w-[2px] before:bg-gray-200 dark:before:bg-gray-800 space-y-5 pl-0.5">
                    @forelse($recentActivities as $activity)
                        <div class="relative flex gap-4 pl-[38px]">
                            <!-- Timeline Dot -->
                            <div class="absolute left-[-1.5px] top-1.5 flex h-[11px] w-[11px] items-center justify-center rounded-full bg-white dark:bg-gray-900 border-2 border-brand-500"></div>
                            
                            <div class="w-8 h-8 rounded-full overflow-hidden shrink-0">
                                @if($activity->user)
                                    <img src="{{ $activity->user->profile_photo_url }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 text-xs">?</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold text-gray-800 dark:text-white/90">{{ $activity->user ? $activity->user->name : 'System' }}</span>
                                    {{ $activity->description }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 text-sm py-4">No recent activity.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        
        <!-- Top Articles Table -->
        <div class="col-span-12 xl:col-span-8 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5 flex justify-between items-center border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Top Articles by Views</h3>
                <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-brand-500 hover:text-brand-600">View all</a>
            </div>
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-left dark:bg-gray-900">
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">#</th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Article</th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-right">Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentArticles as $i => $article)
                            <tr class="border-b border-gray-100 dark:border-gray-800 last:border-b-0">
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ Str::limit($article->title, 45) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $article->category?->name ?? 'Uncategorized' }}</p>
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
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5 text-gray-800 dark:text-white/90">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-sm font-semibold">{{ number_format($article->views) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500 text-sm">No articles yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Contacts -->
        <div class="col-span-12 xl:col-span-4 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Messages</h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-sm font-medium text-brand-500 hover:text-brand-600">View all</a>
            </div>
            <div class="flex-1 overflow-y-auto">
                <div class="flex flex-col">
                    @forelse($recentContacts as $contact)
                        <div class="flex items-start gap-4 px-6 py-4 border-b border-gray-100 dark:border-gray-800 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <div class="w-10 h-10 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-500 flex items-center justify-center font-bold text-sm uppercase shrink-0">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-800 dark:text-white/90 truncate {{ !$contact->read_at ? 'font-bold' : '' }}">{{ $contact->name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $contact->subject }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">{{ $contact->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$contact->read_at)
                                <span class="w-2 h-2 rounded-full bg-error-500 mt-2 shrink-0"></span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-gray-500 text-sm py-8">No messages yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    // We can re-render or update chart when theme changes, but for simplicity we rely on the CSS variables if possible
    // Chart.js requires manual update on theme change. Let's just draw it.
    
    setTimeout(() => {
        var labels  = @json($chartLabels);
        var series  = @json($chartSeries);
        var colors  = ['#f59e0b','#10b981','#3b82f6','#a855f7','#ef4444'];
    
        var datasets = series.map(function(s, i) {
            var base = colors[i % colors.length];
            return {
                label:           s.label,
                data:            s.data,
                borderColor:     base,
                backgroundColor: base,
                borderWidth:     2,
                tension:         0.4,       // smooth curves
                pointRadius:     4,
                pointHoverRadius: 6,
                fill:            false
            };
        });
    
        var isDark = document.documentElement.classList.contains('dark');
        var gridColor  = isDark ? 'rgba(255,255,255,0.05)'  : 'rgba(0,0,0,0.05)';
        var tickColor  = isDark ? '#9ca3af' : '#64748b';
        var tooltipBg  = isDark ? '#1f2937' : '#ffffff';
        var tooltipTxt = isDark ? '#f3f4f6' : '#111827';
    
        var ctx = document.getElementById('weeklyChart');
        if (!ctx) return;
    
        new Chart(ctx, {
            type: 'line',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tickColor,
                        bodyColor:  tooltipTxt,
                        borderColor: isDark ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return '  ' + ctx.dataset.label + ': ' + ctx.parsed.y + ' views';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid:  { display: false },
                        ticks: { color: tickColor, font: { size: 11, family: 'Inter' } },
                        border:{ display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid:  { color: gridColor, drawBorder: false },
                        ticks: {
                            color: tickColor,
                            font:  { size: 11, family: 'Inter' },
                            stepSize: 1,
                            precision: 0,
                            callback: function(v) { return Number.isInteger(v) ? v : ''; }
                        },
                        border:{ display: false }
                    }
                }
            }
        });
    }, 100);
});
</script>
@endpush
