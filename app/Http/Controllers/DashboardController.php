<?php

namespace App\Http\Controllers;

use App\Http\Resources\{NotificationResource, ProductResource, SalesDetailsResource};
use App\Models\{ Customer, Product, PurchaseOrders, Sale, SaleDetail, Notification, Comment};
use Inertia\Inertia;
// use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
        $notifications = $user->unreadNotifications; // Get unread notifications

        // Get total revenue for the current week (from start of this week)
        $currentWeekRevenue = Sale::where('sale_date', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)'))
            ->sum('grand_total');
        // Get total revenue for the last week (from start of last week to the start of this week)
        $lastWeekRevenue = Sale::where('sale_date', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY)'))
            ->where('sale_date', '<', DB::raw('DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)'))
            ->sum('grand_total');
        // Calculate percentage change
        $percentageChange = 0;
        if ($lastWeekRevenue > 0) {
            $percentageChange = (($currentWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100;
        }
        // Get best-selling products
        $bestSellingProducts = SaleDetail::with(['product.category'])
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity_sold'), DB::raw('SUM(total) as total_sales'))
            ->groupBy('product_id')
            ->orderBy('total_sales', 'DESC') // Order by total_sales for accurate percentage calculation
            ->limit(6)
            ->get();
        // Step to find the highest total sales for calculating percentages
        $highestTotalSales = $bestSellingProducts->max('total_sales');
        // Calculate sales percentages
        $bestSellingProducts->transform(function ($product) use ($highestTotalSales) {
            $product->sales_percentage = $highestTotalSales > 0
                ? round(($product->total_sales / $highestTotalSales) * 100, 2)
                : '%0';
            return $product;
        });

        return Inertia::render('Dashboard', [
            'notifications' => [
                'today' => NotificationResource::collection(Notification::with('user')->whereDate('created_at', now())->get()),
                'yesterday' => NotificationResource::collection(Notification::with('user')->whereDate('created_at', now()->subDay())->get()),
                'last_week' => NotificationResource::collection(Notification::with('user')->whereBetween('created_at', [now()->subDays(7), now()])->get()),
            ],
            'comments' => [
                'unread' => Comment::where('is_read', 0)->count(),
                'responded' => Comment::where('is_responded', 0)->count(),
            ],

            'product' => ProductResource::collection(Product::all()),
            'best_selling' => SalesDetailsResource::collection($bestSellingProducts),
            'sale_revenue' => [
                'revenue' => (float)$currentWeekRevenue,
                'revenue_percentage_change' => number_format($percentageChange, 2), // Percentage change since last week
            ],
            'customers' => [
                'total_customer' => Customer::count(),
                'new_customer' => Customer::where('registered_at', '>=', now()->subWeek())->count(),
            ],
            'purchase_orders' => [
                'orders' => PurchaseOrders::count(),
                'pending' => PurchaseOrders::where('status', 'Pending')->count(),
            ],
        ]);
    }
}
