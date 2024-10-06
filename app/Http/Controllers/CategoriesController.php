<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ProductResource;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index',
    [
        'categories'=>CategoriesResource::collection(Categories::all()),
        'product'=>ProductResource::collection(Products::all())
    ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store()
    {
        Categories::create(
            Request::validate([
                'category_name' => 'required|unique:categories|max:150',
                'description' => 'nullable|max:255',
            ])
        );
        return Redirect::back();
    }
}
