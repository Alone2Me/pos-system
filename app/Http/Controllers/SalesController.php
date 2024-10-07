<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesResource;
use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index(){
     return Inertia::render('Sales/Index',[
        'sales'=>SalesResource::collection(Sale::all()),
     ]);
    }

    public function store(Request $request){
        return 'hi';
    }
}
