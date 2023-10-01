<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AdminTopBar extends Component
{
    protected $notifications;
    protected $unreadCount;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $admin = Auth::guard('admin')->user();
        $this->notifications = Auth::guard('admin')->user()->unreadNotifications;
        $this->unreadCount = Auth::guard('admin')->user()->unreadNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-top-bar',
            ['notifications' => $this->notifications,
                'unread_notifications_count' => $this->unreadCount
            ]);
    }
}
