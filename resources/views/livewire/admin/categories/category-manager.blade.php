@section('title', 'Categories')
@section('page-title', 'Categories')

@section('breadcrumb')
    <li class="text-brand-500">
        <span class="mx-1 text-gray-500">/</span>
        Categories
    </li>
@endsection

<div class="flex flex-col md:flex-row gap-6">
    
    <!-- Left: Form -->
    <div class="w-full md:w-1/3">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Category' : 'Create Category' }}</h3>
            </div>
            <div class="p-6 flex flex-col gap-5">
                @if(session('success'))
                    <div class="flex w-full border-l-4 border-success-500 bg-success-50 px-4 py-3 shadow-sm dark:bg-success-500/15 mb-2">
                        <p class="text-sm text-success-600 dark:text-success-500">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                    <input type="text" wire:model.live.debounce.500ms="name" placeholder="Enter category name"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
                    @error('name') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                    <input type="text" wire:model="slug" placeholder="category-slug"
                           class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 outline-none focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 transition-colors">
                    @error('slug') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-2 mt-2">
                    <button wire:click="save" class="flex-1 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm">
                        {{ $isEdit ? 'Update Category' : 'Save Category' }}
                    </button>
                    @if($isEdit)
                        <button wire:click="cancel" class="flex-1 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700/80 transition-colors">
                            Cancel
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Table -->
    <div class="w-full md:w-2/3">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-left dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Name</th>
                            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Slug</th>
                            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Articles</th>
                            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b border-gray-100 dark:border-gray-800 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white/90">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $category->slug }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                        {{ $category->articles_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="edit({{ $category->id }})" class="text-brand-500 hover:text-brand-600 transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="delete({{ $category->id }})" wire:confirm="Delete this category?" class="text-error-500 hover:text-error-600 transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
