<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-100">Pengaturan Profil</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Update Profile Info -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            
            <h3 class="text-lg font-semibold text-white mb-4">Informasi Profil</h3>
            
            @if (session()->has('success_profile'))
                <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success_profile') }}
                </div>
            @endif

            <form wire:submit.prevent="updateProfile" class="space-y-5">
                <!-- Profile Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <div class="relative bg-gray-800 border-2 border-gray-700 flex-shrink-0" style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden;">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ auth()->user()->profile_photo_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" wire:model="photo" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-gray-300 hover:file:bg-gray-700 cursor-pointer">
                            @error('photo') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full bg-gray-950 border border-gray-800 rounded-lg px-4 py-2.5 text-gray-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full bg-gray-950 border border-gray-800 rounded-lg px-4 py-2.5 text-gray-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
            
            <h3 class="text-lg font-semibold text-white mb-4">Ubah Password</h3>
            
            @if (session()->has('success_password'))
                <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success_password') }}
                </div>
            @endif

            <form wire:submit.prevent="updatePassword" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Password Saat Ini</label>
                    <input type="password" wire:model="current_password" class="w-full bg-gray-950 border border-gray-800 rounded-lg px-4 py-2.5 text-gray-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error('current_password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Password Baru</label>
                    <input type="password" wire:model="password" class="w-full bg-gray-950 border border-gray-800 rounded-lg px-4 py-2.5 text-gray-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" wire:model="password_confirmation" class="w-full bg-gray-950 border border-gray-800 rounded-lg px-4 py-2.5 text-gray-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                        <span wire:loading wire:target="updatePassword">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
