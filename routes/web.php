<?php

use App\Http\Controllers\LocalNewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RbcNewsController;
use League\Flysystem\Adapter\Local;

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

Route::get('/', [LocalNewsController::class, 'index'])->name('news.index');
Route::get('/{id}', [LocalNewsController::class, 'show']);
Route::post('/getRbcNews', [RbcNewsController::class, 'index'])->name('getrbcnews.index');
