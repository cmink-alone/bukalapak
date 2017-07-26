<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'products'], function(){

    Route::get('','productController@getAllProduct');
    Route::post('add','productController@addProduct');
    Route::post('remove','productController@removeProduct');

});

Route::group(['prefix'=>'brands'], function(){

    Route::get('','brandController@getAllBrand');
    Route::post('add','brandController@addBrand');
    Route::post('remove','brandController@removeBrand');

});

Route::group(['prefix'=>'categories'], function(){

    Route::get('','categoryController@getAllCategory');
    Route::post('add','categoryController@addCategory');
    Route::post('remove','categoryController@removeCategory');

});

Route::group(['prefix'=>'vendors'], function(){

    Route::get('','vendorController@getAllVendor');
    Route::post('add','vendorController@addVendor');
    Route::post('remove','vendorController@removeVendor');

});
