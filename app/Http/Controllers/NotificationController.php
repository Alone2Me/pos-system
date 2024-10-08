<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications; // Get unread notifications

        return Inertia::render('Notifications', [
            'notifications' => $notifications,
        ]);
    }
}
