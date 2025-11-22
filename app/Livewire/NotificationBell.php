<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationBell extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        // Get latest 5 unread notifications
        $this->notifications = auth()->user()->notifications()
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $this->unreadCount = auth()->user()->notifications()->unread()->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()
            ->unread()
            ->update(['read_at' => now()]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
