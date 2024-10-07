<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class LowInventoryNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $quantity;

    public function __construct($product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function via($notifiable)
    {
        // Store the notification in the database
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Data to be stored in the notifications table
        return [
            'product_name' => $this->product->name,
            'current_quantity' => $this->quantity,
            'message' => 'The inventory for ' . $this->product->name . ' is running low. Only ' . $this->quantity . ' items are left in stock.',
        ];
    }
}
