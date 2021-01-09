<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v1')->name('api.v1.')->namespace('Api\V1')->group(function () {
    Route::get('/status', function () {
        return response()->json([
            'status' => 'OK'
        ]);
    })->name('status');

    Route::apiResources([
        'location'    => 'LocationController',
        'building'    => 'BuildingController',
        'room'        => 'RoomController',
        'compartment' => 'CompartmentController',
        'product' => 'ProductController',
        'product_parameter' => 'ProductParameterController',
        'product_category' => 'ProductCategoryController',
        'product_category_parameter' => 'ProductCategoryParameterController',
    ]);

    Route::get('/location_list_complete', 'LocationController@full')->name('location_list_complete');
    Route::get('/building_list_complete', 'BuildingController@full')->name('building_list_complete');
    Route::get('/room_list_complete', 'RoomController@full')->name('room_list_complete');
    Route::get('/compartment_list_complete', 'CompartmentController@full')->name('compartment_list_complete');
    Route::get('/product_list_complete', 'ProductController@full')->name('product_list_complete');

});

Route::fallback(function () {
    return response()->json([
        'status' => 'requested endpoint not found'
    ], 404);
})->name('api_fallback');
/**
 *  NO ROUTES UNDER THIS LAST ONE !!!
 */
