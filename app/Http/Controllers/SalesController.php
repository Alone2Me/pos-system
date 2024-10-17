<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesResource;
use App\Models\{Sale, Product};
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index()
    {
        return Inertia::render('Sales/Index', [
            'sales' => SalesResource::collection(Sale::all()),
        ]);
    }
    public function create()
    {
        $products = Product::all();
        return Inertia::render('Sales/Create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required',
            'products' => 'required|array',
            'total_amount' => 'required|numeric',
        ]);

        $sale = Sale::create($validated);
        // Save sale details logic here

        return redirect()->route('sales.index');
    }

    public function show($id)
    {
        $sale = Sale::with('salesDetails', 'customer')->findOrFail($id);
        return Inertia::render('Sales/Show', ['sale' => $sale]);
    }

    public function destroy($id)
    {
        Sale::findOrFail($id)->delete();
        return redirect()->route('sales.index');
    }
}
