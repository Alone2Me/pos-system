<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowInventoryNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $quantity;
    protected $priority;

    public function __construct($product, $quantity, $priority = 'normal') 
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->priority = $priority;
    }

    public function via($notifiable)
    {
        return ['database']; // Store the notification in the database
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_name' => $this->product->name,
            'current_quantity' => $this->quantity,
            'message' => 'The inventory for ' . $this->product->name . ' is running low. Only ' . $this->quantity . ' items are left in stock.',
            'priority' => $this->priority,
        ];
    }
}
