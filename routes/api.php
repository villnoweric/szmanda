<?php

use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Route;
use App\Services\ProductInjestService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/injest', function () {
        $content = request()->json()->all();
        
        $serv = new ProductInjestService;
        $rsp = $serv->injest($content);
        return $rsp;
        
    
});
Route::get('/injest', function () {
    $content = request()->all();
    $serv = new ProductInjestService;
    $serv->injest($content);
    return "";

});