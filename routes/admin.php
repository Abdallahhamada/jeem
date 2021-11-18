<?php

use Illuminate\Support\Facades\Route;

/**
 * Prefix Using Admin To Handle Api To Admin
 */

Route::group(
    [
        'middleware' => ['changeLang'],
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ],
    function () {

        /**
         * login For Admin
         *
         *@return Routes
         */

        Route::post('login', 'adminController@login')->name('admin.login');

        Route::post('contact','adminController@contact')->name('admin.contact');

        Route::group(
            [
                'middleware' => ['auth:admin']
            ],
            function () {

                /**
                 * Logout For Admin
                 *
                 *@return Routes
                 */

                Route::post('logout', 'adminController@logout')->name('admin.logout');

                Route::put('setting', 'adminController@password')->name('seller.password');

                Route::get('auth', 'adminController@show');

                /**
                 * notification Controller
                 *
                 *@return Routes
                 */

                Route::get('notification', 'notificationController@index')->name('notification.index');

                Route::post('notification', 'notificationController@store')->name('notification.store');

                Route::delete('notification', 'notificationController@destroy')->name('notification.destroy');

                /**
                 * buyer Controller
                 *
                 *@return Routes
                 */

                Route::get('buyer', 'buyerController@index')->name('buyers');

                Route::delete('buyer/{buyer}/delete', 'buyerController@destroy')->name('buyers.destroy');

                /**
                 * carousel Controller
                 *
                 *@return Routes
                 */

                Route::get('carousel', 'carouselController@index')->name('carousels');

                Route::put('seller/{carousel}/carousel/admin', 'carouselController@update')->name('carousel.update');

                Route::delete('carousel/{carousel}/delete', 'carouselController@destroy')->name('carousels.destroy');

                /**
                 * tags Controller
                 *
                 *@return Routes
                 */

                Route::get('tag', 'tagController@index')->name('tags');

                Route::put('seller/{tag}/tag/admin', 'tagController@update')->name('tag.update');

                Route::delete('tag/{tag}/delete', 'tagController@destroy')->name('tags.destroy');

                /**
                 * Meesage Controller
                 *
                 *@return Routes
                 */

                Route::get('message', 'messageController@index')->name('messages');

                // Send Message

                Route::post('message/{id}/{type}','messageController@create')->name('message.create');

                /// Delete Message

                // Route::delete('message/{message}','messageController@destroy')->name('message.delete');

                Route::delete('message/{message}/delete', 'messageController@destroy')->name('messages.destroy');

                /**
                 * Meeting Controller
                 *
                 *@return Routes
                 */

                Route::get('meeting', 'meetingController@index')->name('meetings');

                // Create meeting room

                Route::post('/meeting/{id}/{type}', 'meetingController@create')->name('meetings.create');

                // Update Meeting

                Route::put('/meeting/{meeting}', 'meetingController@update')->where('meeting', '[0-9]+')->where('id', '[0-9]+')->name('meetings.update');

                // Delete Meeting

                // Route::delete('/meeting/{id}', 'meetingController@destroy')->where('id', '[0-9]+')->name('meetings.delete');

                Route::delete('meeting/{meeting}/delete', 'meetingController@destroy')->name('meetings.destroy');

                /**
                 * Seller Controller
                 *
                 *@return Routes
                 */

                Route::get('seller', 'sellerController@index')->name('sellers');

                Route::post('seller/add', 'sellerController@store')->name('seller.add');

                Route::get('category', 'sellerController@category')->name('seller.category');

                Route::put('seller/{seller}/active', 'sellerController@active')->name('sellers.active');

                Route::put('seller/{seller}/{type}', 'sellerController@actions')->name('sellers.actions');

                Route::get('seller/download/{seller}', 'sellerController@file')->name('sellers.file');

                Route::get('seller/download/{seller}', 'sellerController@file')->name('sellers.file');

                Route::delete('seller/{seller}/delete', 'sellerController@destroy')->name('sellers.destroy');


                /**
                 * Message Seller Controller
                 *
                 *@return Routes
                 */

                // Get Counts for Seller Messages

                Route::get('messagecount/sellers', 'messageSellerController@index')->name('message.seller.index');

                // adding Count Of Messages To Seller

                Route::post('messagecount/{seller}/seller', 'messageSellerController@store')->name('message.seller.store');

                // delete Count Of Messages To Seller

                Route::delete('messagecount/{seller}/seller/{message}', 'messageSellerController@destroy')->name('message.seller.destroy');

                /**
                 * Grouping Of Seller Namespace
                 *
                 * @return Routes
                 */

                Route::namespace('Seller')->group(function () {

                    /**
                     * Dashboard Controller
                     *
                     *@return Routes
                     */

                    Route::get('dashboard/{id}', 'dashboardController@index')->name('dashboard.all');

                    /**
                     * Product Controller
                     *
                     *@return Routes
                     */

                    // Get All Products

                    Route::get('message/{seller}', 'messageController@index')->name('message.all');

                    // View Message

                    Route::get('seller/{seller}/message/{message}', 'messageController@show')->name('message.show');

                    // Delete Message

                    Route::delete('seller/{seller}/message/{message}/delete', 'messageController@destroy')->name('message.delete');

                    /**
                     * Product Controller
                     *
                     *@return Routes
                     */

                    // Get All Products

                    Route::get('product/{seller}', 'productController@index')->name('product.all');

                    // Show Product

                    Route::get('seller/{seller}/product/{id}', 'productController@show')->name('product.show');

                    // Get All SubCategory

                    Route::get('subcategory', 'productController@subcategory')->name('product.subcategory');

                    // Delete Product

                    Route::delete('seller/{seller}/product/{product}/delete', 'productController@destroy')->name('product.delete');

                    /**
                     * This Namesapce For Zoom Controller
                     *
                     *@return Routes
                     */

                    // Get All meetings

                    Route::get('meeting/{seller}', 'meetingController@index')->name('meetings.list');

                    // Show Meeting

                    Route::get('seller/{seller}/meeting/{id}', 'meetingController@show')->where('id', '[0-9]+')->name('meetings.show');

                    // Delete Meeting

                    Route::delete('seller/{seller}/meeting/{meeting}/delete', 'meetingController@destroy')->where('id', '[0-9]+')->name('meetings.delete');

                    /**
                     * This Namesapce For Tags Controller
                     *
                     *@return Routes
                     */

                    // Get All Tags

                    Route::get('tag/{seller}', 'tagController@index')->name('tag.all');

                    // Show tag

                    Route::get('seller/{seller}/tag/{id}', 'tagController@show')->name('tag.show');

                    // Delete tag

                    Route::delete('seller/{seller}/tag/{tag}/delete', 'tagController@destroy')->name('tag.delete');


                    /**
                     * This Namesapce For Posts Controller
                     *
                     *@return Routes
                     */

                    // Get All posts

                    Route::get('post/{seller}', 'postController@index')->name('post.all');


                    // Comment && like post

                    Route::get('seller/{seller}/post/comment/{post}', 'postController@comments')->name('post.comment');

                    // Show Post

                    Route::get('seller/{seller}/post/{post}', 'postController@show')->name('post.show');

                    // Delete post

                    Route::delete('seller/{seller}/post/{post}/delete', 'postController@destroy')->name('post.delete');

                    /**
                     * This Namesapce For Carousel Controller
                     *
                     *@return Routes
                     */

                    // Get All Carousels

                    Route::get('carousel/{seller}', 'carouselController@index')->name('carousel.all');

                    // Show carousel

                    Route::get('seller/{seller}/carousel/{id}', 'carouselController@show')->name('carousel.show');

                    // Delete carousel

                    Route::delete('seller/{seller}carousel/{carousel}/delete', 'carouselController@destroy')->name('carousel.delete');

                    /**
                     * This Namesapce For Order Controller
                     *
                     * @return Routes
                     */

                    // get Order Controller

                    Route::get('order/{seller}', 'orderController@index')->name('order.index');

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

                    Route::get('negotiate/{id}', 'negotiateController@index')->name('negotiate.index');

                    // Delete Offer

                    Route::delete('seller/{seller}/negotiate/{negotiate}/delete', 'negotiateController@destroy')->name('negotiate.destroy');
                });

            }
        );
    }
);

///////
