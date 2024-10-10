<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{DashboardController, NotificationController, CategoriesController, CustomersController, InventoriesController, ProductsController, SalesController};

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/formlayout', function () {
        return Inertia::render('Uikit/FormLayout');
    })->name('uikit.formlayout');
    Route::get('/input', function () {
        return Inertia::render('Uikit/InputDoc');
    })->name('uikit.input');
    Route::get('/button', function () {
        return Inertia::render('Uikit/ButtonDoc');
    })->name('uikit.button');
    Route::get('/table', function () {
        return Inertia::render('Uikit/TableDoc');
    })->name('uikit.table');
    Route::get('/list', function () {
        return Inertia::render('Uikit/ListDoc');
    })->name('uikit.list');
    Route::get('/tree', function () {
        return Inertia::render('Uikit/TreeDoc');
    })->name(name: 'uikit.tree');
    Route::get('/panel', function () {
        return Inertia::render('Uikit/PanelsDoc');
    })->name(name: 'uikit.panel');
    Route::get('/overlay', function () {
        return Inertia::render('Uikit/OverlayDoc');
    })->name('uikit.overlay');
    Route::get('/media', function () {
        return Inertia::render('Uikit/MediaDoc');
    })->name('uikit.media');
    Route::get('/menu', function () {
        return Inertia::render('Uikit/MenuDoc');
    })->name('uikit.menu');
    Route::get('/message', function () {
        return Inertia::render('Uikit/MessagesDoc');
    })->name('uikit.message');
    Route::get('/file', function () {
        return Inertia::render('Uikit/FileDoc');
    })->name('uikit.file');
    Route::get('/chart', function () {
        return Inertia::render('Uikit/ChartDoc');
    })->name('uikit.chart');
    Route::get('/timeline', function () {
        return Inertia::render('Uikit/TimelineDoc');
    })->name('uikit.timeline');
    Route::get('/misc', function () {
        return Inertia::render('Uikit/MiscDoc');
    })->name('uikit.misc');
    Route::get('/empty', function () {
        return Inertia::render('Uikit/EmptyDoc');
    })->name('uikit.empty');
    Route::resource('sales', SalesController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    route::resource('inventories',InventoriesController::class);
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
});
