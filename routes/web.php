<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Frontend\PageController;


//  Frontend //
Route::redirect('/home', '/');
/*Route::get('/', function () {
    return view('frontend.home');
});*/ 
Route::group(['namespace' => 'Frontend'], function () {
    //
    Route::get('/', 'HomeController@index');
        /*return view('frontend.home');
    });*/
    Route::get('/page/{slug}', 'PageController@showPage')->name('homepage');

    //Shop 
    Route::resource('shop','ShopController');
    Route::post('/shop-filter','ShopController@productFilter');
});


// Admin //
Auth::routes(['register' => false]);
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');
    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');
   // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::resource('categories','CategoriesController');
    Route::get('destroy-category/{id}','CategoriesController@destroy');
    Route::resource('pages','PagesController');
    Route::resource('product','ProductController');
    Route::get('get-category/{id}','ProductController@getCategory');
    Route::get('get-style-image/{id}','ProductController@getStyleImage');
    Route::get('set-varient/{id}/{galid?}/{type?}','ProductController@setVarient')->name('set-varient');
    // create variantion
    Route::post('create-varient/','ProductController@createVarient')->name('create-varient');
    Route::post('delete-variant/','ProductController@deleteVarient')->name('delete-varient');
    Route::post('save-varients/','ProductController@saveVarient')->name('save-varients');

    //Menu
    Route::resource('menu','MenusController');
    Route::get('destroy-menus/{id}','MenusController@destroy');
        Route::resource('manage-menu','MenuController');
        Route::get('destroy-menu/{id}','MenuController@destroy');
    
    //Attribute
    Route::resource('attribute','AttributesController');
    Route::get('delete-attribute/{id}','AttributesController@destroy');
        // -- // Terms
        Route::resource('terms','AttributesTermsController');
        Route::get('delete-term/{id}','AttributesTermsController@destroy');
    //

    Route::resource('tax','TaxController');
    Route::resource('color','ColorCustomizationController');
    Route::resource('product-size-setting','ProductSizeController');
    Route::resource('product-size-value-setting','ProductSizeValueController');
    Route::get('get-size-varient/{var}','ProductSizeValueController@getSizeVarient');
    Route::resource('product-size-chart','ProductSizeChartController');
    Route::resource('product-style-customization','ProductStyleCustomizationController');
    Route::resource('measurement-instruction','MeasurementInstructionController');
    Route::resource('selling-zone','SellingZoneController');
    Route::get('get-state/{id}','SellingZoneController@getState');
    Route::get('get-city/{id}','SellingZoneController@getCity');
    Route::resource('brand-setting','ProductBrandController');
    Route::resource('fabric-setting','FabricController');
    Route::resource('price-range','PriceRangeController');
    Route::post('set-product-color-variant','SetProductVariantController@setProductColorVariant')->name('set-product-color-variant');
    Route::post('set-product-fabric/{id?}','SetProductVariantController@setProductFabric')->name('set-product-fabric');
    Route::get('edit-product-fabric/{id}','SetProductVariantController@editProductFabric')->name('edit-product-fabric');
    Route::post('set-product-gallary','SetProductVariantController@setProductGallary')->name('set-product-gallary');
    Route::post('set-custom-style/{id}/{op?}','SetProductVariantController@setCustomStyle')->name('set-custom-style');
    //Route::post('set-sleeve_type/{id}','SetProductVariantController@setSleeveType')->name('set-sleeve_type');
    // Route::post('set-length_type/{id}','SetProductVariantController@setLengthType')->name('set-length_type');
     Route::get('get-size-value/{id}','SetProductVariantController@getSizeValue')->name('get-size-value');
     Route::post('set-standard_size','SetProductVariantController@setStandardSize');
     Route::post('set-available-height','SetProductVariantController@setAvailableHeight');
     Route::post('add-matching-product','SetProductVariantController@addMatchingProducts');
     Route::get('reset-session','SetProductVariantController@resetSession');
     Route::get('editVariant/{id}/{type}','SetProductVariantController@editVariant');
     Route::delete('remove-variant/{id}','SetProductVariantController@removeVariant');
     Route::delete('remove-product-gallary/{id}','SetProductVariantController@removeProductGallary');
     Route::delete('remove-whole-set-variant/{id}/{style}','SetProductVariantController@removeWholeSetVariant');
     Route::resource('home','HomeController');
     Route::get('load-page','HomeController@loadPage')->name('load-page');
     Route::get('add-module','HomeController@addModule')->name('add-module');
     Route::resource('order', 'OrderController');
     Route::get('order-return', 'OrderController@orderReturn')->name('order-return');
     Route::get('generate-pdf',"OrderController@invoicePdf")->name("generate-pdf");
     Route::post('change-order-status',"OrderController@changeOrderStatus");
     Route::resource('mail-template',"MailTemplate");

     Route::resource('setting',"SettingController");

     Route::get('return-back', function() {
        echo '<script type="text/javascript">'
               , 'history.go(-2);'
               , '</script>';
     });

   
});


