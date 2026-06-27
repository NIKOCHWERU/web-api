<?php

namespace App\Livewire\Admin\Components;

use App\Models\ActivityLog;
use Livewire\Component;

class NotificationDropdown extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        // Fetch latest 5 activity logs as notifications
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        // For demo purposes, we will treat all recent logs as unread
        $this->unreadCount = $logs->count();

        $this->notifications = $logs->map(function ($log) {
            return [
                'id' => $log->id,
                'userName' => $log->user ? $log->user->name : 'System',
                'userImage' => $log->user ? $log->user->profile_photo_url : '/images/user/owner.png',
                'action' => $log->action,
                'project' => $log->description,
                'type' => 'Activity',
                'time' => $log->created_at->diffForHumans(),
                'status' => 'online', // dummy status
            ];
        })->toArray();
    }

    public function markAsRead()
    {
        $this->unreadCount = 0;
    }

    public function render()
    {
        return view('livewire.admin.components.notification-dropdown');
    }
}
