@section('title', 'Users')
@section('page-title', 'Users')

<div class="flex flex-col md:flex-row gap-6">
    
    <!-- Left: Form -->
    <div class="w-full md:w-1/3">
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-950/30">
                <h3 class="text-sm font-semibold text-white">{{ $isEdit ? 'Edit User' : 'Create User' }}</h3>
            </div>
            <div class="p-5 space-y-4">
                @if(session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Full Name</label>
                    <input type="text" wire:model="name"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:border-amber-500 outline-none transition-colors">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Email Address</label>
                    <input type="email" wire:model="email"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:border-amber-500 outline-none transition-colors">
                    @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Password {{ $isEdit ? '(Leave blank to keep)' : '' }}</label>
                    <input type="password" wire:model="password"
                           class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:border-amber-500 outline-none transition-colors">
                    @error('password') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Role</label>
                    <select wire:model="role" class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2 focus:border-amber-500 outline-none transition-colors">
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                    @error('role') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
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
                                        <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white text-xs font-bold uppercase">
                                            {{ substr($user->name, 0, 1) }}
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
    </div>
</div>
