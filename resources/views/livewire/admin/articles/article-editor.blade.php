@section('title', $article ? 'Edit Article' : 'Create Article')
@section('page-title', $article ? 'Edit Article' : 'Create Article')

@section('breadcrumb')
    <span class="mx-1">/</span>
    <a href="{{ route('admin.articles.index') }}" class="hover:text-amber-400">Articles</a>
    <span class="mx-1">/</span>
    <span class="text-white">{{ $article ? 'Edit' : 'Create' }}</span>
@endsection

<div class="flex flex-col lg:flex-row gap-6 relative" x-data="articleEditor()">
    
    <!-- ── LEFT COLUMN (70%) ────────────────────────────────────────────── -->
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
                          placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit..."></textarea>
            </div>
        </div>

        <!-- Section: Rich Editor -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden" wire:ignore>
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Rich Editor</h3>
            </div>
            <div class="p-0">
                <div id="quill-editor" class="text-white"></div>
            </div>
        </div>
        @error('content') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror

        <!-- Section: Published Articles -->
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 text-gray-300">
                        @foreach($recentArticles as $recent)
                            <tr class="hover:bg-gray-800/50">
                                <td class="px-5 py-3 truncate max-w-[200px]">{{ $recent->title }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-wide">
                                        {{ $recent->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">{{ $recent->category?->name ?? '-' }}</td>
                                <td class="px-5 py-3">{{ $recent->updated_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ── RIGHT COLUMN (30% STICKY) ────────────────────────────────────── -->
    <div class="w-full lg:w-4/12 flex flex-col gap-6">
        
        <!-- Live Preview Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden sticky top-24">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Preview Artikel Card</h3>
            </div>
            <div class="p-5">
                <!-- Mockup Preview Card -->
                <div class="bg-gray-950 rounded-lg overflow-hidden border border-gray-800 shadow-inner group">
                    <div class="h-32 bg-gray-800 relative overflow-hidden">
                        @if($existingImage && !$image)
                            <img src="{{ Storage::url($existingImage) }}" class="w-full h-full object-cover">
                        @elseif($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-600">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-2 left-2 flex gap-1">
                            <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">Highlight News</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="text-base font-bold text-white leading-tight mb-1" x-text="title || 'Judul Artikel'"></h4>
                        <div class="flex items-center gap-2 text-[10px] text-gray-400 mb-2">
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 rounded-full bg-amber-500 flex items-center justify-center text-white text-[8px]">{{ substr(auth()->user()->name, 0, 1) }}</div>
                                <span>{{ auth()->user()->name }}</span>
                            </div>
                            <span>•</span>
                            <span>{{ now()->format('M d, Y') }}</span>
                        </div>
                        <p class="text-xs text-gray-400 line-clamp-3 leading-relaxed" x-text="summary || 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...'"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publish -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Publish</h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-2">Status</label>
                    <div class="flex rounded-lg border border-gray-800 overflow-hidden bg-gray-950 p-1">
                        <button type="button" wire:click="$set('status', 'draft')" class="flex-1 text-xs py-1.5 font-medium rounded-md transition-colors {{ $status === 'draft' ? 'bg-gray-800 text-white' : 'text-gray-500 hover:text-gray-300' }}">Draft</button>
                        <button type="button" wire:click="$set('status', 'review')" class="flex-1 text-xs py-1.5 font-medium rounded-md transition-colors {{ $status === 'review' ? 'bg-amber-500/20 text-amber-500' : 'text-gray-500 hover:text-gray-300' }}">Review</button>
                        <button type="button" wire:click="$set('status', 'published')" class="flex-1 text-xs py-1.5 font-medium rounded-md transition-colors {{ $status === 'published' ? 'bg-emerald-500/20 text-emerald-500' : 'text-gray-500 hover:text-gray-300' }}">Published</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Publish Date</label>
                    <input type="text" wire:model="published_at" id="datePicker"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 text-sm focus:border-amber-500 outline-none">
                </div>

                <div class="flex gap-2 pt-2">
                    <button wire:click="save('draft')" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium py-2 rounded-lg transition-colors border border-gray-700">Save Draft</button>
                    <button wire:click="save('published')" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium py-2 rounded-lg transition-colors shadow-lg shadow-amber-500/20">Publish</button>
                </div>
            </div>
        </div>

        <!-- Categorization -->
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
                            <span class="tag-chip">
                                #{{ $tag }}
                                <button type="button" wire:click="removeTag({{ $index }})" class="hover:text-red-400 ml-1">×</button>
                            </span>
                        @endforeach
                        <input type="text" x-on:keydown.enter.prevent="$wire.addTag($event.target.value); $event.target.value=''"
                               placeholder="Add tag..." class="bg-transparent text-sm text-white outline-none flex-1 min-w-[80px]">
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">Featured Image</h3>
            </div>
            <div class="p-5">
                <div class="border-2 border-dashed border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-center relative hover:border-amber-500 hover:bg-gray-800/50 transition-all group">
                    <input type="file" wire:model="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    
                    @if($image)
                        <img src="{{ $image->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg mb-2 shadow-lg">
                        <p class="text-xs text-amber-500 font-medium">Image selected</p>
                    @elseif($existingImage)
                        <img src="{{ Storage::url($existingImage) }}" class="w-20 h-20 object-cover rounded-lg mb-2 shadow-lg">
                        <p class="text-xs text-gray-400">Click to change image</p>
                    @else
                        <svg class="w-8 h-8 text-gray-500 mb-2 group-hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <p class="text-xs font-medium text-white mb-1">Drag & Drop or Click</p>
                        <p class="text-[10px] text-gray-500">Max file size 2MB</p>
                    @endif
                </div>
                <div wire:loading wire:target="image" class="text-amber-500 text-xs mt-2 font-medium">Uploading...</div>
            </div>
        </div>

        <!-- SEO -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">SEO</h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Meta Title</label>
                    <input type="text" wire:model.live.debounce.500ms="meta_title" class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Meta Description</label>
                    <textarea wire:model.live.debounce.500ms="meta_description" rows="2" class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Focus Keyword</label>
                    <input type="text" wire:model.live.debounce.500ms="focus_keyword" x-model="keyword" class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:border-amber-500 outline-none">
                </div>
                
                <!-- Simple Alpine based SEO indicator -->
                <div class="flex gap-4 pt-2 border-t border-gray-800">
                    <div class="flex-1">
                        <p class="text-[10px] text-gray-500 mb-1">Visual SEO Score</p>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full" :class="seoScore > 60 ? 'bg-emerald-500' : (seoScore > 30 ? 'bg-amber-500' : 'bg-red-500')"></div>
                            <span class="text-sm font-bold text-white" x-text="seoScore + '/100'"></span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] text-gray-500 mb-1">Readability</p>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                            <span class="text-sm font-bold text-white">Good</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widgets -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-white">Statistics</h3>
            </div>
            <div class="p-5 grid grid-cols-2 gap-4">
                <div class="bg-gray-950 border border-gray-800 rounded-lg p-3">
                    <p class="text-[10px] text-gray-500 mb-1">Word Count</p>
                    <p class="text-lg font-bold text-white" x-text="wordCount + ' words'"></p>
                </div>
                <div class="bg-gray-950 border border-gray-800 rounded-lg p-3">
                    <p class="text-[10px] text-gray-500 mb-1">Reading Time</p>
                    <p class="text-lg font-bold text-white" x-text="Math.max(1, Math.ceil(wordCount / 200)) + ' mins'"></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Flatpickr Init
    flatpickr("#datePicker", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ $published_at ?? now()->format('Y-m-d') }}"
    });

    // Alpine component for live preview syncing
    document.addEventListener('alpine:init', () => {
        Alpine.data('articleEditor', () => ({
            title: @entangle('title'),
            summary: @entangle('summary'),
            keyword: @entangle('focus_keyword'),
            wordCount: 0,
            
            get seoScore() {
                let score = 20; // base score
                if(this.title && this.keyword && this.title.toLowerCase().includes(this.keyword.toLowerCase())) score += 30;
                if(this.summary && this.summary.length > 50) score += 20;
                if(this.wordCount > 300) score += 30;
                return Math.min(100, score);
            }
        }));
    });

    // Quill Editor Init
    document.addEventListener("DOMContentLoaded", () => {
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Tulis isi artikel di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Load existing content
        const existingContent = `{!! $content ?? '' !!}`;
        if(existingContent) {
            quill.root.innerHTML = existingContent;
        }

        // Sync Quill to Livewire
        quill.on('text-change', function() {
            let html = quill.root.innerHTML;
            if(html === '<p><br></p>') html = '';
            @this.set('content', html);
            
            // Dispatch event to update alpine word count
            let text = quill.getText().trim();
            let words = text.length > 0 ? text.split(/\s+/).length : 0;
            const event = new CustomEvent('update-word-count', { detail: words });
            window.dispatchEvent(event);
        });

        // Listen for word count update
        window.addEventListener('update-word-count', (e) => {
            const data = Alpine.$data(document.querySelector('[x-data="articleEditor()"]'));
            if(data) data.wordCount = e.detail;
        });
    });
</script>
@endpush
