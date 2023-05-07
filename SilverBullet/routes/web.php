<?php

use Encore\Admin\Form\Row;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Add index and faq routes

Route::get('/faq', [App\Http\Controllers\Controller::class, 'faq'])->name('faq');

Auth::routes();

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Add tester routes
//Route::get('/tester', [App\Http\Controllers\TesterController::class, 'index'])->name('tester.index');

//Add contact routes
Route::get('/contact', [App\Http\Controllers\Controller::class, 'contact'])->name('contact');

//Add cart routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/shipping', [App\Http\Controllers\CartController::class, 'shipping'])->name('cart.shipping');
Route::post('/cart/shipping', [App\Http\Controllers\CartController::class, 'storeShipping'])->name('cart.storeShipping');
Route::get('/cart/payment', [App\Http\Controllers\CartController::class, 'payment'])->name('cart.payment');
Route::post('/cart/payment', [App\Http\Controllers\CartController::class, 'storePayment'])->name('cart.storePayment');
Route::get('/cart/overview', [App\Http\Controllers\CartController::class, 'overview'])->name('cart.overview');
Route::post('/cart/overview', [App\Http\Controllers\CartController::class, 'storeOverview'])->name('cart.storeOverview');
Route::get('/cart/success', [App\Http\Controllers\CartController::class, 'success'])->name('cart.success');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addItem'])->name('cart.addItem');
Route::post('/cart/item/{item_id}/add', [App\Http\Controllers\CartController::class, 'addItem'])->name('cart.addItem');
Route::post('/cart/item/{item_id}/update', [App\Http\Controllers\CartController::class, 'updateItem'])->name('cart.updateItem');
Route::post('/cart/item/{item_id}/remove', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.removeItem');


Route::get('/category/{id}', [App\Http\Controllers\CategoryController::class, 'subcategories_get'])->name('category.get');
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'categories_get'])->name('categories.get');
Route::middleware(['auth', 'is_admin'])->group(function () {
//Add admin routes
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/search', [App\Http\Controllers\AdminController::class, 'search'])->name('admin.search');
Route::get('/admin/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [App\Http\Controllers\AdminController::class, 'store_item'])->name('admin.store');
Route::get('/admin/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/delete/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');

Route::get('/admin/categories/search', [App\Http\Controllers\AdminController::class, 'categories_search'])->name('admin.categories_search');
Route::get('/admin/categories/create', [App\Http\Controllers\AdminController::class, 'categories_create'])->name('admin.categories_create');
Route::post('/admin/categories/store', [App\Http\Controllers\AdminController::class, 'categories_store'])->name('admin.categories_store');
//Route::get('/admin/categories/edit/{id}', [App\Http\Controllers\AdminController::class, 'categories_edit'])->name('admin.categories_edit');
//Route::post('/admin/categories/update/{id}', [App\Http\Controllers\AdminController::class, 'categories_update'])->name('admin.categories_update');
Route::delete('/admin/categories/destroy/{id}', [App\Http\Controllers\AdminController::class, 'categories_destroy'])->name('admin.categories_destroy');
Route::post('/admin/imageDelete', [App\Http\Controllers\AdminController::class, 'image_delete']);

Route::get('/admin/order/{id}', [App\Http\Controllers\AdminController::class, 'order_view'])->name('admin.order_view');
Route::delete('/admin/order/destroy/{id}', [App\Http\Controllers\AdminController::class, 'order_destroy'])->name('admin.order_destroy');

Route::get('/admin/image-upload', function () {return view('admin.imageUpload');});
Route::post('/admin/image-upload', [App\Http\Controllers\ImageUploadController::class, 'upload'])->name('image.upload');
Route::post('/admin/image-delete', [App\Http\Controllers\ImageUploadController::class, 'delete'])->name('image.delete');

// Add order routes
Route::post('/admin/orders/{id}/ship', [App\Http\Controllers\OrderController::class, 'markAsShipped'])->name('orders.ship');
Route::post('/admin/orders/{id}/pay', [App\Http\Controllers\OrderController::class, 'markAsPaid'])->name('orders.pay');
});

Route::get('/item/{id}', [App\Http\Controllers\ItemController::class, 'itemParam'])->name('item.itemParam');
//Route::get('/item/{id}', [App\Http\Controllers\ItemController::class, 'itemDesc'])->name('item.itemDesc');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'search_get'])->name('item.search');
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search_post'])->name('item.search_post');
