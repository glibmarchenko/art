
<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::group(['namespace' => 'Api'], function () {

        Route::post('product/{product_type}/filter', 'PrintController@getFilteredResults');
        Route::get('settings/delivery','ApiController@getDeliverySettings');


        Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
            Route::post('print/filter', 'PrintController@getFilteredResults');
            Route::post('/like/{product_type}/{product_id}', 'LikeController@toggle');
            Route::post('purchase', 'PurchaseController@store');
            Route::get('purchase', 'PurchaseController@index');
            Route::delete('purchase/{id}', 'PurchaseController@delete');

            Route::post('purchase/order/print/create', 'PurchaseController@createPrintOrder');

            Route::post('purchase/order/other/create', 'PurchaseController@createOtherOrder');

            Route::post('purchase/order/other/create/provider/decta', 'PurchaseController@createOtherOrderDecta');

            Route::post('purchase/order/print/create/provider/decta', 'PurchaseController@createPrintOrderDecta');

            Route::post('purchase/order/other/create/provider/manual', 'PurchaseController@createOtherOrderManual');
            Route::post('purchase/order/print/create/provider/manual', 'PurchaseController@createPrintOrderManual');

            Route::post('user/delivery', 'DeliveryDetailsController@store');
            Route::get('user/delivery', 'DeliveryDetailsController@index');

            Route::post('attachment', 'AttachmentController@store');

            Route::get('user/notification', 'NotificationController@getUserNotifications');
            Route::post('user/notification/checked/all', 'NotificationController@setAllUserNotificationsChecked');
            Route::post('user/notification/checked/{id}', 'NotificationController@setUserNotificationChecked');

            Route::delete('attachment/{id}', 'AttachmentController@delete');

            Route::get('category', 'ApiController@getActiveCategories');
            Route::get('category/type/{type}', 'ApiController@getActiveCategoriesByType');
            Route::get('tag', 'ApiController@getTags');
            Route::get('material/{product_type}', 'ApiController@getMaterials');

            Route::post('product', 'ProductController@store');

            Route::delete('product/{product}', 'ProductController@delete');
            Route::put('product/{product}', 'ProductController@update');

            Route::get('user/author','ApiController@getGalleryAuthors');

            Route::patch('gallery/{id}','GalleryController@update');
        });


    });
