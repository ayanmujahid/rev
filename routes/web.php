<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Frontend\AffiliateController;
use App\Http\Controllers\Frontend\AnnouncementController;
use App\Http\Controllers\Frontend\CampaignController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContinuityController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\DynamicPageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Frontend\PreoderController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SubscribesController;
use App\Http\Controllers\Frontend\AffiliateShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;




Route::get('/forget-cache', function(){
    Cache::forget('user_code');
});

Route::get('/run-migration', function(){
    Artisan::call('migrate',[
        // 'name'=>$table,
    ]);
});


// ---------------------------------------2fa---------------------------------------
Route::get('/2fa/verify', [UserController::class, 'showForm'])->name('2fa.verify');
Route::post('/2fa/verify', [UserController::class, 'verifyOtp']);
// ---------------------------------------2fa---------------------------------------

// ---------------------------------------Affiliated Shop---------------------------------------
Route::get('/affiliate-shop/{slug?}', [AffiliateShopController::class, 'index'])->name('affiliate-shop');

// ---------------------------------------Affiliated Shop---------------------------------------
Route::post('/get-gifts', [CartController::class, 'getGifts'])->name('get-gifts');

// routes/web.php
Route::get('/delete-product/{id?}', [DashboardController::class, 'remove_product'])->name('remove-product');


Route::get('/thank-you', [UserController::class, 'thankyou'])->name('thank-you');
Route::get('/meeting-schedule', [UserController::class, 'meeting_schedule'])->name('meeting-schedule');

// -------------------------------------Booking---------------------
Route::post('/update-booking', [UserController::class, 'update_booking'])->name('update-booking');
Route::post('/update-time-booking', [UserController::class, 'update_time_booking'])->name('update-time-booking');
Route::get('/get-time-slots', [ScheduleController::class, 'getTimeSlots']);


// -------------------------------------Booking---------------------
Route::get('/gifts', [UserController::class, 'gifts'])->name('gifts');
Route::get('/plush', [UserController::class, 'plush'])->name('plush');
Route::get('/comics', [UserController::class, 'comics'])->name('comics');
Route::get('/product-category/{id?}', [UserController::class, 'product_category'])->name('product-category');

// ---------------------------------------Forget Password---------------------------------------

Route::get('/forget-password', [UserController::class, 'forget_password'])->name('forget-password');
Route::post('/forget-password-post', [UserController::class, 'forget_password_submit'])->name('forget_password_submit');
Route::get('/forget-password-token/{token}', [UserController::class, 'forget_password_token'])->name('forget-password-token');
Route::post('/forget-password-reset', [UserController::class, 'forget_password_reset'])->name('forget-password-reset');
// ---------------------------------------Forget Password---------------------------------------

Route::get('/products', [ShopController::class, 'shop'])->name('products');
Route::get('/shop/{id?}', [ShopController::class, 'shop'])->name('frontend.shop');

Route::get('/products/filter', [ShopController::class, 'filterByCategory'])->name('products.filter');

// ---------------------------------------OTP VERIFICATION---------------------------------------
Route::get('/verification/{user_id}', [AffiliateController::class, 'user_verification'])->name('user_verification');
Route::get('/affiliate-code', [AffiliateController::class, 'affiliate_code'])->name('affiliate-code');
Route::get('/claim-code', [AffiliateController::class, 'claim_code'])->name('claim-code');
Route::post('/otp', [AffiliateController::class, 'otp_submit'])->name('otp-submit');
Route::post('/verification-submit', [AffiliateController::class, 'verification_submit'])->name('verification-submit');
Route::post('/code-verification', [AffiliateController::class, 'code_verification'])->name('code-verification');




Route::get('/affiliate/generate', [AffiliateController::class, 'generateAffiliateLink'])->name('generateAffiliateLink');
Route::get('/register', [AffiliateController::class, 'register'])->name('register');
Route::post('/register', [AffiliateController::class, 'storeUser'])->name('storeUser');
// ---------------------------------------OTP VERIFICATION---------------------------------------

//!Route for HomeController
Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/affiliatedCalculation', [HomeController::class, 'affiliatedCalculation'])->name('affiliatedCalculation');

// claim request
Route::post('/claim-request-submit', [HomeController::class, 'claim_request_submit'])->name('claim-request-submit');


Route::get('/thankyou', [AffiliateController::class, 'thankyou'])->name('thankyou');

//!Route for HomeController
Route::get('/payment/success', [HomeController::class, 'paymentSuccess'])->name('order.success');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

//!Route for HomeController
Route::get('/payment/cancel', [HomeController::class, 'paymenCancel'])->name('order.cancel');

//!Route for HomeController
Route::get('/whoweare', [HomeController::class, 'show'])->name('whoweare');

//!Route for PreoderController
Route::get('/preoder', [PreoderController::class, 'index'])->name('preoder.index');

//!Route for ContinuityController
Route::get('/continuity', [ContinuityController::class, 'index'])->name('continuity');

//!Route for AffiliateController
Route::get('/affiliate', [AffiliateController::class, 'index'])->name('affiliate');

//!Route for CampaignController
Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign');

//!Route for PostController
Route::get('/community', [PostController::class, 'index'])->name('post.index');
Route::post('/community/store', [PostController::class, 'store'])->name('post.store');
Route::get('/community/{slug}', [PostController::class, 'singlepost'])->name('post.singlepost');
Route::post('/like', [PostController::class, 'like'])->name('post.like');
Route::post('/dislike', [PostController::class, 'dislike'])->name('post.dislike');


Route::post('/add-comment', [PostController::class, 'comment'])->name('add-comment');

Route::post('/add-reply', [PostController::class, 'reply'])->name('add-reply');


//!Route for ShopController
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.category');

//!Route for SubscribesController
Route::post('/subscribes', [SubscribesController::class, 'storeEmail'])->name('store.email');

//!Route for AnnouncementController
Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement');
Route::get('/single-announcement/{slug}', [AnnouncementController::class, 'show'])->name('single-announcement');

//!Route for ProfileController
Route::post('/update-profile', [ProfileController::class, 'UpdateProfile'])->name('update.profile');
Route::post('/update-profile-password', [ProfileController::class, 'UpdatePassword'])->name('update.Password');


Route::get('cart', [CartController::class, 'cart'])->name('cart');

Route::get('get-cart-detail', [CartController::class, 'get_cart'])->name('get_cart');
Route::get('save-cart', [CartController::class, 'save_cart'])->name('save_cart');
Route::get('update-cart', [CartController::class, 'update_cart'])->name('update_cart');
Route::post('remove-cart', [CartController::class, 'remove_cart'])->name('remove_cart');



//!Route for CartController
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');

//!Route for OrderController
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::get('/user/profile', [DashboardController::class, 'index'])->name('userprofile')->middleware('auth', 'role:user');
Route::get('/user/view-tree/{affiliateLink}', [DashboardController::class, 'viewTree'])->name('viewTree')->middleware('auth', 'role:user');

//! Route for DynamicPageController
Route::get('page/{page_slug}', [DynamicPageController::class, 'index'])->name('custom.page');

Auth::routes();
