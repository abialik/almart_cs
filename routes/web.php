<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;

/*
|--------------------------------------------------------------------------
| PUBLIC SHOP (Guest & Customer)
|--------------------------------------------------------------------------
*/

Route::controller(ShopController::class)->group(function () {
    Route::get('/', 'index')->name('shop.home');
    Route::get('/products', 'all')->name('products.all');
   Route::get('/product/{slug}', [ShopController::class, 'show'])
    ->name('product.detail');
});


/*
|--------------------------------------------------------------------------
| CUSTOMER AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        // CART
        Route::get('/cart', [CartController::class, 'index'])
            ->name('cart.index');

        Route::post('/cart/add/{product}', [CartController::class, 'add'])
            ->name('cart.add');

        Route::post('/cart/remove/{product}', [CartController::class, 'remove'])
            ->name('cart.remove');

        Route::patch('/cart/increase/{product}', [CartController::class, 'increase'])
            ->name('cart.increase');

        Route::patch('/cart/decrease/{product}', [CartController::class, 'decrease'])
            ->name('cart.decrease');

        // CHECKOUT
        Route::get('/checkout', [CheckoutController::class, 'index'])
            ->name('checkout.index');

        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');

        Route::get('/checkout/{order}/payment', [CheckoutController::class, 'payment'])
            ->name('checkout.payment');

        Route::post('/checkout/{order}/upload-proof', [CheckoutController::class, 'uploadProof'])
            ->name('checkout.upload-proof');

        // ORDERS
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::get('/order-status', [OrderController::class, 'status'])
            ->name('orders.status');

        // WISHLIST
        Route::get('/wishlist', [WishlistController::class, 'index'])
            ->name('wishlist.index');
        Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])
            ->name('wishlist.toggle');
        Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])
            ->name('wishlist.remove');

        // RETURNS
        Route::get('/returns', [App\Http\Controllers\ReturnController::class, 'index'])
            ->name('returns.index');
        Route::get('/orders/{order}/return', [App\Http\Controllers\ReturnController::class, 'create'])
            ->name('returns.create');
        Route::post('/orders/{order}/return', [App\Http\Controllers\ReturnController::class, 'store'])
            ->name('returns.store');

        // COMPLAINTS
        Route::get('/complaints', [\App\Http\Controllers\CustomerComplaintController::class, 'index'])
            ->name('complaints.index');
        Route::get('/complaint', [\App\Http\Controllers\PageController::class, 'complaint'])
            ->name('complaint.create');
        Route::post('/complaint', [\App\Http\Controllers\PageController::class, 'submitComplaint'])
            ->name('complaint.store');
    });


/*
|--------------------------------------------------------------------------
| PROFILE AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ADDRESSES
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ORDERS MANAGEMENT
        Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        // PRODUCTS MANAGEMENT
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::get('/stok', [AdminProductController::class, 'index'])->name('stok.index'); // Keeping legacy /stok for older sidebar link or we can let products.index handle it, but I updated sidebar to admin.products.index recently. Let's just map /stok to products.index for backward compatibility if needed, or remove it. I'll replace it with resource.

        // USERS MANAGEMENT
        Route::resource('users', AdminUserController::class);

        // COMPLAINTS MANAGEMENT
        Route::get('/complaints', [\App\Http\Controllers\AdminComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{complaint}', [\App\Http\Controllers\AdminComplaintController::class, 'show'])->name('complaints.show');
        Route::patch('/complaints/{complaint}/respond', [\App\Http\Controllers\AdminComplaintController::class, 'respond'])->name('complaints.respond');

    });


/*
|--------------------------------------------------------------------------
| PETUGAS AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::view('/dashboard', 'dashboards.petugas')
            ->name('dashboard');

        // ORDERS MANAGEMENT
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    });


/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/
Route::controller(\App\Http\Controllers\PageController::class)->group(function () {
    Route::get('/about', 'about')->name('pages.about');
    Route::get('/delivery-info', 'delivery')->name('pages.delivery');
    Route::get('/privacy-policy', 'privacy')->name('pages.privacy');
    Route::get('/terms-conditions', 'terms')->name('pages.terms');
    Route::get('/contact', 'contact')->name('pages.contact');
    Route::get('/support-center', 'support')->name('pages.support');
    Route::get('/faq', 'faq')->name('pages.faq');
    Route::get('/return-request', 'returnRequest')->name('pages.return_request');
    Route::post('/return-request', 'processReturnRequest')->name('pages.return_request.process');
});

Route::fallback(function () {
    return redirect()->route('shop.home');
});

require __DIR__.'/auth.php';