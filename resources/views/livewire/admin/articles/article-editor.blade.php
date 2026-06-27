@section('title', $article ? 'Edit Article' : 'Create Article')
@section('page-title', $article ? 'Edit Article' : 'Create Article')

@section('breadcrumb')
    <li class="text-gray-500">
        <span class="mx-1">/</span>
        <a href="{{ route('admin.articles.index') }}" class="hover:text-brand-500">Articles</a>
    </li>
    <li class="text-brand-500">
        <span class="mx-1">/</span>
        {{ $article ? 'Edit' : 'Create' }}
    </li>
@endsection

@section('header-actions')
    <button onclick="WinManager.open('previewWindow')"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-brand-400 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        Show Preview
    </button>
@endsection

<div x-data="articleEditor()" class="flex flex-col lg:flex-row gap-6 relative">

    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- LEFT COLUMN (70%)                                                  -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <div class="w-full lg:w-8/12 flex flex-col gap-6">

        <!-- Section: Title & Slug -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Basic Information</h3>
            </div>
            <div class="p-6 flex flex-col md:flex-row gap-5">
                <div class="flex-1">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Article Title</label>
                    <input type="text" wire:model.live.debounce.500ms="title" x-model="title"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors"
                           placeholder="Enter an engaging title...">
                    @error('title') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Generated Slug</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-sm text-gray-500">/</span>
                        <input type="text" wire:model.live="slug"
                               class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 pl-8 text-sm text-gray-600 outline-none focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:focus:border-brand-500 transition-colors"
                               placeholder="article-slug-here">
                    </div>
                    @error('slug') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Section: Summary -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Article Summary</h3>
            </div>
            <div class="p-6">
                <textarea wire:model.live="summary" x-model="summary" rows="3"
                          class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors resize-y"
                          placeholder="Write a short, engaging summary..."></textarea>
            </div>
        </div>

        <!-- Section: Rich Editor -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]" wire:ignore>
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Content Editor</h3>
            </div>
            <div id="quill-editor" class="text-gray-800 dark:text-white/90" style="min-height: 400px;"></div>
        </div>
        @error('content') <span class="text-error-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror

        <!-- Section: Recent Published Articles -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Recent Published Articles</h3>
            </div>
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-left dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 font-medium text-gray-500 dark:text-gray-400 text-sm">Title</th>
                            <th class="px-5 py-3 font-medium text-gray-500 dark:text-gray-400 text-sm">Status</th>
                            <th class="px-5 py-3 font-medium text-gray-500 dark:text-gray-400 text-sm">Category</th>
                            <th class="px-5 py-3 font-medium text-gray-500 dark:text-gray-400 text-sm text-right">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentArticles as $recent)
                            <tr class="border-b border-gray-100 dark:border-gray-800 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="px-5 py-3 text-sm text-gray-800 dark:text-white/90 truncate max-w-[200px]">{{ $recent->title }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $recent->status === 'published' ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500' : 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-400' }} uppercase tracking-wide">
                                        {{ $recent->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $recent->category?->name ?? '-' }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500 dark:text-gray-400 text-right">
                                    <a href="{{ route('admin.articles.edit', $recent) }}" class="hover:text-brand-500">{{ $recent->updated_at->format('M d, Y') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- RIGHT COLUMN (30%)                                                 -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <div class="w-full lg:w-4/12 flex flex-col gap-6">

        <!-- ── PREVIEW WINDOW (Full Article Preview) ───────────────────── -->
        <!-- Styled to match TailAdmin aesthetics but retains window behavior -->
        <div id="previewWindow" class="win-window rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden flex flex-col z-[9999]" style="display: none; width: 780px; height: 85vh; position: fixed;">

            <!-- Window Title Bar -->
            <div class="win-titlebar flex items-center justify-between px-4 py-2 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-950 cursor-move">
                <span class="win-titlebar-title text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Preview - <span x-text="title || 'New Article'"></span>
                </span>

                <div class="flex items-center gap-3">
                    @if($article)
                    <a href="{{ config('app.frontend_url', 'http://localhost:3000') }}/artikel/{{ $article->slug ?? '' }}" target="_blank"
                       class="text-gray-400 hover:text-brand-500 transition-colors" title="Open in New Tab">
                        <svg viewBox="0 0 14 14" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2H2v10h10V8M8 1h5v5M13 1L7 7"/></svg>
                    </a>
                    @endif
                    <div class="win-controls flex items-center gap-1.5">
                        <button onclick="WinManager.minimize('previewWindow')" class="w-6 h-6 flex items-center justify-center rounded hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-500 transition-colors" title="Minimize">
                            <svg width="10" height="2" fill="currentColor"><path d="M0 0h10v2H0z"/></svg>
                        </button>
                        <button onclick="WinManager.maximize('previewWindow')" class="w-6 h-6 flex items-center justify-center rounded hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-500 transition-colors" title="Maximize">
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 1h8v8H1z"/></svg>
                        </button>
                        <button onclick="WinManager.close('previewWindow')" class="w-6 h-6 flex items-center justify-center rounded hover:bg-error-50 dark:hover:bg-error-500/10 hover:text-error-500 text-gray-500 transition-colors" title="Close">
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 1l8 8M9 1L1 9"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Window Content — Full Article Preview -->
            <div class="win-body flex-1 overflow-y-auto bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                
                <!-- Hero Image -->
                <div class="w-full h-[280px] bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                    @if($this->getExistingImageUrl() && !$image)
                        <img src="{{ $this->getExistingImageUrl() }}" class="w-full h-full object-cover">
                    @elseif($image)
                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-gray-400">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs font-medium">No cover image</span>
                        </div>
                    @endif
                    
                    @if($category_id)
                    <div class="absolute top-4 left-4">
                        <span class="bg-brand-500 text-white text-[10px] font-bold px-2.5 py-1 rounded shadow-md uppercase tracking-wider">
                            {{ $categories->firstWhere('id', $category_id)?->name ?? '' }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Article Body -->
                <div class="max-w-[700px] mx-auto px-7 py-8 pb-16">
                    <!-- Tags -->
                    @if(count($tags))
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($tags as $tag)
                        <span class="inline-flex rounded-full bg-brand-50 border border-brand-100 px-2.5 py-0.5 text-[10px] font-medium text-brand-600 dark:bg-brand-500/15 dark:border-brand-500/30 dark:text-brand-400">#{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif

                    <!-- Title -->
                    <h1 class="text-3xl font-extrabold leading-tight text-gray-900 dark:text-white mb-4 tracking-tight" x-text="title || 'Awesome Article Title...'"></h1>

                    <!-- Meta -->
                    <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 pb-5 mb-6 border-b border-gray-200 dark:border-gray-800">
                        <div class="flex items-center gap-1.5">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f59e0b&color=fff&bold=true" class="w-7 h-7 rounded-full object-cover">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                        </div>
                        <span>&bull;</span>
                        <span>{{ now()->format('M d, Y') }}</span>
                        <span>&bull;</span>
                        <span x-text="Math.max(1, Math.ceil(wordCount/200)) + ' min read'"></span>
                    </div>

                    <!-- Summary -->
                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-300 font-medium italic border-l-4 border-brand-500 bg-brand-50 dark:bg-brand-500/5 px-4 py-3 rounded-r-lg mb-7"
                       x-show="summary" x-text="summary"></p>

                    <!-- Article Body Content -->
                    <div id="preview-content" class="prose prose-brand dark:prose-invert max-w-none">
                        {!! $content ?? '' !!}
                    </div>

                    <!-- Empty state -->
                    <div id="preview-empty" class="text-center py-10 text-gray-400 dark:text-gray-600 hidden">
                        <svg class="w-10 h-10 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <p class="text-sm">Start writing your content...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Publish ─────────────────────────────────────────────────── -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Publish Settings</h3>
            </div>
            <div class="p-6 flex flex-col gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <div class="flex rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900 p-1 gap-1">
                        <button type="button" wire:click="$set('status', 'draft')"
                                class="flex-1 py-2 text-sm font-medium rounded-md transition-colors {{ $status === 'draft' ? 'bg-white shadow-sm dark:bg-gray-800 text-gray-800 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Draft</button>
                        <button type="button" wire:click="$set('status', 'review')"
                                class="flex-1 py-2 text-sm font-medium rounded-md transition-colors {{ $status === 'review' ? 'bg-warning-50 border border-warning-100 text-warning-600 dark:bg-warning-500/15 dark:border-warning-500/30 dark:text-warning-500 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Review</button>
                        <button type="button" wire:click="$set('status', 'published')"
                                class="flex-1 py-2 text-sm font-medium rounded-md transition-colors {{ $status === 'published' ? 'bg-success-50 border border-success-100 text-success-600 dark:bg-success-500/15 dark:border-success-500/30 dark:text-success-500 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Published</button>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Publish Date</label>
                    <input type="text" wire:model="published_at" id="datePicker"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors">
                </div>

                <div class="flex gap-3 pt-2">
                    <button wire:click="save('draft')" class="flex-1 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700/80 transition-colors">
                        Save Draft
                    </button>
                    <button wire:click="save('published')" class="flex-1 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm">
                        Publish Now
                    </button>
                </div>
            </div>
        </div>

        <!-- ── Categorization ──────────────────────────────────────────── -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Categorization</h3>
            </div>
            <div class="p-6 flex flex-col gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <select wire:model="category_id" class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500 transition-colors appearance-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                    <div class="flex flex-wrap gap-2 p-3 rounded-lg border border-gray-200 bg-transparent dark:border-gray-800 focus-within:border-brand-500 dark:focus-within:border-brand-500 transition-colors min-h-[48px]">
                        @foreach($tags as $index => $tag)
                            <span class="inline-flex items-center gap-1 bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 text-xs font-medium px-2.5 py-1 rounded-full">
                                #{{ $tag }}
                                <button type="button" wire:click="removeTag({{ $index }})" class="hover:text-error-500 leading-none transition-colors">×</button>
                            </span>
                        @endforeach
                        <input type="text"
                               x-on:keydown.enter.prevent="$wire.addTag($event.target.value); $event.target.value=''"
                               placeholder="Add tag & hit Enter..."
                               class="bg-transparent text-sm text-gray-800 dark:text-white/90 outline-none flex-1 min-w-[120px]">
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Featured Image ──────────────────────────────────────────── -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Featured Image</h3>
            </div>
            <div class="p-6">
                <div class="relative flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 px-4 py-8 text-center hover:border-brand-500 hover:bg-gray-50/50 dark:border-gray-800 dark:bg-gray-900 dark:hover:border-brand-500 dark:hover:bg-gray-900/50 transition-all group">
                    <input type="file" wire:model="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    @if($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mb-3 h-28 w-28 rounded-lg object-cover shadow-sm">
                        <p class="text-sm font-medium text-success-500">Image selected ✓</p>
                    @elseif($this->getExistingImageUrl())
                        <img src="{{ $this->getExistingImageUrl() }}" class="mb-3 h-28 w-28 rounded-lg object-cover shadow-sm">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Click or drag to change</p>
                    @else
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-sm dark:bg-gray-800 text-brand-500 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 dark:text-white/90 mb-1">Click to upload or drag & drop</p>
                        <p class="text-xs text-gray-500">SVG, PNG, JPG or WEBP (max 2MB)</p>
                    @endif
                </div>
                <div wire:loading wire:target="image" class="mt-3 text-center text-sm font-medium text-brand-500">
                    <span class="inline-block animate-spin mr-1">↻</span> Uploading...
                </div>
            </div>
        </div>

        <!-- ── SEO ─────────────────────────────────────────────────────── -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Search Engine Optimization</h3>
            </div>
            <div class="p-6 flex flex-col gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                    <input type="text" wire:model.live.debounce.500ms="meta_title"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                    <textarea wire:model.live.debounce.500ms="meta_description" rows="3"
                              class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors resize-none"></textarea>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Focus Keyword</label>
                    <input type="text" wire:model.live.debounce.500ms="focus_keyword" x-model="keyword"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
                </div>
                
                <div class="pt-4 border-t border-gray-100 dark:border-gray-800 mt-2">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Visual SEO Score</span>
                        <span class="text-sm font-bold" :class="seoScore>60?'text-success-500':(seoScore>30?'text-warning-500':'text-error-500')" x-text="seoScore+'/100'"></span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 mb-4 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500"
                             :class="seoScore>60?'bg-success-500':(seoScore>30?'bg-warning-500':'bg-error-500')"
                             :style="'width:'+seoScore+'%'"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <p class="text-xs text-gray-500 font-medium">Readability:</p>
                        <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider" 
                              :class="wordCount>300?'bg-success-50 text-success-600 dark:bg-success-500/15':'bg-error-50 text-error-600 dark:bg-error-500/15'">
                            <span class="w-1.5 h-1.5 rounded-full" :class="wordCount>300?'bg-success-500':'bg-error-500'"></span>
                            <span x-text="wordCount>300?'Good':'Needs Work'"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Statistics Widget ────────────────────────────────────────── -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Article Statistics</h3>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                <div class="rounded-xl bg-gray-50 dark:bg-gray-900 p-4 border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Word Count</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="wordCount"></p>
                </div>
                <div class="rounded-xl bg-gray-50 dark:bg-gray-900 p-4 border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Reading Time</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><span x-text="Math.max(1, Math.ceil(wordCount/200))"></span><span class="text-sm font-medium text-gray-400 ml-1">min</span></p>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
(function() {
    function registerArticleEditor() {
        if (typeof Alpine === 'undefined') {
            setTimeout(registerArticleEditor, 50);
            return;
        }
        Alpine.data('articleEditor', () => ({
            title: @entangle('title'),
            summary: @entangle('summary'),
            keyword: @entangle('focus_keyword'),
            contentHtml: '',
            wordCount: 0,

            get seoScore() {
                let score = 15;
                const kw = (this.keyword || '').toLowerCase();
                if (kw) {
                    if (this.title && this.title.toLowerCase().includes(kw)) score += 25;
                    if (this.summary && this.summary.toLowerCase().includes(kw)) score += 20;
                    if (this.contentHtml && this.contentHtml.toLowerCase().includes(kw)) score += 15;
                }
                if (this.summary && this.summary.length > 50) score += 15;
                if (this.wordCount > 300) score += 10;
                return Math.min(100, score);
            }
        }));
    }

    document.addEventListener('alpine:init', registerArticleEditor);

    document.addEventListener("DOMContentLoaded", () => {
        if (typeof Quill === 'undefined' || !document.getElementById('quill-editor')) return;

        const isDark = document.documentElement.classList.contains('dark');
        
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write something amazing...',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1,2,3,4,5,6,false] }],
                        ['bold','italic','underline','strike'],
                        ['blockquote','code-block'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link','image','video'],
                        ['clean']
                    ],
                    handlers: {
                        image: function() {
                            const input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');
                            input.click();
                            input.onchange = () => {
                                const file = input.files[0];
                                if (!file) return;

                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    const img = new Image();
                                    img.onload = () => {
                                        const canvas = document.createElement('canvas');
                                        let width = img.width;
                                        let height = img.height;
                                        const MAX_WIDTH = 1000;

                                        if (width > MAX_WIDTH) {
                                            height = Math.round((height * MAX_WIDTH) / width);
                                            width = MAX_WIDTH;
                                        }

                                        canvas.width = width;
                                        canvas.height = height;
                                        const ctx = canvas.getContext('2d');
                                        ctx.drawImage(img, 0, 0, width, height);

                                        const dataUrl = canvas.toDataURL('image/jpeg', 0.7);
                                        const range = quill.getSelection(true);
                                        quill.insertEmbed(range.index, 'image', dataUrl);
                                        quill.setSelection(range.index + 1);
                                    };
                                    img.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            };
                        }
                    }
                }
            }
        });

        const existingContent = `{!! addslashes($content ?? '') !!}`;
        if (existingContent) quill.root.innerHTML = existingContent;

        const previewEl = document.getElementById('preview-content');
        const previewEmpty = document.getElementById('preview-empty');
        function updatePreview(html) {
            if (previewEl) {
                previewEl.innerHTML = html || '';
                if (previewEmpty) {
                    if (html) {
                        previewEmpty.classList.add('hidden');
                        previewEl.classList.remove('hidden');
                    } else {
                        previewEmpty.classList.remove('hidden');
                        previewEl.classList.add('hidden');
                    }
                }
            }
        }
        updatePreview(existingContent);

        quill.on('text-change', () => {
            let html = quill.root.innerHTML;
            if (html === '<p><br></p>') html = '';

            updatePreview(html);

            try {
                const wireEl = document.querySelector('[wire\\:id]');
                if (wireEl) {
                    const wireId = wireEl.getAttribute('wire:id');
                    const component = Livewire.find(wireId);
                    if (component) component.set('content', html);
                }
            } catch(e) {}

            try {
                const el = document.querySelector('[x-data]');
                if (el && el._x_dataStack) {
                    const data = el._x_dataStack.find(d => 'wordCount' in d);
                    if (data) {
                        data.contentHtml = html;
                        const text = quill.getText().trim();
                        data.wordCount = text.length > 0 ? text.split(/\s+/).filter(w => w).length : 0;
                    }
                }
            } catch(e) {}
        });
    });

    if (document.getElementById('datePicker') && typeof flatpickr !== 'undefined') {
        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            defaultDate: "{{ $published_at ?? now()->format('Y-m-d') }}"
        });
    }
})();
</script>
@endpush
