@section('title', 'Categories')
@section('page-title', 'Categories')

<div class="flex flex-col md:flex-row gap-6">
    
    <!-- Left: Form -->
    <div class="w-full md:w-1/3">
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">{{ $isEdit ? 'Edit Category' : 'Create Category' }}</h3>
            </div>
            <div class="p-5 space-y-4">
                @if(session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Category Name</label>
                    <input type="text" wire:model.live.debounce.500ms="name"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:border-amber-500 outline-none transition-colors">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Slug</label>
                    <input type="text" wire:model="slug"
                           class="w-full bg-gray-950 border border-gray-800 text-gray-400 rounded-lg px-4 py-2 focus:border-amber-500 outline-none transition-colors">
                    @error('slug') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button wire:click="save" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 rounded-lg transition-colors">
                        {{ $isEdit ? 'Update' : 'Save' }}
                    </button>
                    @if($isEdit)
                        <button wire:click="cancel" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 rounded-lg transition-colors border border-gray-700">
                            Cancel
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Table -->
    <div class="w-full md:w-2/3">
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-950/50 text-gray-400 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 font-medium">Name</th>
                            <th class="px-6 py-4 font-medium">Slug</th>
                            <th class="px-6 py-4 font-medium">Articles</th>
                            <th class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 text-gray-300">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-800/50 transition">
                                <td class="px-6 py-4 font-medium text-white">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $category->slug }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-800 text-gray-300 px-2.5 py-0.5 rounded-full text-xs border border-gray-700">
                                        {{ $category->articles_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="edit({{ $category->id }})" class="text-gray-400 hover:text-amber-500 transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="delete({{ $category->id }})" wire:confirm="Delete this category?" class="text-gray-400 hover:text-red-500 transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
