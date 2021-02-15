<?php

use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function (){
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');
});
Route::group(['namespace' => 'Api','middleware' => 'auth:api'], function(){
    Route::resource('cart', 'CartApiController');
    Route::resource('order', 'OrderApiController');
    Route::post('order-return', 'OrderApiController@purchaseReturn');
    Route::get('order-history-detail/{id}', 'OrderApiController@orderHistoryDetail');
    Route::post('user-detail','UserApiController@userDetails');
    Route::get('get-user-detail/{id}','UserApiController@getUserDetail');
    Route::get('get-account-detail/{id}','UserApiController@getAccountDetail');
    Route::post('change-account','UserApiController@changeAccount');
    Route::post('get-account-detail','UserApiController@changeAccount');
    Route::post('upload-profile-picture','UserApiController@uploadProfilePicture');
    });
Route::group(['namespace' => 'Api'], function (){
    Route::get('get-product-by-category/{id}', 'ProductApiController@getProductByCategory');
    Route::post('register','UserApiController@register');
    Route::post('login','UserApiController@login');
    Route::post('create','UserApiController@create');
    Route::get('find/{token}', 'UserApiController@find');
    Route::post('reset','UserApiController@passwordReset');
    Route::resource('products','ProductApiController');
    Route::post('filtter-product','ProductApiController@searchProduct');
    Route::resource('product-categories','ProductCategoriesController');
    Route::resource('get-pages','PageApiController');
    Route::get('get-used-product-color','ProductApiController@getUsedColor');
    Route::get('get-used-product-fabric','ProductApiController@getUsedFabric');
    Route::get('show-home-product','HomePageApiController@getHomePageProducts');
    Route::get('home-page-api','HomePageApiController@homePageApi');
    Route::post('sort-products','ProductApiController@sortProduct');
});
