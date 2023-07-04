<?php

use App\Http\Controllers\HotelSearch;
use Illuminate\Support\Facades\Route;

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

Route::get('hotel-search', [HotelSearch::class, 'processAddress'])->name('hotel-search');
Route::resource('/', HotelSearch::class);


