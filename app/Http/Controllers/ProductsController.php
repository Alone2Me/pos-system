<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ProductResource;
use App\Models\{Category,Product};
use Illuminate\Support\Facades\Redirect;
use App\Models\User; // Assuming the store manager is a user
use App\Notifications\LowInventoryNotification;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Products/Index',[
            'products'=>ProductResource::collection(Product::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/Create', [
            'categories' => CategoriesResource::collection(Category::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => ['required', 'unique:products,product_name', 'max:50'],
            'category_id' => ['required', 'exists:categories,id'], // Ensures category exists
            'description' => ['nullable', 'max:100'],
            // 'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validate image type and size
            'price' => ['required', 'numeric'], // Ensures price is numeric
            'sku' => ['required', 'unique:products,sku', 'max:50'], // Ensures SKU is unique
        ]);

        Product::create($validatedData);

        return Redirect::back();
    }
    public function checkInventory(Product $product)
    {
        $lowStockThreshold = 10;

        if ($product->quantity < $lowStockThreshold) {
            $storeManager = User::find(1); // Replace with logic to find the appropriate user

            // Send the notification
            $storeManager->notify(new LowInventoryNotification($product, $product->quantity, 'high'));
        }

        return redirect()->back();
    }
}
