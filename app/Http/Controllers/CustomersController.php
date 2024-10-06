<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomersController extends Controller
{
    public function index()
    {
        return Inertia::render('Customers/Index', [
            'customers' => CustomerResource::collection(Customer::all())
        ]);
    }
}
