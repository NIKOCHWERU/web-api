<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserManager extends Component
{
    public $users;
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'editor';
    public $userId = null;
    public $isEdit = false;
    public $showModal = false;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::all();
    }

    public function create()
    {
        $this->reset(['name', 'email', 'password', 'role', 'userId', 'isEdit']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role ?? 'editor';
        $this->password = '';
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function cancel()
    {
        $this->reset(['name', 'email', 'password', 'role', 'userId', 'isEdit', 'showModal']);
    }

    public function save()
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->userId ?: 'NULL'),
            'role' => 'required|in:admin,editor',
        ];

        if (!$this->isEdit) {
            $rules['password'] = 'required|min:6';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            User::find($this->userId)->update($data);
            session()->flash('success', 'User updated successfully.');
        } else {
            User::create($data);
            session()->flash('success', 'User created successfully.');
        }

        $this->cancel();
        $this->loadUsers();
    }

    public function delete($id)
    {
        if (User::count() <= 1) {
            session()->flash('error', 'Cannot delete the last user.');
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.users.user-manager')->layout('layouts.admin');
    }
}
