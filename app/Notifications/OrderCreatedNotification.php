<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public Order $order;
    public $admins;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $admins)
    {
        $this->order = $order;
        $this->admins = $admins;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function broadcastOn(): array
    {
        foreach ($this->admins as $admin) {
            $channels[] = new PrivateChannel('App.Models.Admin.' . $admin->id);
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'order-create';
    }

    public function toDatabase($notifiable): array
    {
        $address = $this->order->billingAddress;
        return [
            'body' => "A new order #{$this->order->number} created by {$address->name} from {$address->country_name}",
            'icon' => 'fas fa-envelope mr-2',
            'url' => url('/admin/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        info('Pusher');
        $address = $this->order->billingAddress;
        return new BroadcastMessage(
            [
                'body' => "A new order #{$this->order->number} created by {$address->name} from {$address->country_name}",
                'icon' => 'fas fa-envelope mr-2',
                'url' => url('/admin/dashboard'),
                'order_id' => $this->order->id,
            ]);
    }


}
