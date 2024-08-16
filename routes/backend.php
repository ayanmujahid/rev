<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DynamicpageController;
use App\Http\Controllers\Backend\SocialmediaController;
use App\Http\Controllers\Backend\SystemSettingController;
use App\Http\Controllers\Backend\ProductPromotionsController;
use App\Http\Controllers\Backend\MainstreamEntertainmentController;
use App\Http\Controllers\Backend\AnnouncementController;
use App\Http\Controllers\Backend\CampaignController;
use App\Http\Controllers\Backend\FAQController;
use App\Http\Controllers\Backend\HappyUserController;
use App\Http\Controllers\Backend\LatestVideoController;
use App\Http\Controllers\Backend\PageSampleController;
use App\Http\Controllers\Backend\PreOrderProductController;
use App\Http\Controllers\Backend\PreOrderSpecialController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SalesGoalController;
use App\Http\Controllers\Backend\SubscribeController;
use App\Http\Controllers\Backend\UpcomingProjectController;
use App\Http\Controllers\Backend\GiftController;
use App\Http\Controllers\Backend\UserController;

Route::middleware(['auth', 'role:admin', '2fa'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //!Route for DashboardController

    //!Route for SystemSettingController
    Route::controller(SystemSettingController::class)->group(function () {
        Route::get('/system-setting', 'index')->name('system.setting');
        Route::post('/system-setting', 'update')->name('system.update');
        Route::get('/system/mail', 'mailSetting')->name('mailsetting');
        Route::post('/system/mail', 'mailSettingUpdate')->name('mail.setting.update');
        Route::get('/system/profile', 'profileindex')->name('profilesetting');
        Route::get('/system/stripe', 'stripeindex')->name('stripe.index');
        Route::post('/system/stripe', 'stripestore')->name('stripe.store');
    });

    //!Route for SocialmediaController
    Route::controller(SocialmediaController::class)->group(function () {
        Route::get('/system/social', 'index')->name('socialmedia');
        Route::post('/system/social', 'update')->name('socialmedia.update');
        Route::delete('/system/social/{id}', 'destroy')->name('socialmedia.delete');
    });

    //!Route for DynamicpageController
    Route::controller(DynamicpageController::class)->group(function () {
        Route::get('/dynamic-page', 'index')->name('dynamic_page');
        Route::get('/dynamic-page/create', 'dynamicPageCreate')->name('dynamic_page.create');
        Route::post('/dynamic-page/create', 'dynamicPageStore')->name('dynamic_page.store');
        Route::get('/dynamic-page/update/{id}', 'dynamicPageEdit')->name('dynamic_page.edit');
        Route::post('/dynamic-page/update/{id}', 'dynamicPageUpdate')->name('dynamic_page.update');
        Route::delete('/dynamic-page/delete/{id}', 'dynamicPageDelete')->name('dynamic_page.delete');
        Route::get('/dynamic-page/status/{id}',  'status')->name('dynamic_page.status');
    });

    //!Route for MainstreamEntertainmentController
    Route::controller(MainstreamEntertainmentController::class)->group(function () {
        Route::get('/mainstream-entertainment', 'index')->name('mainstream.entertainment.index');
        Route::get('/mainstream-entertainment/create', 'create')->name('mainstream.entertainment.create');
        Route::post('/mainstream-entertainment/store', 'store')->name('mainstream.entertainment.store');
        Route::get('/mainstream-entertainment/edit/{id}', 'edit')->name('mainstream.entertainment.edit');
        Route::post('/mainstream-entertainment/update', 'update')->name('mainstream.entertainment.update');
        Route::delete('/mainstream-entertainment/destroy/{id}', 'destroy')->name('mainstream.entertainment.destroy');
        Route::get('/mainstream-entertainment/status/{id}', 'status')->name('mainstream.entertainment.status');
    });

    //!Route for ProductPromotionsController
    Route::controller(ProductPromotionsController::class)->group(function () {
        Route::get('/product-promotions', 'index')->name('product.promotion.index');
        Route::get('/product-promotions/create', 'create')->name('product.promotion.create');
        Route::post('/product-promotions/store', 'store')->name('product.promotion.store');
        Route::delete('/product-promotions/destroy/{id}', 'destroy')->name('product.promotion.destroy');
        Route::get('/product-promotions/edit/{id}', 'edit')->name('product.promotion.edit');
        Route::post('/product-promotions/update', 'update')->name('product.promotion.update');
        Route::get('/product-promotions/status/{id}', 'status')->name('product.promotion.status');
    });

    //! Route for FAQController Backend
    Route::controller(FAQController::class)->group(function () {
        Route::get('/faq/', 'index')->name('faq.index');
        Route::get('/faq/create', 'create')->name('faq.create');
        Route::post('/faq/store', 'store')->name('faq.store');
        Route::get('/faq/edit/{id}', 'edit')->name('faq.edit');
        Route::put('/faq/update/{id}', 'update')->name('faq.update');
        Route::get('/faq/status/{id}', 'status')->name('faq.status');
        Route::delete('/faq/destroy/{id}', 'destroy')->name('faq.destroy');
    });

    //! Route for HappyUserController Backend
    Route::controller(HappyUserController::class)->group(function () {
        Route::get('/happyuser/', 'index')->name('happyuser.index');
        Route::get('/happyuser/create', 'create')->name('happyuser.create');
        Route::post('/happyuser/store', 'store')->name('happyuser.store');
        Route::get('/happyuser/edit/{id}', 'edit')->name('happyuser.edit');
        Route::put('/happyuser/update/{id}', 'update')->name('happyuser.update');
        Route::get('/happyuser/status/{id}', 'status')->name('happyuser.status');
        Route::delete('/happyuser/destroy/{id}', 'destroy')->name('happyuser.destroy');
    });

    //! Route for AnnouncementController Backend
    Route::controller(AnnouncementController::class)->group(function () {
        Route::get('/announcement/', 'index')->name('announcement.index');
        Route::get('/announcement/create', 'create')->name('announcement.create');
        Route::post('/announcement/store', 'store')->name('announcement.store');
        Route::get('/announcement/edit/{id}', 'edit')->name('announcement.edit');
        Route::put('/announcement/update/{id}', 'update')->name('announcement.update');
        Route::get('/announcement/status/{id}', 'status')->name('announcement.status');
        Route::delete('/announcement/destroy/{id}', 'destroy')->name('announcement.destroy');
    });

    //! Route for UpcomingProjectController Backend
    Route::controller(UpcomingProjectController::class)->group(function () {
        Route::get('/upcomingproject/', 'index')->name('upcomingproject.index');
        Route::get('/upcomingproject/create', 'create')->name('upcomingproject.create');
        Route::post('/upcomingproject/store', 'store')->name('upcomingproject.store');
        Route::get('/upcomingproject/edit/{id}', 'edit')->name('upcomingproject.edit');
        Route::put('/upcomingproject/update/{id}', 'update')->name('upcomingproject.update');
        Route::get('/upcomingproject/status/{id}', 'status')->name('upcomingproject.status');
        Route::delete('/upcomingproject/destroy/{id}', 'destroy')->name('upcomingproject.destroy');
    });

    //! Route for CampaignController Backend
    Route::controller(CampaignController::class)->group(function () {
        Route::get('/campaign/', 'index')->name('campaign.index');
        Route::get('/campaign/create', 'create')->name('campaign.create');
        Route::post('/campaign/store', 'store')->name('campaign.store');
        Route::get('/campaign/edit/{id}', 'edit')->name('campaign.edit');
        Route::put('/campaign/update/{id}', 'update')->name('campaign.update');
        Route::get('/campaign/status/{id}', 'status')->name('campaign.status');
        Route::delete('/campaign/destroy/{id}', 'destroy')->name('campaign.destroy');
    });
    
     //! Route for Schedule A meeting Backend
    Route::controller(ScheduleController::class)->group(function () {
        Route::get('/schedule/', 'index')->name('schedule.index');
        Route::get('/add-schedule', [ScheduleController::class, 'add'])->name('schedule.add');
  Route::post('/create-schedule', [ScheduleController::class, 'create'])->name('schedule.create');
  Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');
  Route::post('/edit-schedule', [ScheduleController::class, 'save'])->name('schedule.save');
  Route::get('/suspend-schedule/{id}', [ScheduleController::class, 'suspend'])->name('schedule.suspend');
  Route::get('/delete-schedule/{id}', [ScheduleController::class, 'delete'])->name('schedule.delete');
        
        
    });
    

    //! Route for ProductCategoryController Backend
    Route::controller(ProductCategoryController::class)->group(function () {
        Route::get('/productcategory/', 'index')->name('productcategory.index');
        Route::get('/productcategory/create', 'create')->name('productcategory.create');
        Route::post('/productcategory/store', 'store')->name('productcategory.store');
        Route::get('/productcategory/edit/{id}', 'edit')->name('productcategory.edit');
        Route::put('/productcategory/update/{id}', 'update')->name('productcategory.update');
        Route::get('/productcategory/status/{id}', 'status')->name('productcategory.status');
        Route::delete('/productcategory/destroy/{id}', 'destroy')->name('productcategory.destroy');
    });

    //! Route for ProductController Backend
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/', 'index')->name('product.index');
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/store', 'store')->name('product.store');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::put('/product/update/{id}', 'update')->name('product.update');
        Route::get('/product/status/{id}', 'status')->name('product.status');
        Route::delete('/product/destroy/{id}', 'destroy')->name('product.destroy');
    });

    //! Route for PreOrderProductController Backend
    Route::controller(PreOrderProductController::class)->group(function () {
        Route::get('/pre_order_product/', 'index')->name('pre_order_product.index');
        Route::get('/pre_order_product/create', 'create')->name('pre_order_product.create');
        Route::post('/pre_order_product/store', 'store')->name('pre_order_product.store');
        Route::get('/pre_order_product/edit/{id}', 'edit')->name('pre_order_product.edit');
        Route::put('/pre_order_product/update/{id}', 'update')->name('pre_order_product.update');
        Route::get('/pre_order_product/status/{id}', 'status')->name('pre_order_product.status');
        Route::delete('/pre_order_product/destroy/{id}', 'destroy')->name('pre_order_product.destroy');
    });

    //! Route for PreOrderSpecialController Backend
    Route::controller(PreOrderSpecialController::class)->group(function () {
        Route::get('/pre_order_special/', 'index')->name('pre_order_special.index');
        Route::get('/pre_order_special/create', 'create')->name('pre_order_special.create');
        Route::post('/pre_order_special/store', 'store')->name('pre_order_special.store');
        Route::get('/pre_order_special/edit/{id}', 'edit')->name('pre_order_special.edit');
        Route::put('/pre_order_special/update/{id}', 'update')->name('pre_order_special.update');
        Route::get('/pre_order_special/status/{id}', 'status')->name('pre_order_special.status');
        Route::delete('/pre_order_special/destroy/{id}', 'destroy')->name('pre_order_special.destroy');
    });

    //! Route for SalesGoalController Backend
    Route::controller(SalesGoalController::class)->group(function () {
        Route::get('/sales_goal/', 'index')->name('sales.goal.index');
        Route::get('/sales_goal/create', 'create')->name('sales.goal.create');
        Route::post('/sales_goal/store', 'store')->name('sales.goal.store');
        Route::get('/sales_goal/edit/{id}', 'edit')->name('sales.goal.edit');
        Route::put('/sales_goal/update/{id}', 'update')->name('sales.goal.update');
        Route::get('/sales_goal/status/{id}', 'status')->name('sales.goal.status');
        Route::delete('/sales_goal/destroy/{id}', 'destroy')->name('sales.goal.destroy');
    });

    //! Route for PageSampleController Backend
    Route::controller(PageSampleController::class)->group(function () {
        Route::get('/page_sample/', 'index')->name('page_sample.index');
        Route::get('/page_sample/create', 'create')->name('page_sample.create');
        Route::post('/page_sample/store', 'store')->name('page_sample.store');
        Route::get('/page_sample/edit/{id}', 'edit')->name('page_sample.edit');
        Route::put('/page_sample/update/{id}', 'update')->name('page_sample.update');
        Route::get('/page_sample/status/{id}', 'status')->name('page_sample.status');
        Route::delete('/page_sample/destroy/{id}', 'destroy')->name('page_sample.destroy');
    });

    //! Route for LatestVideoController Backend
    Route::controller(LatestVideoController::class)->group(function () {
        Route::get('/latest_video/', 'index')->name('latest_video.index');
        Route::get('/latest_video/create', 'create')->name('latest_video.create');
        Route::post('/latest_video/store', 'store')->name('latest_video.store');
        Route::get('/latest_video/edit/{id}', 'edit')->name('latest_video.edit');
        Route::put('/latest_video/update/{id}', 'update')->name('latest_video.update');
        Route::get('/latest_video/status/{id}', 'status')->name('latest_video.status');
        Route::delete('/latest_video/destroy/{id}', 'destroy')->name('latest_video.destroy');
    });
    
    
    //! Route for Gift Backend
    Route::controller(GiftController::class)->group(function () {
        Route::get('/gifts/', 'index')->name('gifts.index');
        Route::get('/gifts/create', 'create')->name('gifts.create');
        Route::post('/gifts/store', 'store')->name('gifts.store');
        Route::get('/gifts/edit/{id}', 'edit')->name('gifts.edit');
        Route::put('/gifts/update/{id}', 'update')->name('gifts.update');
        Route::get('/gifts/status/{id}', 'status')->name('gifts.status');
        Route::delete('/gifts/destroy/{id}', 'destroy')->name('gifts.destroy');
    });

    //! Route for SubscribeController Backend
    Route::controller(SubscribeController::class)->group(function () {
        Route::get('/subscribes/', 'index')->name('subscribes.index');
        Route::delete('/subscribes/destroy/{id}', 'destroy')->name('subscribes.destroy');
    });
    
    
    //! Route for UserController Backend
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/', 'index')->name('user.index');
        Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
    });

    //! Route for OrderController Backend
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');


    Route::get('/claim-request', [OrderController::class, 'claim_request'])->name('claim_request.index');
    
    Route::get('/affiliate-subscribers', [OrderController::class, 'affiliate_subscriber'])->name('affiliate_subscriber.index');
});
