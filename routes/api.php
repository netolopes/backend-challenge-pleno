<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('categoria')->group(function () {
    Route::get('/', [CategoriaController::class,'index']);
    Route::get('/show/{id}', [CategoriaController::class,'show']);
    Route::post('/create', [CategoriaController::class,'store']);
    Route::put('/edit', [CategoriaController::class,'update']);
    Route::delete('/delete', [CategoriaController::class,'destroy']);
});

Route::prefix('produtos')->group(function () {
    Route::get('/', [ProdutoController::class,'index']);
    Route::get('/show/{id}', [ProdutoController::class,'show']);
    Route::post('/create', [ProdutoController::class,'store']);
    Route::put('/edit', [ProdutoController::class,'update']);
    Route::delete('/delete', [ProdutoController::class,'destroy']);
});
