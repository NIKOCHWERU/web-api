@section('title', $article ? 'Edit Article' : 'Create Article')
@section('page-title', $article ? 'Edit Article' : 'Create Article')

@section('breadcrumb')
    <span class="mx-1">/</span>
    <a href="{{ route('admin.articles.index') }}" class="hover:text-amber-400">Articles</a>
    <span class="mx-1">/</span>
    <span class="text-white">{{ $article ? 'Edit' : 'Create' }}</span>
@endsection

@section('header-actions')
    <button onclick="WinManager.open('previewWindow')"
            class="flex items-center gap-2 text-xs bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 px-3 py-1.5 rounded-lg transition">
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
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Section</h3>
            </div>
            <div class="p-5 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Title Input</label>
                    <input type="text" wire:model.live.debounce.500ms="title" x-model="title"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-colors"
                           placeholder="Judul Artikel Menarik...">
                    @error('title') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Automatically generated Slug</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-xs text-gray-500">slug:</span>
                        <input type="text" wire:model.live="slug"
                               class="w-full bg-gray-950 border border-gray-800 text-gray-300 rounded-lg pl-11 pr-4 py-2 text-sm focus:border-amber-500 outline-none transition-colors"
                               placeholder="judul-artikel">
                    </div>
                    @error('slug') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Section: Summary -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Article Summary</h3>
            </div>
            <div class="p-5">
                <textarea wire:model.live="summary" x-model="summary" rows="3"
                          class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-3 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-colors resize-y"
                          placeholder="Masukkan ringkasan artikel..."></textarea>
            </div>
        </div>

        <!-- Section: Rich Editor -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden" wire:ignore>
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Rich Editor</h3>
            </div>
            <div id="quill-editor" class="text-white"></div>
        </div>
        @error('content') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror

        <!-- Section: Recent Published Articles -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Published Articles</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-950/50 text-gray-400">
                        <tr>
                            <th class="px-5 py-3 font-medium">Title</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                            <th class="px-5 py-3 font-medium">Category</th>
                            <th class="px-5 py-3 font-medium">Update</th>
                            <th class="px-5 py-3 font-medium text-right">...</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 text-gray-300">
                        @foreach($recentArticles as $recent)
                            <tr class="hover:bg-gray-800/50">
                                <td class="px-5 py-3 truncate max-w-[200px]">{{ $recent->title }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium
                                        {{ $recent->status === 'published' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20' }} uppercase tracking-wide">
                                        {{ $recent->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">{{ $recent->category?->name ?? '-' }}</td>
                                <td class="px-5 py-3">{{ $recent->updated_at->format('M d, Y') }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.articles.edit', $recent) }}" class="text-gray-500 hover:text-amber-500">
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
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
        <div id="previewWindow" class="win-window shadow-2xl shadow-black/50" style="display: none; width: 780px; height: 85vh;">

            <!-- Window Title Bar -->
            <div class="win-titlebar">
                <span class="win-titlebar-title">Preview Artikel - <span x-text="title || 'Artikel Baru'"></span></span>

                <div style="display:flex;align-items:center;gap:6px;margin-left:auto;">
                    <!-- Open in new tab -->
                    @if($article)
                    <a href="{{ config('app.frontend_url', 'http://localhost:3000') }}/artikel/{{ $article->slug ?? '' }}" target="_blank"
                       class="win-btn text-gray-400 hover:text-white" title="Open in New Tab" style="display:flex;align-items:center;">
                        <svg viewBox="0 0 14 14" width="10" height="10" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M6 2H2v10h10V8M8 1h5v5M13 1L7 7"/>
                        </svg>
                    </a>
                    @endif
                    <div class="win-controls">
                        <button onclick="WinManager.minimize('previewWindow')" class="win-btn win-btn-min text-gray-400 hover:text-white" title="Minimize">
                            <svg viewBox="0 0 10 10"><path d="M0 5h10v1H0z" fill="currentColor"/></svg>
                        </button>
                        <button onclick="WinManager.maximize('previewWindow')" class="win-btn win-btn-max text-gray-400 hover:text-white" title="Maximize">
                            <svg viewBox="0 0 10 10"><path d="M0 0v10h10V0H0zm1 1h8v8H1V1z" fill="currentColor"/></svg>
                        </button>
                        <button onclick="WinManager.close('previewWindow')" class="win-btn win-btn-close text-gray-400 hover:text-white" title="Close">
                            <svg viewBox="0 0 10 10"><path d="M0 0l10 10M10 0L0 10" stroke="currentColor" stroke-width="1.2" fill="none"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Window Content — Full Article Preview -->
            <div class="win-body" style="overflow-y:auto; background:#fff; color:#1a1a1a;">

                <!-- Hero Image -->
                <div style="width:100%;height:280px;background:#e5e7eb;overflow:hidden;position:relative;">
                    @if($this->getExistingImageUrl() && !$image)
                        <img src="{{ $this->getExistingImageUrl() }}" style="width:100%;height:100%;object-fit:cover;">
                    @elseif($image)
                        <img src="{{ $image->temporaryUrl() }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1f2937 0%,#374151 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                            <svg width="48" height="48" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span style="font-size:11px;color:#6b7280;">Belum ada gambar</span>
                        </div>
                    @endif
                    <!-- Category badge -->
                    @if($category_id)
                    <div style="position:absolute;top:16px;left:16px;">
                        <span style="background:#f59e0b;color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:4px;text-transform:uppercase;letter-spacing:0.05em;">
                            {{ $categories->firstWhere('id', $category_id)?->name ?? '' }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Article Body -->
                <div style="max-width:700px;margin:0 auto;padding:32px 28px 60px;">

                    <!-- Tags -->
                    @if(count($tags))
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px;">
                        @foreach($tags as $tag)
                        <span style="background:#fef3c7;color:#92400e;font-size:10px;font-weight:600;padding:2px 8px;border-radius:999px;border:1px solid #fde68a;">#{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif

                    <!-- Title -->
                    <h1 style="font-size:28px;font-weight:800;line-height:1.25;color:#111827;margin:0 0 16px;letter-spacing:-0.02em;"
                        x-text="title || 'Judul Artikel Menarik...'"></h1>

                    <!-- Meta -->
                    <div style="display:flex;align-items:center;gap:12px;font-size:12px;color:#6b7280;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #e5e7eb;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f59e0b&color=fff&bold=true" style="width:28px;height:28px;border-radius:50%;object-fit:cover;">
                            <span style="font-weight:500;color:#374151;">{{ auth()->user()->name }}</span>
                        </div>
                        <span>&bull;</span>
                        <span>{{ now()->format('d M Y') }}</span>
                        <span>&bull;</span>
                        <span x-text="Math.max(1, Math.ceil(wordCount/200)) + ' menit baca'"></span>
                        <span>&bull;</span>
                        <span x-text="wordCount + ' kata'"></span>
                    </div>

                    <!-- Summary / Lead -->
                    <p style="font-size:15px;line-height:1.7;color:#374151;font-weight:500;font-style:italic;border-left:3px solid #f59e0b;padding-left:16px;margin-bottom:28px;background:#fffbeb;padding:12px 16px;border-radius:4px;"
                       x-show="summary"
                       x-text="summary"></p>

                    <!-- Article Body Content -->
                    <div id="preview-content"
                         style="font-size:15px;line-height:1.8;color:#374151;font-family:'Inter',sans-serif;">
                        {!! $content ?? '' !!}
                    </div>

                    <!-- Empty state -->
                    <div id="preview-empty" style="text-align:center;padding:40px 0;color:#9ca3af;display:none;">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;opacity:.4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p style="font-size:13px;">Belum ada konten. Mulai menulis di editor...</p>
                    </div>

                    <!-- Footer -->
                    <div style="margin-top:48px;padding-top:24px;border-top:1px solid #e5e7eb;">
                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                            @foreach($tags as $tag)
                            <span style="background:#f3f4f6;color:#6b7280;font-size:11px;padding:3px 10px;border-radius:999px;border:1px solid #e5e7eb;">#{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Publish ─────────────────────────────────────────────────── -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Publish</h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-2">Status</label>
                    <div class="flex rounded-lg border border-gray-800 overflow-hidden bg-gray-950 p-1 gap-1">
                        <button type="button" wire:click="$set('status', 'draft')"
                                class="flex-1 text-xs py-1.5 font-medium rounded-md transition-colors {{ $status === 'draft' ? 'bg-gray-700 text-white' : 'text-gray-500 hover:text-gray-300' }}">Draft</button>
                        <button type="button" wire:click="$set('status', 'review')"
                                class="flex-1 text-xs py-1.5 font-medium rounded-md transition-colors {{ $status === 'review' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'text-gray-500 hover:text-gray-300' }}">Review</button>
                        <button type="button" wire:click="$set('status', 'published')"
                                class="flex-1 text-xs py-1.5 font-medium rounded-md transition-colors {{ $status === 'published' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'text-gray-500 hover:text-gray-300' }}">Published</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Publish Date</label>
                    <input type="text" wire:model="published_at" id="datePicker"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 text-sm focus:border-amber-500 outline-none">
                </div>

                <div class="flex gap-2 pt-2">
                    <button wire:click="save('draft')" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium py-2 rounded-lg transition-colors border border-gray-700">
                        Save Draft
                    </button>
                    <button wire:click="save('published')" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium py-2 rounded-lg transition-colors shadow-lg shadow-amber-500/20">
                        Publish
                    </button>
                </div>
            </div>
        </div>

        <!-- ── Categorization ──────────────────────────────────────────── -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Categorization</h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Category</label>
                    <select wire:model="category_id" class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 text-sm focus:border-amber-500 outline-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Tags</label>
                    <div class="flex flex-wrap gap-1.5 p-2 bg-gray-950 border border-gray-800 rounded-lg min-h-[42px]">
                        @foreach($tags as $index => $tag)
                            <span class="inline-flex items-center gap-1 bg-amber-500/20 text-amber-400 text-xs px-2 py-0.5 rounded-full">
                                #{{ $tag }}
                                <button type="button" wire:click="removeTag({{ $index }})" class="hover:text-red-400 leading-none">×</button>
                            </span>
                        @endforeach
                        <input type="text"
                               x-on:keydown.enter.prevent="$wire.addTag($event.target.value); $event.target.value=''"
                               placeholder="Add tag & Enter..."
                               class="bg-transparent text-xs text-white outline-none flex-1 min-w-[100px]">
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Featured Image ──────────────────────────────────────────── -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Featured Image</h3>
            </div>
            <div class="p-5">
                <div class="border-2 border-dashed border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-center relative hover:border-amber-500 hover:bg-gray-800/30 transition-all group">
                    <input type="file" wire:model="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    @if($image)
                        <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-lg mb-2 shadow-lg">
                        <p class="text-xs text-amber-500 font-medium">Image selected ✓</p>
                    @elseif($this->getExistingImageUrl())
                        <img src="{{ $this->getExistingImageUrl() }}" class="w-24 h-24 object-cover rounded-lg mb-2 shadow-lg">
                        <p class="text-xs text-gray-400">Click to change</p>
                    @else
                        <svg class="w-8 h-8 text-gray-500 mb-2 group-hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <p class="text-xs font-medium text-white mb-1">Drag & Drop or Click</p>
                        <p class="text-[10px] text-gray-500">PNG, JPG, WEBP — max 2MB</p>
                    @endif
                </div>
                <div wire:loading wire:target="image" class="text-amber-500 text-xs mt-2 font-medium text-center">
                    ⌛ Uploading...
                </div>
            </div>
        </div>

        <!-- ── SEO ─────────────────────────────────────────────────────── -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">SEO</h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Meta Title</label>
                    <input type="text" wire:model.live.debounce.500ms="meta_title"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Meta Description</label>
                    <textarea wire:model.live.debounce.500ms="meta_description" rows="2"
                              class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Focus Keyword</label>
                    <input type="text" wire:model.live.debounce.500ms="focus_keyword" x-model="keyword"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Canonical URL</label>
                    <input type="text" wire:model="canonical_url"
                           class="w-full bg-gray-950 border border-gray-800 text-gray-400 rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none">
                </div>

                <div class="pt-2 border-t border-gray-800 space-y-3">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-[10px] text-gray-500">Visual SEO Score</span>
                            <span class="text-[10px] font-bold" :class="seoScore>60?'text-emerald-400':(seoScore>30?'text-amber-400':'text-red-400')" x-text="seoScore+'/100'"></span>
                        </div>
                        <div class="w-full bg-gray-800 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full transition-all duration-500"
                                 :class="seoScore>60?'bg-emerald-500':(seoScore>30?'bg-amber-500':'bg-red-500')"
                                 :style="'width:'+seoScore+'%'"></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <p class="text-[10px] text-gray-500 mb-1">Readability</p>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" :class="wordCount>300?'bg-emerald-500':(wordCount>100?'bg-amber-500':'bg-red-500')"></div>
                                <span class="text-xs font-semibold text-white" x-text="wordCount>300?'Good':(wordCount>100?'Ok':'Needs Work')"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Statistics Widget ────────────────────────────────────────── -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Statistics</h3>
            </div>
            <div class="p-5 grid grid-cols-2 gap-3">
                <div class="bg-gray-950 border border-gray-800 rounded-lg p-3">
                    <p class="text-[10px] text-gray-500 mb-1">Word Count</p>
                    <p class="text-xl font-bold text-white" x-text="wordCount"></p>
                    <p class="text-[10px] text-gray-500">words</p>
                </div>
                <div class="bg-gray-950 border border-gray-800 rounded-lg p-3">
                    <p class="text-[10px] text-gray-500 mb-1">Reading Time</p>
                    <p class="text-xl font-bold text-white" x-text="Math.max(1, Math.ceil(wordCount/200))"></p>
                    <p class="text-[10px] text-gray-500">minutes</p>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
(function() {
    // Register articleEditor BEFORE Alpine starts — use document.addEventListener('alpine:init')
    // @@entangle works here because Livewire compiles this Blade view first
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

    // Register via alpine:init (fires before Alpine initializes components)
    document.addEventListener('alpine:init', registerArticleEditor);

    // Quill setup
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof Quill === 'undefined' || !document.getElementById('quill-editor')) return;

        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Tulis isi artikel di sini...',
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

                                        // Compress to JPEG 70% to prevent Nginx 413 error
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

        // Init preview with existing content
        const previewEl = document.getElementById('preview-content');
        const previewEmpty = document.getElementById('preview-empty');
        function updatePreview(html) {
            if (previewEl) {
                previewEl.innerHTML = html || '';
                if (previewEmpty) {
                    previewEmpty.style.display = html ? 'none' : 'block';
                    previewEl.style.display = html ? '' : 'none';
                }
            }
        }
        updatePreview(existingContent);

        quill.on('text-change', () => {
            let html = quill.root.innerHTML;
            if (html === '<p><br></p>') html = '';

            // Live update preview window
            updatePreview(html);

            // Sync to Livewire
            try {
                const wireEl = document.querySelector('[wire\\:id]');
                if (wireEl) {
                    const wireId = wireEl.getAttribute('wire:id');
                    const component = Livewire.find(wireId);
                    if (component) component.set('content', html);
                }
            } catch(e) { /* silent */ }

            // Sync wordCount to Alpine
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
            } catch(e) { /* silent */ }
        });
    });

    // Flatpickr
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('datePicker') && typeof flatpickr !== 'undefined') {
            flatpickr("#datePicker", {
                dateFormat: "Y-m-d",
                defaultDate: "{{ $published_at ?? now()->format('Y-m-d') }}"
            });
        }
    });
})();
</script>
@endpush
