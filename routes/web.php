<?php

use App\Http\Controllers\ProductController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', 'get-products');

Route::get('/get-products',[ProductController::class,'get_products'])->name('get_products');
Route::get('/get-product/{id}',[ProductController::class,'get_product'])->name('get_product');
Route::get('/add-product',[ProductController::class,'add_product'])->name('add_product');
Route::post('/store-product',[ProductController::class,'store_product'])->name('store_product');
Route::get('/edit-product/{id}',[ProductController::class,'edit_product'])->name('edit_product');
Route::post('/update-product/{id}',[ProductController::class,'update_product'])->name('update_product');
Route::get('/delete-product/{id}',[ProductController::class,'delete_product'])->name('delete_product');
Route::get('/get-sub-catagory/{catagory_id?}',[ProductController::class,'get_sub_catagory'])->name('get_sub_catagory');
