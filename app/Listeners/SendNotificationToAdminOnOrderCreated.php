<?php

namespace App\Listeners;

use App\Events\OrderCreate;
use App\Models\Admin;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationToAdminOnOrderCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreate $event): void
    {
        $order = $event->order;
        $admins = Admin::get();
        Notification::send($admins, new OrderCreatedNotification($order, $admins));
    }
}
