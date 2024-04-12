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
                            'location'                   => 'LocationController',
                            'building'                   => 'BuildingController',
                            'room'                       => 'RoomController',
                            'storage'                    => 'CompartmentController',
                            'product'                    => 'ProductController',
                            'company'                    => 'CompanyController',
                            'contact'                    => 'ContactController',
                            'address'                    => 'AddressController',
                            'equipment'                  => 'EquipmentController',
                            'product_parameter'          => 'ProductParameterController',
                            'product_category'           => 'ProductCategoryController',
                            'product_category_parameter' => 'ProductCategoryParameterController',
                        ]);

    Route::get('/location_list_complete', 'LocationController@full')->name('location_list_complete');
    Route::get('/building_list_complete', 'BuildingController@full')->name('building_list_complete');
    Route::get('/room_list_complete', 'RoomController@full')->name('room_list_complete');
    Route::get('/storage_list_complete', 'CompartmentController@full')->name('storage_list_complete');
    Route::post('/locations', 'LocationController@storemany')->name('addlocations');
    Route::post('/buildings', 'BuildingController@storemany')->name('addbuildings');
    Route::post('/rooms', 'RoomController@storemany')->name('addrooms');
    Route::post('/storages', 'CompartmentController@storemany')->name('addstorages');
    Route::post('/addresses', 'AddressController@storemany')->name('addresses');
    Route::post('/companies', 'CompanyController@storemany')->name('companies');
    Route::post('/contacts', 'ContactController@storemany')->name('make.contacts');

    /**
     *   Product API endpoints
     */
    Route::get('/product_list_complete', 'ProductController@full')->name('product_list_complete');
    Route::post('/products', 'ProductController@storemany')->name('addProducts');
    Route::post('/product/add/employee_qualified', 'ProductController@addQualifiedEmployee')->name('product.add.employee_qualified');
    Route::post('/product/add/company', 'ProductController@addCompany')->name('product.add.company');
//    Route::post('/product/add/instructed_employee/', 'ProductController@addInstructedUser')->name('product.add.instructed_user');





});

Route::fallback(function () {
    return response()->json([
                                'status' => 'requested endpoint not found'
                            ], 404);
})->name('api_fallback');
/**
 *  NO ROUTES UNDER THIS LAST ONE !!!
 */
