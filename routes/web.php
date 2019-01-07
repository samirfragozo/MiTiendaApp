<?php

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

use App\Utils\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::redirect('/', 'home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Home
    Route::redirect('home', 'stores')->name('home');

    // Cart
    Route::resource('cart', 'CartController', ['only' => ['index', 'store']]);
    Route::get('cart/{product}/minus','CartController@minus');
    Route::get('cart/{product}/plus','CartController@plus');
    Route::get('cart/{product}/remove','CartController@remove');

    // Orders
    Route::resource('orders', 'OrderController', ['only' => ['index', 'update']]);
    Route::get('orders/{order}/products', 'OrderController@products');

    // Roles
    Route::resource('providers', 'RolController', ['except' => ['create', 'edit']]);
    Route::get('storekeeper','RolController@storekeeper')->name('storekeeper.rol')->middleware('ajax');

    // Stores
    Route::resource('stores', 'StoreController', ['only' => 'index']);
    Route::get('stores/{store}/products', 'StoreController@products');
    Route::get('stores/{store}/products/{product}/add','CartController@add');

    // User
    Route::resource('user', 'UserController', ['except' => ['create', 'edit', 'store']]);

    // Provider
    Route::middleware(['role:provider'])->name('provider.')->namespace('Provider')->prefix('provider')->group(function () {
        // Orders
        Route::resource('orders', 'OrderController', ['only' => 'index']);
        Route::put('orders', 'OrderController@update');
        Route::get('orders/{order}/products', 'OrderController@products');

        // Products
        Route::resource('products', 'ProductController', ['except' => ['create', 'edit']]);
        Route::post('products/status', 'ProductController@status');
    });

    // Storekeeper
    Route::middleware(['role:storekeeper'])->name('storekeeper.')->namespace('Storekeeper')->prefix('storekeeper')->group(function () {
        // Cart
        Route::resource('cart', 'CartController', ['only' => ['index', 'store']]);
        Route::get('cart/{product}/minus','CartController@minus');
        Route::get('cart/{product}/plus','CartController@plus');
        Route::get('cart/{product}/remove','CartController@remove');

        // Providers
        Route::resource('providers', 'ProviderController', ['only' => 'index']);
        Route::get('providers/{provider}/products', 'ProviderController@products');
        Route::get('providers/{store}/products/{product}/add','CartController@add');

        // Orders
        Route::resource('orders', 'OrderController', ['only' => ['index', 'update']]);
        Route::get('orders/{order}/products', 'OrderController@products');

        // Stores
        Route::resource('stores', 'StoreController', ['except' => ['create', 'edit']]);
        Route::post('stores/status', 'StoreController@status');

        // Stores - Deudas
        Route::get('stores/{store}/debts', 'StoreController@debts');
        Route::get('stores/{store}/debts/{user}/orders', 'StoreController@debtOrders');
        Route::put('stores/{store}/debts/{user}/orders', 'StoreController@orderUpdate');
        Route::get('stores/{store}/debts/{user}/orders/{order}/products', 'StoreController@orderProducts');

        // Stores - Orders
        Route::get('stores/{store}/orders', 'StoreController@orders');
        Route::put('stores/{store}/orders', 'StoreController@orderUpdate');
        Route::get('stores/{store}/orders/{order}/products', 'StoreController@orderProducts');

        // Stores - Products
        Route::resource('stores/{store}/products', 'ProductController', ['except' => ['create', 'edit']]);
        Route::post('stores/{store}/products/status', 'ProductController@status');
    });

    Route::get('select', function (Request $request)
    {
        $request->request->add(['data' => Base::select($request->input('name'))]);

        return response()->json($request);
    })->middleware('ajax');
});
