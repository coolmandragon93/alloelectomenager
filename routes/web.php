<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * Default Routes
 */
Route::get('/', 'ProductsController@index')->name("home");


/**
 * Search Routes
 */
Route::get('recherche', 'SearchController@search_appliance')->name('search_appliance');
Route::get('{type}/{model}/{product_id}/{family_name}/{family_id}/details', 'ProductsController@product')->name("product");
Route::get('{type}/{model}/{appliance_id}/'.str_slug('pièces-detachees', '-'), 'SearchController@search_results')->name("search-results");
Route::get('{type}/{model}/{appliance_id}/{vgruppenid}/{vgruppenname}/'.str_slug('pièces-detachees', '-'), 'SearchController@search_results')->name("search-results-family");

Route::get(str_slug('pièces-detachees', '-').'/{brand}/{type}/{marque}/{appliance_id}/', 'SearchController@search_results2')->name("search-results2");


/**
 * Individual product page
 */
// Route::get('product/{model}/{product_id}', 'ProductsController@singleProduct')->name("singleProduct");
Route::get('pieces-detachees-electromenager/{model}/{product_id}', 'ProductsController@singleProduct')->name("singleProduct");


/**
 * Atos payment
 */
Route::get('atos', "PaymentController@atos")->name("atos");
Route::get('atos/log', "PaymentController@atosLog")->name("atos.log");


/**
 * Utility Routes
 */
Route::get('get_delivery_date/{product_id}', 'ProductsController@ajax_get_delivery_date');

/**
 * information routes
 */
Route::group(['prefix' => 'information'], function () {
    Route::get('conditions-de-vente', "InfoController@conditions")->name("conditions");
    Route::get('qui-sommes-nous', "InfoController@quisommesnous")->name("quisommesnous");
    Route::get('paiement-securise', "InfoController@paiement")->name("paiement");
    Route::get('livraison', "InfoController@livraison")->name("livraison");
});

/**
 * Brand routes
 */
Route::get('pieces-detachees-electromenager-{brand}', "InfoController@brands")->name("brands");

/**
 * Cart routes
 */
Route::group(['prefix' => 'panier', 'as' => 'cart.'], function () {
    Route::get('/', "CartController@index")->name("index");
    Route::get("ajouter", "CartController@add")->name("add");
    Route::get("supprimer", "CartController@remove")->name("remove");
    Route::get("reactualiser", "CartController@update")->name("update");
    Route::get("shipping", "CartController@shipping")->name("shipping");
    Route::get("checkout", "CartController@checkout")->name("checkout");
    Route::get("cancel", "CartController@cancel")->name("cancel");
    Route::post("cancel", "CartController@cancel")->name("cancel");

    Route::post("payment", "PaymentController@index")->name("payment");

    Route::get('facture/{id}', 'InvoiceController@invoice')->name('invoice');


    Route::get("confirmation/paypal", "PaymentController@paypalProcess")->name("paypalProcess");
    Route::get("confirmation/cc", "PaymentController@atosProcess")->name("atosProcess");
    Route::post("confirmation/cc", "PaymentController@atosProcess")->name("atosProcess");
});

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::get('/', 'Admin\AdminController@index')->name('index');
    Route::get('/order/{id}', 'Admin\AdminController@order')->name('order');
    Route::get('/login', 'Admin\AdminController@login')->name('login');
    Route::post('/login', 'Admin\AdminController@login')->name('login');

    Route::post('/order/{id}', 'Admin\AdminController@orderStatus')->name('orderStatus');

    // Orders
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', 'Admin\OrderController@index')->name('index');
        Route::get('{id}', 'Admin\OrderController@show')->name('show');
        Route::put('{id}', 'Admin\OrderController@update')->name('update');
        Route::delete('{id}', 'Admin\OrderController@destroy')->name('destroy');


        Route::get('/invoice/{id}', 'Admin\OrderController@invoice')->name('order');
        Route::get('/send/invoice/{id}', 'Admin\OrderController@sendInvoice')->name('send');
    });
    Route::get('/order_data', 'Admin\OrderController@order_data')->name('order_data');

    Route::get('/show_order', 'Admin\OrderController@show_order')->name('show_order');

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/edit/{id}', 'Admin\OrderController@edit')->name('edit');
        Route::put('/edit/{id}', 'Admin\OrderController@editOrder')->name('editOrder');
    });

    //admin api
    Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
        Route::get('orders', 'Admin\AdminController@getOrders')->name('getOrders');
        Route::get('orders/delete/{id}', 'Admin\AdminController@delete_order')->name('delete_order');
    });

    // Price rules
    Route::get('price_rules/delete/{id}', 'Admin\PriceRulesController@delete');
    Route::resource('price_rules', 'Admin\PriceRulesController');

    // Brands
    Route::get('brands/{keyBrand}/{keyProduct}/edit-product', 'Admin\BrandsController@editProduct');
    Route::post('brands/update-product/{keyBrand}/{keyProduct}', 'Admin\BrandsController@updateProduct');
    Route::get('brands/delete-product/{keyBrand}/{keyProduct}', 'Admin\BrandsController@deleteProduct');
    Route::get('brands/delete-brand', 'Admin\BrandsController@deleteBrand');
    Route::get('brands/edit-brand', 'Admin\BrandsController@editBrand');
    Route::post('brands/edit-brand-save', 'Admin\BrandsController@editBrandSave');
    Route::resource('brands', 'Admin\BrandsController');
    Route::post('brands/create-brand', 'Admin\BrandsController@createBrand');
    Route::get('brands/check-valid-product/{product_code}', 'Admin\BrandsController@checkValidProduct');

    // Products
    Route::get('products/check_all', 'Admin\ProductController@check_all')->name('products.check_all');
    Route::post('products/get-link', 'Admin\ProductController@getLink')->name('products.get_link');
    Route::get('products/links', 'Admin\ProductController@link')->name('products.link');
    Route::resource('products', 'Admin\ProductController');
    Route::get('products/{aswo_id}/info', 'Admin\ProductController@info')->name('products.info');
    Route::get('products/{id}/update/purchase_price', 'Admin\ProductController@update_purchase_price')->name('products.update_purchase_price');
    Route::get('finder', 'Admin\ProductController@finder')->name('products.finder');



    // Manufacturer
    Route::resource('manufacturers', 'Admin\ManufacturerController');

    // ASWO API
    Route::get('aswo', 'Admin\Aswo\AswoController@index')->name('aswo.index');

    Route::get('aswo/article-pictures-200', 'Admin\Aswo\AswoController@article_pictures_200')->name('aswo.article_pictures_200');
    Route::post('aswo/article-pictures-200', 'Admin\Aswo\AswoController@post_article_pictures_200')->name('aswo.article_pictures_200');

    Route::get('aswo/article-pictures-800', 'Admin\Aswo\AswoController@article_pictures_800')->name('aswo.article_pictures_800');
    Route::post('aswo/article-pictures-800', 'Admin\Aswo\AswoController@post_article_pictures_800')->name('aswo.article_pictures_800');

    Route::get('aswo/article-search', 'Admin\Aswo\AswoController@article_search')->name('aswo.article_search');
    Route::post('aswo/article-search', 'Admin\Aswo\AswoController@post_article_search')->name('aswo.article_search');

    Route::get('aswo/extended-article-search', 'Admin\Aswo\AswoController@extended_article_search')->name('aswo.extended_article_search');
    Route::post('aswo/extended-article-search', 'Admin\Aswo\AswoController@post_extended_article_search')->name('aswo.extended_article_search');

    Route::get('aswo/article-detail-information', 'Admin\Aswo\AswoController@article_detail_information')->name('aswo.article_detail_information');
    Route::post('aswo/article-detail-information', 'Admin\Aswo\AswoController@post_article_detail_information')->name('aswo.article_detail_information');

    Route::get('aswo/suggestlist', 'Admin\Aswo\AswoController@suggestlist')->name('aswo.suggestlist');
    Route::post('aswo/suggestlist', 'Admin\Aswo\AswoController@post_suggestlist')->name('aswo.suggestlist');

    Route::get('aswo/article-families', 'Admin\Aswo\AswoController@article_families')->name('aswo.article_families');
    Route::post('aswo/article-families', 'Admin\Aswo\AswoController@post_article_families')->name('aswo.article_families');

    Route::get('aswo/article-for-appliance-search', 'Admin\Aswo\AswoController@article_for_appliance_search')->name('aswo.article_for_appliance_search');

    Route::get('aswo/appliance-search', 'Admin\Aswo\AswoController@appliance_search')->name('aswo.appliance_search');
    Route::post('aswo/appliance-search', 'Admin\Aswo\AswoController@post_appliance_search')->name('aswo.appliance_search');

    Route::get('aswo/article-families-for-an-appliance', 'Admin\Aswo\AswoController@article_families_for_an_appliance')->name('aswo.article_families_for_an_appliance');
    Route::post('aswo/article-families-for-an-appliance', 'Admin\Aswo\AswoController@post_article_families_for_an_appliance')->name('aswo.article_families_for_an_appliance');

    Route::get('aswo/articles-for-an-appliance', 'Admin\Aswo\AswoController@articles_for_an_appliance')->name('aswo.articles_for_an_appliance');
    Route::post('aswo/articles-for-an-appliance', 'Admin\Aswo\AswoController@post_articles_for_an_appliance')->name('aswo.articles_for_an_appliance');

    Route::get('aswo/search-result-quick-check', 'Admin\Aswo\AswoController@search_result_quick_check')->name('aswo.search_result_quick_check');
    Route::post('aswo/search-result-quick-check', 'Admin\Aswo\AswoController@post_search_result_quick_check')->name('aswo.search_result_quick_check');

    Route::get('aswo/check-list-of-appliances-for-available-articles', 'Admin\Aswo\AswoController@check_list_of_appliances_for_available_articles')->name('aswo.check_list_of_appliances_for_available_articles');
    Route::post('aswo/check-list-of-appliances-for-available-articles', 'Admin\Aswo\AswoController@post_check_list_of_appliances_for_available_articles')->name('aswo.check_list_of_appliances_for_available_articles');
});

    Route::get('admin/sauv', 'Admin\ProductController@sauv');
    Route::get('admin/sauv/{id}', 'Admin\ProductController@sauvshow');


/**
 * Mockup routes
 */
Route::group(['prefix' => 'products'], function () {

    // Route::get('/', 'ProductsController@index');
    Route::get('new', 'ProductsController@index_new');
    Route::get('appliance', 'ProductsController@appliance');
    Route::get('product/{model}/{product_id}', 'ProductsController@product1');
    Route::get('search_results/{model}/{appliance_id}/{vgruppenid?}', 'ProductsController@search_results1');
    Route::get('results', 'ProductsController@results');
    Route::get('checkout', 'ProductsController@checkout');
});

// Contact
Route::get('contact', 'ProductsController@contact');
Route::post('contact/process', 'ProductsController@process');


Route::get('products/update-ids', function () {
    $products = \App\Product::all();

    $list = [];
    $duplicates = [];
    foreach ($products as $product) {
        if (in_array($product->aswo_id, $list)) {
            $duplicates[] = $product->aswo_id;
            $product->delete();
        }

        $list[] = $product->aswo_id;
    }

    dd($duplicates);
});

Route::get('feed/google/xml', 'GoogleShoppingController@xml')->name('feed.google')->middleware('auth.basic');

/**
 * Auth routes
 */
Auth::routes();

// Data orders for hq
Route::get('jsondata', function () {
    $orders = DB::table('orders')
        
        ->join('order_histories', function ($join) {
            $join->on('orders.id', '=', 'order_histories.order_id')
                
                ->where('order_histories.state', 'En cours');
        })

        ->orderBy('orders.id', 'desc')
       ->first();
    return $orders;
});




Route::any('/admin/search', function () {
    $q = Input::get('q');
    $order = Order::where('id', 'LIKE', '%'.$q.'%')->orWhere('email', 'LIKE', '%'.$q.'%')->get();
    if (count($order) > 0) {
        return view('admin.search.index')->withDetails($order)->withQuery($q);
    } else {
        return view('admin.search.index')->withMessage('No Details found. Try to search again !');
    }
});

Route::get('listep', function () {
    $liste = DB::table('products')
        ->get();

    return $liste;
});


Route::get('stats/mars', function () {
    $orders = DB::table('orders')
        ->join('order_histories', function ($join) {
            $join->on('orders.id', '=', 'order_histories.order_id')
                ->whereBetween('orders.created_at', ['2018-06-01 00:00:00', '2018-06-30 00:00:00'])
                ->Where('order_histories.state', 'Terminée');
        })
        ->sum('orders.total_products');

    $ship = DB::table('orders')
        ->join('order_histories', function ($join) {
            $join->on('orders.id', '=', 'order_histories.order_id')
                ->whereBetween('orders.created_at', ['2018-06-01 00:00:00', '2018-06-30 00:00:00'])
                ->Where('order_histories.state', 'Terminée');
        })
        ->sum('orders.total_shipping');

    $liste = $orders + $ship;
    return $liste;
});

Route::get('stats/mars/count', function () {
    $nbr = DB::table('orders')
        ->join('order_histories', function ($join) {
            $join->on('orders.id', '=', 'order_histories.order_id')
                ->whereBetween('orders.created_at', ['2018-04-01 00:00:00', '2018-04-30 00:00:00'])
                ->Where('order_histories.state', 'Terminée');
        })
        ->count();

    return $nbr;
});

//Api

Route::get('api/orders', 'api\OrdersController@ShowOrders');
Route::get('api/orders/{id}', 'api\OrdersController@show');

/*
* added by Taha - autocomplete search
*/
Route::get('send-search-request-to-aswo/', 'SearchController@sendRequestSearchToAswo');
/*
* New search by geraetet reffer
* Appliance Search
* Article families for an appliance
* Articles for an appliance(Top articles)
*/
Route::get('recherche/{appliance_id}', 'SearchController@search_autocomplete_appliance')->name("search-autocomplete-appliance");
