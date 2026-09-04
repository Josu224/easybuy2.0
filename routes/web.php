<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\OrderManagementController;
use App\Http\Controllers\Customer\OrderActionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;


Route::get('/setup', function() {
    Artisan::call('migrate', ['--force' => true]);
    
    $user = App\Models\User::where('email', 'admin@easybuy.com')->first();
    if (!$user) {
        App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@easybuy.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
    
    return "Setup complete! Admin created.";
});

// Public routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'browse'])->name('products.browse');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Password reset routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email verification routes
Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.resend');

// Product management (accessible by both admin and seller)
Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/add-product', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store-product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/update-product/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/products', [AdminDashboardController::class, 'products'])->name('admin.products');
    Route::delete('/products/{id}', [AdminDashboardController::class, 'deleteProduct'])->name('admin.deleteProduct');
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminDashboardController::class, 'showOrder'])->name('admin.showOrder');
    Route::put('/orders/{id}/status', [AdminDashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::post('/orders/{id}/verify', [AdminDashboardController::class, 'verifyOrder'])->name('admin.verifyOrder');
});

// Seller routes
Route::middleware(['auth', 'seller'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('/orders', [OrderManagementController::class, 'index'])->name('seller.orders');
    Route::get('/orders/{id}', [OrderManagementController::class, 'show'])->name('seller.orders.show');
    Route::post('/orders/{id}/accept', [OrderManagementController::class, 'accept'])->name('seller.orders.accept');
    Route::post('/orders/{id}/reject', [OrderManagementController::class, 'reject'])->name('seller.orders.reject');
    Route::post('/orders/{id}/sent', [OrderManagementController::class, 'markSent'])->name('seller.orders.sent');
});

// Customer routes (all authenticated users)
Route::middleware(['auth'])->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{cartId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Order routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/received', [OrderActionsController::class, 'markReceived'])->name('orders.received');
    Route::post('/orders/{id}/not-received', [OrderActionsController::class, 'markNotReceived'])->name('orders.notReceived');
    Route::post('/orders/{id}/review', [OrderActionsController::class, 'review'])->name('orders.review');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});