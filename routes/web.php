<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Store;
use App\Models\PricePoint;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/about', function () {
    $products = Product::all();
    $stores = Store::all();
    $category = Category::all();
    $pricepoints = PricePoint::all();

    return view('about', [
        'products' => $products,
        'stores' => $stores,
        'pricepoints'=> $pricepoints,
        'category'=>$category
    ]);
});
Route::get('/', [ProductController::class, 'index']);
Route::get('/search', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);