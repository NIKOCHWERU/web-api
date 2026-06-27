@section('title', 'Users')
@section('page-title', 'Users')

@section('breadcrumb')
    <li class="text-brand-500">
        <span class="mx-1 text-gray-500">/</span>
        Users
    </li>
@endsection

<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h3 class="text-title-sm font-bold text-gray-800 dark:text-white/90">User Management</h3>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add User
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 flex w-full border-l-4 border-success-500 bg-success-50 px-4 py-3 shadow-sm dark:bg-success-500/15">
            <p class="text-sm text-success-600 dark:text-success-500">
                {{ session('success') }}
            </p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 flex w-full border-l-4 border-error-500 bg-error-50 px-4 py-3 shadow-sm dark:bg-error-500/15">
            <p class="text-sm text-error-600 dark:text-error-500">
                {{ session('error') }}
            </p>
        </div>
    @endif

    <!-- Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 text-left dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">User</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Role</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm">Joined</th>
                        <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-sm text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-800 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                        <img src="{{ $user->profile_photo_url }}" class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium uppercase tracking-wide
                                    {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400' : 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400' }}">
                                    {{ $user->role ?? 'editor' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $user->id }})" class="text-brand-500 hover:text-brand-600 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if(auth()->id() !== $user->id)
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Delete this user?" class="text-error-500 hover:text-error-600 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    <div x-data="{ open: @entangle('showModal') }" 
         x-show="open" 
         style="display: none;" 
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-0">
        
        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false; $wire.cancel()"></div>
        
        <!-- Modal Content -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900 overflow-hidden transform transition-all">
             
            <!-- Header -->
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit User' : 'Create User' }}</h3>
                <button wire:click="cancel" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input type="text" wire:model="name"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
                    @error('name') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <input type="email" wire:model="email"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
                    @error('email') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Password <span class="text-gray-400 text-xs font-normal ml-1">{{ $isEdit ? '(Leave blank to keep current)' : '' }}</span></label>
                    <input type="password" wire:model="password"
                           class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors">
                    @error('password') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <div class="relative">
                        <select wire:model="role" class="w-full rounded-lg border border-gray-200 bg-transparent dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-800 dark:text-white/90 transition-colors appearance-none">
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </div>
                    @error('role') <span class="text-error-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 dark:border-gray-800 dark:bg-gray-900 flex justify-end gap-3">
                <button wire:click="cancel" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700/80 transition-colors">
                    Cancel
                </button>
                <button wire:click="save" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors flex items-center gap-2 shadow-sm">
                    <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Update User' : 'Save User' }}</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
