<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class ContactManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = ''; // '' | 'unread' | 'read'
    public $selectedContact = null;

    public function updatingSearch() { $this->resetPage(); }

    public function view($id)
    {
        $this->selectedContact = Contact::findOrFail($id);
        if (!$this->selectedContact->read_at) {
            $this->selectedContact->markAsRead();
            $this->selectedContact->refresh();
        }
    }

    public function closeDetail()
    {
        $this->selectedContact = null;
    }

    public function delete($id)
    {
        Contact::findOrFail($id)->delete();
        $this->selectedContact = null;
        session()->flash('success', 'Contact deleted.');
    }

    public function render()
    {
        $contacts = Contact::query()
            ->when($this->search, fn($q) => $q->where('name','like','%'.$this->search.'%')
                ->orWhere('email','like','%'.$this->search.'%')
                ->orWhere('subject','like','%'.$this->search.'%'))
            ->when($this->filter === 'unread', fn($q) => $q->whereNull('read_at'))
            ->when($this->filter === 'read',   fn($q) => $q->whereNotNull('read_at'))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.contacts.contact-manager', [
            'contacts' => $contacts,
            'totalUnread' => Contact::whereNull('read_at')->count(),
        ])->layout('layouts.admin');
    }
}
