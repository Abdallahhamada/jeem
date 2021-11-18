<?php

use Illuminate\Support\Facades\Route;


/**
 * Prefix Using Admin To Handle Api To Admin
 */

Route::group(
    [
        'middleware' => ['changeLang'],
        'prefix' => 'seller',
        'namespace' => 'Seller'
    ],
    function () {

        Route::post('login', 'sellerController@login')->name('login');

        Route::get('active/{token}', 'sellerController@activeCheck')->name('activeCheck');

        Route::post('active/{token}', 'sellerController@active')->name('active');

        Route::post('register', 'sellerController@register')->name('register');

        Route::get('phone/{token}', 'sellerController@sendAvtivePhoneAgain')->name('seller.sendAvtivePhoneAgain');

        Route::post('reset', 'sellerController@reset')->name('reset');

        Route::post('renew/{token}', 'sellerController@renew')->name('renew');

        Route::get('renew/{token}', 'sellerController@renewCheck')->name('renewCheck');

        /// Prefix Using Seller To Handle Api To Seller

        Route::group(
            [
                'middleware' => ['auth:seller,subseller']
            ],
            function () {

                /**
                 * Logout For Seller
                 *
                 *@return Routes
                 */

                Route::post('logout', 'sellerController@logout');

                Route::get('auth', 'sellerController@show');

                /**
                 * Dashboard Controller
                 *
                 *@return Routes
                 */

                Route::get('dashboard', 'dashboardController@index')->name('dashboard.all');

                Route::put('setting', 'sellerController@password')->name('seller.password');

                Route::put('profile', 'sellerController@profile')->name('seller.profile');

                Route::put('info', 'sellerController@info')->name('seller.info');

                /**
                 * notification Controller
                 *
                 *@return Routes
                 */

                Route::get('notification', 'notificationController@index')->name('notification.index');

                Route::post('notification', 'notificationController@store')->name('notification.store');

                Route::delete('notification', 'notificationController@destroy')->name('notification.destroy');

                /**
                 * Product Controller
                 *
                 *@return Routes
                 */

                // Get All Products

                Route::get('product', 'productController@index')->name('product.all');

                // Get All SubCategory

                Route::get('subcategory', 'productController@subcategory')->name('product.subcategory');

                // Create Product

                Route::post('product', 'productController@create')->name('product.create');

                /// Update Status

                Route::put('product/status/{id}', 'productController@status')->name('product.status');

                // Create Product Using Excel

                Route::post('product/excel', 'productController@excel')->name('product.excel');

                // Edit Product

                Route::put('product/{product}', 'productController@update')->name('product.update');

                // Show Product

                Route::get('product/{id}', 'productController@show')->name('product.show');

                // Delete Product

                Route::delete('product/{product}', 'productController@destroy')->name('product.delete');

                // Delete Product Image

                Route::delete('product/{image}/image', 'productController@image')->name('product.delete');

                /**
                 * This Namesapce For Zoom Controller
                 *
                 *@return Routes
                 */

                // Get All meetings

                Route::get('/meeting', 'meetingController@index')->name('meetings.list');

                // Create meeting room

                Route::post('/meeting', 'meetingController@create')->name('meetings.create');

                // Show Meeting

                Route::get('/meeting/{meeting}', 'meetingController@show')->where('id', '[0-9]+')->name('meetings.show');

                // Update Meeting

                Route::put('/meeting/{meeting}', 'meetingController@update')->where('id', '[0-9]+')->name('meetings.update');

                // Delete Meeting

                Route::delete('/meeting/{id}', 'meetingController@destroy')->where('id', '[0-9]+')->name('meetings.delete');

                /**
                 * This Namesapce For Tags Controller
                 *
                 *@return Routes
                 */

                // Get All Tags

                Route::get('tag', 'tagController@index')->name('tag.all');

                // Create tag

                Route::post('tag', 'tagController@create')->name('tag.create');

                // update Tag Status

                Route::put('tag/status/{tag}', 'tagController@status')->name('tag.update.status')->where('id', '[0-9]+');

                // Edit tag

                Route::put('tag/{tag}', 'tagController@update')->name('tag.update');

                // Show tag

                Route::get('tag/{id}', 'tagController@show')->name('tag.show');

                // Delete tag

                Route::delete('tag/{tag}', 'tagController@destroy')->name('tag.delete');


                /**
                 * This Namesapce For Posts Controller
                 *
                 *@return Routes
                 */

                // Get All posts

                Route::get('post', 'postController@index')->name('post.all');

                // Create post

                Route::post('post', 'postController@create')->name('post.create');

                // Edit post

                Route::put('post/{post}', 'postController@update')->name('post.update');

                // Comment && like post

                Route::get('post/comment/{post}', 'postController@comments')->name('post.comment');

                // Show Post

                Route::get('post/{post}', 'postController@show')->name('post.show');

                // Delete post

                Route::delete('post/{post}', 'postController@destroy')->name('post.delete');

                /**
                 * This Namesapce For Carousel Controller
                 *
                 *@return Routes
                 */

                // Get All Carousels

                Route::get('carousel', 'carouselController@index')->name('carousel.all');

                // Create carousel

                Route::post('carousel', 'carouselController@create')->name('carousel.create');

                // Edit carousel

                Route::put('carousel/{carousel}', 'carouselController@update')->name('carousel.update');

                // update Carousel Status

                Route::put('carousel/status/{carousel}', 'carouselController@status')->name('carousel.update.status')->where('id', '[0-9]+');

                // Show carousel

                Route::get('carousel/{id}', 'carouselController@show')->name('carousel.show');

                // Delete carousel

                Route::delete('carousel/{carousel}', 'carouselController@destroy')->name('carousel.delete');

                /**
                 * This Namesapce For subSeller Controller
                 *
                 * @return Routes
                 */

                // Get All subSellers

                Route::get('subseller', 'subsellerController@index')->name('subseller.all');

                // Create subseller

                Route::post('subseller', 'subsellerController@create')->name('subseller.create');

                /// Get all Permissions

                Route::get('permission', 'subsellerController@permission')->name('subseller.permission');

                // Edit subseller

                Route::put('subseller/{subseller}', 'subsellerController@update')->name('subseller.update');

                // Show subseller

                Route::get('subseller/{id}', 'subsellerController@show')->name('subseller.show');

                // Delete subseller

                Route::delete('subseller/{subseller}', 'subsellerController@destroy')->name('subseller.delete');

                /**
                 * This Namesapce For Order Controller
                 *
                 * @return Routes
                 */

                // get Order Controller

                Route::get('order', 'orderController@index')->name('order.index');

                // Update Delivery Status Order Controller

                Route::put('order/{order}', 'orderController@update')->name('order.update');

                // Cancel Order Controller

                Route::delete('order/{order}', 'orderController@destroy')->name('order.destroy');

                // Cancel Order Controller

                Route::get('delivery', 'orderController@delivery')->name('order.delivery');

                /**
                 * This Namesapce For Negotiate Controller
                 *
                 * @return Routes
                 */

                // get negotiate Controller

                // Route::get('negotiate', 'negotiateController@index')->name('negotiate.index');

                // // Notify Buyer With Order Price

                // Route::put('negotiate/{negotiate}', 'negotiateController@price')->name('negotiate.price');

                // // Accept Order

                // Route::get('negotiate/accept/{id}', 'negotiateController@accept')->name('negotiate.accept');

                // // Reject Order

                // Route::get('negotiate/reject/{id}', 'negotiateController@reject')->name('negotiate.reject');

                // // Delete Offer

                // Route::delete('negotiate/{negotiate}', 'negotiateController@destroy')->name('negotiate.destroy');

                /**
                 * This Namesapce For Invoice Controller
                 *
                 * @return Routes
                 */

                // get Invoice

                Route::get('invoice', 'invoiceController@index')->name('invoice.index');

                // Show Invoice

                Route::get('invoice/{invoice}', 'invoiceController@show')->name('invoice.show');

                // store Invoice

                Route::post('invoice', 'invoiceController@store')->name('invoice.store');

                // Update Invoice

                Route::put('invoice/{invoice}', 'invoiceController@update')->name('invoice.update');

                // delete Invoice

                Route::delete('invoice/{invoice}', 'invoiceController@destroy')->name('invoice.destroy');


                /**
                 * This Namesapce For Manual Products Controller
                 *
                 * @return Routes
                 */

                // get Manual Products

                Route::get('manual_products', 'manualProductsController@index')->name('manual.products.index');

                // Show Manual Products

                Route::get('manual_products/{manual}', 'manualProductsController@show')->name('manual.products.show');

                // store Manual Products

                Route::post('manual_products', 'manualProductsController@store')->name('manual.products.store');

                // Update Manual Products

                Route::put('manual_products/{manual}', 'manualProductsController@update')->name('manual.products.update');

                // delete Manual Products

                Route::delete('manual_products/{manual}', 'manualProductsController@destroy')->name('manual.products.destroy');

                /**
                 * This Namesapce For Manual Products Controller
                 *
                 * @return Routes
                 */

                // get Manual Products

                Route::get('voucher', 'voucherController@index')->name('voucher.index');

                // Show Manual Products

                Route::get('voucher/{voucher}', 'voucherController@show')->name('voucher.products.show');

                // store voucher Products

                Route::post('voucher', 'voucherController@store')->name('voucher.products.store');

                // Update voucher Products

                Route::put('voucher/{voucher}', 'voucherController@update')->name('voucher.products.update');

                // delete voucher Products

                Route::delete('voucher/{voucher}', 'voucherController@destroy')->name('voucher.products.destroy');

                /**
                 * This Namesapce For Message Controller
                 *
                 * @return Routes
                 */

                // Get All Messages

                Route::get('message', 'messageController@index')->name('message.all');

                // Send Message

                Route::post('message', 'messageController@create')->name('message.create');

                // View Message

                Route::get('message/{message}', 'messageController@show')->name('message.show');

                /// Resend Message Agin

                Route::post('message/{message}', 'messageController@again')->name('message.resend');

                /// Delete Message

                Route::delete('message/{message}', 'messageController@destroy')->name('message.delete');
            }
        );
    }
);
