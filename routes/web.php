<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $products = \App\Models\Product::with('category')->latest()->paginate(10);
    return Inertia::render('Dashboard', ['products' => $products]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products/create', function () {
    return Inertia::render('ProductForm', [
        'categories' => Category::all() // Передаем категории для выпадающего списка
    ]);
    })->name('products.create');

    // 2. Страница редактирования
    Route::get('/products/{product}/edit', function (Product $product) {
        return Inertia::render('ProductForm', [
            'product' => $product, // Передаем сам товар
            'categories' => Category::all()
        ]);
    })->name('products.edit');

    Route::post('/api/products', [\App\Http\Controllers\Api\ProductController::class, 'store']);
    Route::put('/api/products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
    Route::delete('/api/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    
});

require __DIR__.'/auth.php';
