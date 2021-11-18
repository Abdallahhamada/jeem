<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * Prefix Using Admin To Handle Api To Admin
 */

Route::group(
    [
        'middleware' => ['changeLang'],
        'prefix' => 'buyer',
        'namespace' => 'Buyer'
    ],
    function () {

        Route::post('login', 'buyerController@login')->name('login');

        Route::post('register', 'buyerController@register')->name('register');

        Route::get('phone/{token}', 'buyerController@sendAvtivePhoneAgain')->name('buyer.sendAvtivePhoneAgain');

        Route::get('active/{token}', 'buyerController@activeCheck')->name('activeCheck');

        Route::post('active/{token}', 'buyerController@active')->name('active');

        Route::post('reset', 'buyerController@reset')->name('reset');

        Route::post('renew/{token}', 'buyerController@renew')->name('renew');

        Route::get('renew/{token}', 'buyerController@renewCheck')->name('renewCheck');

        /// Prefix Using Buyer To Handle Api To Buyer

        Route::get('carousel', 'carouselController@slider')->name('buyer.slider');

        Route::get('carousel/{title}', 'carouselController@products')->name('buyer.products.slider');

        Route::get('tags', 'homeController@tags')->name('home.tags');

        Route::get('category', 'categoryController@category')->name('category.category');

        Route::get('category/{category}', 'categoryController@subCategory')->name('category.subCategory');

        Route::get('sub-category/{category}', 'categoryController@productSubCategory')->name('category.productSubCategory');

        Route::get('sub-category/{category}/products', 'categoryController@products')->name('category.productSubCategory');

        /**
         * Products Controller
         *
         *@return Routes
         */

        Route::get('products', 'productController@index')->name('products');

        Route::get('product/{product}', 'productController@show')->name('products');

        Route::get('sort/{sort}', 'productController@sort')->name('products.sort');

        Route::get('search/{search}', 'productController@search')->name('search');

        Route::post('filter', 'productController@filter')->name('product.filter');

        Route::get('best-products', 'productController@bestSellers')->name('products.bestsellers');

        Route::get('seller/{seller}','buyerController@seller')->name('buyer.getSeller');

        Route::get('post/comments/{post}','buyerController@comments')->name('buyer.post.comments');

        Route::group(
            [
                'middleware' => ['auth:buyer']
            ],
            function () {

                /**
                 * Logout For Buyer
                 *
                 *@return Routes
                 */
                Route::get('auth', 'buyerController@show');

                Route::post('logout', 'buyerController@logout');

                Route::put('setting', 'buyerController@password')->name('buyer.password');

                Route::put('info', 'buyerController@info')->name('buyer.info');
                /**
                 * notification Controller
                 *
                 *@return Routes
                 */

                Route::get('notification', 'notificationController@index')->name('notification.index');

                Route::post('notification', 'notificationController@store')->name('notification.store');

                Route::delete('notification', 'notificationController@destroy')->name('notification.destroy');

                /**
                 * Profile Controller
                 *
                 *@return Routes
                 */

                Route::get('profile', 'profileController@index')->name('profile.index');

                Route::get('orders', 'profileController@orders')->name('profile.orders');

                Route::get('invoice/{code}', 'profileController@invoice')->name('profile.invoice');

                Route::get('wishlist', 'profileController@wishlist')->name('profile.wishlist');

                Route::delete('wishlist/{id}', 'profileController@wishlistDelete')->name('profile.wishlist.delete');

                Route::post('wishlist/{product}', 'profileController@makeWishlist')->name('profile.wishlist.make');

                Route::get('messages', 'profileController@messages')->name('profile.messages');

                Route::get('message/{id}', 'profileController@show')->name('profile.messages.show');

                Route::get('meetings', 'profileController@meeting')->name('profile.meeting');

                /**
                 * Cart Controller
                 *
                 *@return Routes
                 */

                // Get All Products To Cart

                Route::get('cart', 'cartController@index')->name('buyer.index');

                // Delete Order

                Route::delete('delete/{code}', 'cartController@destory')->name('buyer.destory');

                // update Count For Cart

                Route::put('order/count', 'cartController@count')->name('buyer.count');

                /**
                 * order Controller
                 *
                 *@return Routes
                 */

                // Create Order

                Route::post('order/{product}', 'orderController@store')->name('buyer.store');

                // update Order status

                Route::put('order/{code}/status', 'orderController@activeOrder')->name('buyer.activeOrder');

                // update all Orders status

                Route::put('orders/status', 'orderController@activeAllOrders')->name('buyer.sendAllOrders');

                // All Address for Buyer

                Route::get('address', 'addressController@index')->name('buyer.address');

                // Create New Address

                Route::post('address', 'addressController@store')->name('buyer.address');

                // delete Address

                Route::delete('address/{id}', 'addressController@destroy')->name('buyer.deleteAddress');

                // cancel Order

                Route::put('order/{code}/cancel', 'orderController@cancel')->name('buyer.cancel');

                /**
                 * negotiate Controller
                 *
                 *@return Routes
                 */

                Route::post('negotiate/{title}', 'negotiateController@store')->name('buyer.negotiate');

                Route::get('negotiate','negotiateController@index')->name('negotiate.index');

                // Accept Order

                Route::get('negotiate/accept/{id}','negotiateController@accept')->name('negotiate.accept');

                // Reject Order

                Route::get('negotiate/reject/{id}','negotiateController@reject')->name('negotiate.reject');

                /**
                 * Reviews Controller
                 *
                 *@return Routes
                 */


                Route::get('reviews', 'reviewController@index')->name('review.index');

                Route::post('review', 'reviewController@store')->name('review.store');

                Route::delete('review/{review}', 'reviewController@destroy')->name('review.delete');

                Route::put('review', 'reviewController@update')->name('review.update');

                /**
                 * Comments Post For Seller
                 *
                 *@return Routes
                 */

                Route::post('post/comment/{post}','buyerController@makeComment')->name('buyer.post.make.comment');

                Route::post('post/like/{post}','buyerController@like')->name('buyer.post.like');
            }
        );
    }
);
