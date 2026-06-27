<?php

namespace App\Livewire\Admin\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileManager extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $photo;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'photo' => ['nullable', 'image', 'max:10240'], // 10MB Max
        ]);

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'updated_profile',
            'description' => $user->name . ' memperbarui profil mereka.'
        ]);

        session()->flash('success_profile', 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak cocok.');
            return;
        }

        $user->forceFill([
            'password' => Hash::make($this->password),
        ])->save();

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'updated_password',
            'description' => $user->name . ' mengubah password.'
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('success_password', 'Password berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.admin.profile.profile-manager')->layout('layouts.admin');
    }
}
