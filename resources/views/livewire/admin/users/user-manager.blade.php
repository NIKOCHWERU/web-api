@section('title', 'Users')
@section('page-title', 'Users')

<div>
    @section('header-actions')
        <button wire:click="create" class="bg-amber-500 hover:bg-amber-600 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors shadow-lg shadow-amber-500/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add User
        </button>
    @endsection

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg text-sm mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg text-sm mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="w-full bg-gray-900 border border-gray-800 rounded-xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-950/50 text-gray-400 border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Role</th>
                        <th class="px-6 py-4 font-medium">Joined</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-gray-300">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center overflow-hidden">
                                        <img src="{{ $user->profile_photo_url }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide
                                    {{ $user->role === 'admin' ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
                                    {{ $user->role ?? 'editor' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $user->id }})" class="text-gray-400 hover:text-amber-500 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if(auth()->id() !== $user->id)
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Delete this user?" class="text-gray-400 hover:text-red-500 transition">
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
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        
        <!-- Backdrop -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false; $wire.cancel()"></div>
        
        <!-- Modal Content -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-md shadow-2xl relative z-10 overflow-hidden">
             
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-800 bg-gray-950/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">{{ $isEdit ? 'Edit User' : 'Create User' }}</h3>
                <button wire:click="cancel" class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Full Name</label>
                    <input type="text" wire:model="name"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-colors">
                    @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" wire:model="email"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-colors">
                    @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Password <span class="text-gray-500 text-xs">{{ $isEdit ? '(Leave blank to keep current)' : '' }}</span></label>
                    <input type="password" wire:model="password"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-colors">
                    @error('password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Role</label>
                    <select wire:model="role" class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-colors">
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                    @error('role') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-800 bg-gray-950/50 flex gap-3 justify-end">
                <button wire:click="cancel" class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors border border-gray-700">
                    Cancel
                </button>
                <button wire:click="save" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Update User' : 'Save User' }}</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>
