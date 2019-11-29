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

    Route::get('test','WebController@test');
    Route::get('testpayment', 'WebController@testPayment');

    Route::get('lang/{lang}', 'HelperController@setLocale')->middleware('throttle')->name('lang');

    Route::post('order/payment/{token}', 'OrderController@confirmPayment')->name('order.payment');

    Route::get('order/delete/{id}', 'OrderController@destroy')->name('order.delete');
    Route::get('order/purchase/{id}', 'OrderController@purchase')->name('order.purchase');

    Route::get('test-mail', 'WebController@testMail');
    Route::get('estimate/{from}/{to}', 'Api\DeliveryDetailsController@estimate');

    Route::get('user/activate/{token}', 'WebController@activate')->name('user.activate');

    Route::get('categories', 'Api\ApiController@getCategories');
    Route::get('categories/{product_type_id}', 'Api\ApiController@getCategoriesForProductType');
    Route::get('materials/{product_type_id}', 'Api\ApiController@getMaterialsForProductType');
    Route::get('material/{product_type}', 'Api\ApiController@getMaterials');

    Route::get('test', 'WebController@test');
    Route::get('password/reset/{code?}', 'Auth\LoginController@forgotPassword')->name('forgot');

    Route::get('user/profile', 'WebController@showProfilePage')->name('user.profile');

    Auth::routes();
    Route::get('/auth/{soc}', 'Auth\RegisterController@redirectToSocialProvider')->name('social.auth');
    Route::get('/auth/{soc}/callback', 'Auth\RegisterController@handleSocialProviderCallback')->name('social.auth.redirect');

    Route::get('gallerys/{id}', 'GalleryController@newpage');
    Route::get('authors', 'WebController@authorIndex')->name('author.index');

    Route::get('poster/json', 'PosterController@getPostersJson');
    Route::get('/', 'WebController@index')->name('home');
    Route::get('product/{id}', ['uses' => 'ProductController@productShow', 'as' => 'product.show']);
    Route::get('prints', ['uses' => 'WebController@prints', 'as' => 'prints']);
    Route::get('images/poster/preview/{id}', ['uses' => 'PosterController@showPosterPreview', 'as' => 'poster.preview']);
    Route::get('images/picture/preview/{id}', [
        'uses' => 'PictureController@showPicturePreview',
        'as'   => 'picture.preview',
    ]);

    Route::get('order/payment/decta/success/{order_hash}', [
        'uses' => 'PaymentController@onSuccessDectaRedirect',
        'as'   => 'payment.decta.success',
    ]);
    Route::get('order/payment/decta/failure/{order_hash}', [
        'uses' => 'PaymentController@onFailureDectaRedirect',
        'as'   => 'payment.decta.failure',
    ]);
    Route::get('order/payment/decta/cancel/{order_hash}', [
        'uses' => 'PaymentController@onCancelDectaRedirect',
        'as'   => 'payment.decta.cancel',
    ]);
    Route::get('order/payment/decta/invoice/{order_hash}', [
        'uses' => 'PaymentController@onInvoiceDectaRedirect',
        'as'   => 'payment.decta.invoice',
    ]);

    Route::get('author-page', ['uses' => 'WebController@authorPage', 'as' => 'author.page']);
    Route::get('profile/{id}', ['uses' => 'WebController@profilePage', 'as' => 'profile.page']);

    Route::get('user/{id}', ['uses' => 'WebController@profilePage', 'as' => 'user.show']);

    Route::get('/like/{type}/{id}', 'WebController@toggleLikeAjax');

    Route::post('/subscribe/{id}', 'WebController@subscribeToArtist');
    Route::post('/item/{type}/{id}', 'WebController@getItemInfoAjax');
    Route::get('/item/{type}/{id}', 'WebController@getItemInfo');
    Route::get('/filter-search', 'WebController@filterSearch');

    Route::get('file/{folder}/{name}', 'WebController@showFile')->name('show.file');

    Route::group(['middleware' => ['auth', 'hasRole']], function () {
        Route::get('product/delete/{id}', 'ProductController@delete');
        Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit');
    });

    Route::group(['prefix' => 'functions', 'middleware' => 'auth'], function () {
        Route::get('colors/{type}', 'WebController@decodeItemColors');
        Route::get('resize/{type}', ['uses' => 'WebController@updateResizeImages', 'as' => 'items.resize']);
    });

    Route::group(['prefix' => 'register-page', 'middleware' => 'auth'], function () {
        Route::get('/', ['uses' => 'WebController@registerMain', 'as' => 'register.main']);
        Route::get('step-1/{type?}', ['uses' => 'WebController@registerStep1', 'as' => 'register.step1']);
        Route::post('completed', [
            'uses' => 'WebController@saveUserDataFromRegister',
            'as'   => 'register.completed',
        ]);
        Route::post('step-2', ['uses' => 'WebController@saveUserDataFromStep1', 'as' => 'register.step2.post']);
        Route::get('step-2', ['uses' => 'WebController@registerStep2', 'as' => 'register.step2']);
        Route::post('gallery/completed', ['uses' => 'WebController@saveGalleryData', 'as' => 'register.gallery.post']);
    });

    Route::group(['middleware' => ['auth', 'hasRole']], function () {
        Route::get('orders', ['uses' => 'OrderController@index', 'as' => 'order.index']);
        Route::get('orders/active', ['uses' => 'OrderController@active', 'as' => 'order.active']);
        Route::get('orders/cancelled', ['uses' => 'OrderController@cancelled', 'as' => 'order.cancelled']);
        Route::get('orders/completed', ['uses' => 'OrderController@completed', 'as' => 'order.completed']);
    });

    Route::group(['prefix' => 'settings', 'middleware' => ['auth', 'hasRole']], function () {
        Route::get('/', ['uses' => 'SettingsController@settingsMain', 'as' => 'settings']);

        Route::get('/profile', ['uses' => 'SettingsController@settingsProfile', 'as' => 'settings.profile']);
        Route::post('/profile', ['uses' => 'SettingsController@settingsProfileSave', 'as' => 'settings.profile.save']);

        Route::get('/items', ['uses' => 'SettingsController@settingsItems', 'as' => 'settings.items']);

        Route::get('/address', ['uses' => 'SettingsController@settingsAddress', 'as' => 'settings.address']);
        Route::post('/address', ['uses' => 'SettingsController@settingsAddressSave', 'as' => 'settings.address.save']);

        Route::get('/auth', ['uses' => 'SettingsController@settingsAuth', 'as' => 'settings.auth']);
        Route::post('/auth', ['uses' => 'SettingsController@settingsAuthSave', 'as' => 'settings.auth.save']);

        Route::get('/finance', ['uses' => 'SettingsController@settingsFinance', 'as' => 'settings.finance']);

        Route::get('/gallery', ['uses' => 'SettingsController@settingsGallery', 'as' => 'settings.gallery']);
        Route::post('/gallery', ['uses' => 'SettingsController@settingsGallerySave', 'as' => 'settings.gallery.save']);

        Route::get('/authors', ['uses' => 'SettingsController@settingsAuthors', 'as' => 'settings.authors']);
        Route::get('/authors/add', ['uses' => 'SettingsController@addNewAuthor', 'as' => 'settings.authors.add']);
        Route::get('/authors/edit/{id}', ['uses' => 'SettingsController@editAuthor', 'as' => 'settings.authors.edit']);
        Route::post('/authors/{id?}', ['uses' => 'SettingsController@saveAuthor', 'as' => 'settings.authors.save']);
        Route::post('/authors/delete/{id?}', [
            'uses' => 'SettingsController@deleteAuthor',
            'as'   => 'settings.authors.delete',
        ]);
    });

    Route::get('/gallery/{gallery_id}/author/{author_id}', [
        'uses' => 'GalleryController@showAuthorPage',
        'as'   => 'gallery.author',
    ]);

    Route::get('poster/category/{name}', 'PosterController@index');

    Route::resource('poster', 'PosterController');
    Route::resource('picture', 'PictureController');
    Route::resource('object', 'ObjectController');
    Route::resource('gallery', 'GalleryController');

    Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');

    Route::group(['middleware' => ['auth', 'hasRole']], function () {
        Route::get('/poster/create-picture', ['uses' => 'PosterController@createPicture', 'as' => 'items.createPicture']);
        Route::resource('cart', 'CartController');
        Route::get('finance', ['uses' => 'SettingsController@userFinance', 'as' => 'user.finance']);
        Route::get('liked', ['uses' => 'WebController@likedPosts', 'as' => 'user.liked']);
        Route::get('news', ['uses' => 'WebController@subscriptionNews', 'as' => 'user.news']);
        Route::get('subscriptions/{type}', [
            'uses' => 'WebController@subscriptionsList',
            'as'   => 'user.subscriptions.type',
        ]);
        Route::get('subscriptions', ['uses' => 'WebController@showSubscriptionsListAuthors', 'as' => 'user.subscriptions']);
        Route::post('items/{type}/delete', ['uses' => 'WebController@deleteItem', 'as' => 'items.delete']);
    });

    Route::group(['prefix' => 'systems', 'middleware' => ['auth', 'isAdmin'], 'namespace' => 'Admin'], function () {

        Route::get('authenticate/user/{user_id}', 'AdminController@authUser')->name('admin.authenticate.user');
        Route::get('order/{order}/delete', 'OrderController@deleteOrder')->name('admin.order.delete');
        Route::get('product/{product_id}/edit', 'ProductController@edit')->name('admin.product.edit');
        Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.home']);
        Route::get('dashboard', ['uses' => 'AdminController@dashboard', 'as' => 'admin.dashboard']);
        Route::get('finance', ['uses' => 'AdminController@blank', 'as' => 'admin.finance']);
        Route::get('delivery', ['uses' => 'AdminController@blank', 'as' => 'admin.delivery']);
        Route::get('printing', ['uses' => 'AdminController@blank', 'as' => 'admin.printing']);

        Route::get('orders', ['uses' => 'OrderController@index', 'as' => 'admin.orders']);

        Route::get('commissions', ['uses' => 'CommissionController@index', 'as' => 'admin.commissions']);
        Route::get('commissions/approve/{commission}', [
            'uses' => 'CommissionController@approve',
            'as'   => 'admin.commissions.approve',
        ]);
        Route::get('orders/pictures', ['uses' => 'OrderController@indexPictures', 'as' => 'admin.orders.pictures']);
        Route::get('orders/objects', ['uses' => 'OrderController@indexObjects', 'as' => 'admin.orders.objects']);


        Route::get('order/print/status/active', [
            'uses' => 'OrderController@indexPrintActive',
            'as'   => 'admin.order.print.active',
        ]);

        Route::get('order/print/status/archived', [
            'uses' => 'OrderController@indexPrintArchived',
            'as'   => 'admin.order.print.archived',
        ]);

        Route::get('order/pictures/status/{state}', [
            'uses' => 'OrderController@getPicturesByState',
            'as'   => 'admin.order.pictures.state',
        ]);

        Route::get('order/items/status/{state}', [
            'uses' => 'OrderController@getItemsByState',
            'as'   => 'admin.order.items.state',
        ]);

        Route::get('order/print/status/{state}', [
            'uses' => 'OrderController@getOrdersByStateType',
            'as'   => 'admin.order.print.state',
        ]);

        Route::get('order/picture/status/active', [
            'uses' => 'OrderController@indexPictureActive',
            'as'   => 'admin.order.picture.active',
        ]);
        Route::get('order/picture/state/active', [
            'uses' => 'OrderController@indexPictureActive',
            'as'   => 'admin.order.picture.state.active',
        ]);
        Route::get('order/picture/status/reserved', [
            'uses' => 'OrderController@indexPictureActive',
            'as'   => 'admin.order.picture.reserved',
        ]);
        Route::get('order/picture/status/paid', [
            'uses' => 'OrderController@indexPictureActive',
            'as'   => 'admin.order.picture.paid',
        ]);
        Route::get('order/picture/status/packing', [
            'uses' => 'OrderController@indexPicturePacking',
            'as'   => 'admin.order.picture.packing',
        ]);
        Route::get('order/picture/status/delivery', [
            'uses' => 'OrderController@indexPictureDelivery',
            'as'   => 'admin.order.picture.delivery',
        ]);
        Route::get('order/picture/status/completed', [
            'uses' => 'OrderController@indexPictureCompleted',
            'as'   => 'admin.order.picture.completed',
        ]);
        Route::get('order/picture/status/cancelled', [
            'uses' => 'OrderController@indexPictureCalcelled',
            'as'   => 'admin.order.picture.cancelled',
        ]);
        Route::get('order/picture/status/archived', [
            'uses' => 'OrderController@indexPictureArchived',
            'as'   => 'admin.order.picture.archived',
        ]);
        Route::get('order/{order_id}/state/prepared', [
            'uses' => 'OrderController@setOrderStatePrepared',
            'as'   => 'admin.order.state.prepared',
        ]);

        Route::get('order/{order_id}/state/produced', [
            'uses' => 'OrderController@setOrderStateProduced',
            'as'   => 'admin.order.state.produced',
        ]);
        Route::get('order/{order_id}/state/packed', [
            'uses' => 'OrderController@setOrderStatePacked',
            'as'   => 'admin.order.state.packed',
        ]);
        Route::get('order/{order_id}/state/completed', [
            'uses' => 'OrderController@setOrderStateCompleted',
            'as'   => 'admin.order.state.completed',
        ]);

        Route::get('order/{order_id}/state/reserved', [
            'uses' => 'OrderController@setOrderStateReserved',
            'as'   => 'admin.order.state.reserved',
        ]);

        Route::get('order/{order_id}/state/cancelled', [
            'uses' => 'OrderController@setOrderStateCancelled',
            'as'   => 'admin.order.state.cancelled',
        ]);

        Route::post('order/state/shipped', [
            'uses' => 'OrderController@setOrderStateShipped',
            'as'   => 'admin.order.state.shipped',
        ]);

        Route::group(['prefix' => 'users'], function () {
            Route::get('common/{status?}', ['uses' => 'AdminController@usersCommon', 'as' => 'admin.users.common']);

            Route::get('user/favorite/toggle/{id}', [
                'uses' => 'AdminController@toggleFavorite',
                'as'   => 'user.favorite.toggle',
            ]);
            Route::get('user/rejected/toggle/{id}', [
                'uses' => 'ArtistController@toggleRejected',
                'as'   => 'user.rejected.toggle',
            ]);
            Route::get('user/viewed/toggle/{id}', [
                'uses' => 'ArtistController@toggleViewed',
                'as'   => 'user.viewed.toggle',
            ]);
            Route::get('user/top/toggle/{id}', ['uses' => 'AdminController@toggleTop', 'as' => 'user.top.toggle']);

            Route::get('all', ['uses' => 'AdminController@usersAll', 'as' => 'admin.users.all']);
            Route::get('new', ['uses' => 'AdminController@usersNew', 'as' => 'admin.users.new']);
            Route::get('active', ['uses' => 'AdminController@usersActive', 'as' => 'admin.users.active']);
            Route::get('blocked', ['uses' => 'AdminController@usersBlocked', 'as' => 'admin.users.blocked']);

            Route::get('artist/new', ['uses' => 'ArtistController@showNew', 'as' => 'admin.users.artist.new']);
            Route::get('artist/accepted', [
                'uses' => 'ArtistController@showAccepted',
                'as'   => 'admin.users.artist.accepted',
            ]);
            Route::get('artist/rejected', [
                'uses' => 'ArtistController@showRejected',
                'as'   => 'admin.users.artist.rejected',
            ]);
            Route::get('artist/deleted', [
                'uses' => 'ArtistController@showDeleted',
                'as'   => 'admin.users.artist.deleted',
            ]);
            Route::get('artist/gallery', [
                'uses' => 'ArtistController@showGalleryMembers',
                'as'   => 'admin.users.artist.gallery',
            ]);
            Route::get('artist/index', ['uses' => 'ArtistController@index', 'as' => 'admin.users.artist']);
            Route::get('artist/top', ['uses' => 'ArtistController@showTop', 'as' => 'admin.users.artist.top']);
            Route::delete('artist/{user_with_trashed}', [
                'uses' => 'ArtistController@destroy',
                'as'   => 'admin.users.artist.destroy',
            ]);

            Route::get('gallery/new', ['uses' => 'GalleryController@showNew', 'as' => 'admin.users.gallery.new']);
            Route::get('gallery/accepted', [
                'uses' => 'GalleryController@showAccepted',
                'as'   => 'admin.users.gallery.accepted',
            ]);
            Route::get('gallery/rejected', [
                'uses' => 'GalleryController@showRejected',
                'as'   => 'admin.users.gallery.rejected',
            ]);
            Route::get('gallery/top', ['uses' => 'GalleryController@showTop', 'as' => 'admin.users.gallery.top']);
            Route::get('gallery/index', ['uses' => 'GalleryController@index', 'as' => 'admin.users.gallery']);

            Route::get('gallery/{id}/rejected/toggle', [
                'uses' => 'GalleryController@toggleRejected',
                'as'   => 'gallery.rejected.toggle',
            ]);
            Route::get('gallery/{id}/viewed/toggle', [
                'uses' => 'GalleryController@toggleViewed',
                'as'   => 'gallery.viewed.toggle',
            ]);
            Route::get('gallery/{id}/top/toggle', ['uses' => 'GalleryController@toggleTop', 'as' => 'gallery.top.toggle']);
        });

        Route::group(['prefix' => 'items'], function () {
            Route::get('product/{type}/new', ['uses' => 'ProductController@getProductsNew', 'as' => 'admin.products.new']);
            Route::get('product/{type}/favorite', [
                'uses' => 'ProductController@getProductsFavorite',
                'as'   => 'admin.products.favorite',
            ]);
            Route::get('product/{type}/index', [
                'uses' => 'ProductController@getProductsIndex',
                'as'   => 'admin.products.index',
            ]);
            Route::get('product/{type}/rejected', [
                'uses' => 'ProductController@getProductsRejected',
                'as'   => 'admin.products.rejected',
            ]);
            Route::get('product/{type}/top', ['uses' => 'ProductController@getProductsTop', 'as' => 'admin.products.top']);

            Route::get('product/{type}/filter/status/{status}', [
                'uses' => 'ProductController@getFilteredByStatus',
                'as'   => 'admin.products.filter',
            ]);

            Route::get('product/{product}/status/{status}', [
                'uses' => 'ProductController@updateProductStatus',
                'as'   => 'admin.product.status.update',
            ]);

            Route::get('product/{type}/not_for_sale', [
                'uses' => 'ProductController@getProductsNotForSale',
                'as'   => 'admin.products.not_for_sale',
            ]);
            Route::get('product/{type}/sold', [
                'uses' => 'ProductController@getProductsSold',
                'as'   => 'admin.products.sold',
            ]);

            Route::get('product/favorite/toggle/{id}', [
                'uses' => 'ProductController@toggleFavorite',
                'as'   => 'product.favorite.toggle',
            ]);
            Route::get('product/rejected/toggle/{id}', [
                'uses' => 'ProductController@toggleRejected',
                'as'   => 'product.rejected.toggle',
            ]);
            Route::get('product/viewed/toggle/{id}', [
                'uses' => 'ProductController@toggleViewed',
                'as'   => 'product.viewed.toggle',
            ]);
            Route::get('product/top/toggle/{id}', ['uses' => 'ProductController@toggleTop', 'as' => 'product.top.toggle']);
        });

        Route::group(['prefix' => 'finance'], function () {
            Route::get('settings', ['uses' => 'AdminController@showFinanceSettings', 'as' => 'admin.finance.settings']);
            Route::post('settings', [
                'uses' => 'AdminController@updateFinanceSettings',
                'as'   => 'admin.finance.settings.update',
            ]);
        });

        Route::group(['prefix' => 'commissions'], function () {
            Route::get('new', ['uses' => 'CommissionController@accrued', 'as' => 'admin.commissions.new']);
            Route::get('pending', ['uses' => 'CommissionController@pending', 'as' => 'admin.commissions.pending']);
            Route::get('ready', ['uses' => 'CommissionController@ready', 'as' => 'admin.commissions.ready']);
            Route::get('archive', ['uses' => 'CommissionController@archive', 'as' => 'admin.commissions.archive']);
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('new', ['uses' => 'AdminController@blank', 'as' => 'admin.orders.new']);
            Route::get('in-progress', ['uses' => 'AdminController@blank', 'as' => 'admin.orders.in-progress']);
            Route::get('completed', ['uses' => 'AdminController@blank', 'as' => 'admin.orders.completed']);
            Route::get('canceled', ['uses' => 'AdminController@blank', 'as' => 'admin.orders.canceled']);
            Route::get('disputable', ['uses' => 'AdminController@blank', 'as' => 'admin.orders.disputable']);
        });
    });


