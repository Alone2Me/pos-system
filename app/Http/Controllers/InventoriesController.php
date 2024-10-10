<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventoriesResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoriesController extends Controller
{
    public function index()
    {
        return Inertia::render('Inventories/Index', [
            'inventories' => InventoriesResource::collection(Inventory::all())
        ]);
    }
}
