<?php

use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('portal-main');
    });

    Route::get('support', function () {
        return view('support');
    });
Route::get('organisation', function () {
    return view('admin.organisation.index');
});
    Route::get('docs', function () {
        return view('docs.index');
    });

Route::get('registerphone', function () {
    return view('admin.registerphone');
});


    Route::resources([
        'location' => 'LocationsController',
        'building' => 'BuildingsController',
        'room'=> 'RoomController',
        'profile' => 'ProfileController',
        'produkt' => 'ProduktController',
        'produktDoku' => 'ProduktDocController',
        'firma' => 'FirmaController',
        'address' => 'AddressController',
        'testware' => 'TestwareController',
        'equipment' => 'EquipmentController',
        'control' => 'ControlController',

    ]);




    Route::get('/downloadProduktDokuFile','ProduktDocController@downloadProduktDokuFile')->name('downloadProduktDokuFile');
    Route::get('getProduktListe','ProduktController@getProduktListe')->name('getProduktListe');
    Route::get('importProdukt','ProduktController@importProdukt')->name('importProdukt');
    Route::get('exportProdukt','ProduktController@exportProdukt')->name('exportProdukt');
    Route::get('produkt.getProduktIdListAll','ProduktController@getProduktIdListAll')->name('produkt.getProduktIdListAll');

    Route::get('/produkt/kategorie/{id}','ProduktController@getKategorieProducts')->name('getKategorieProducts');
    Route::delete('deleteProduktKategorieParam','ProduktController@deleteProduktKategorieParam')->name('deleteProduktKategorieParam');
    Route::get('getProduktKategorieParams','ProduktController@getProduktKategorieParams')->name('getProduktKategorieParams');
    Route::post('addProduktKategorieParam','ProduktController@addProduktKategorieParam')->name('addProduktKategorieParam');
    Route::get('getUsedProduktsByPK','ProduktController@getUsedProduktsByPK')->name('getUsedProduktsByPK');

    Route::post('addProduktFirma','ProduktController@addProduktFirma')->name('addProduktFirma');
    Route::delete('removeFirmaFromProdukt','ProduktController@removeFirmaFromProdukt')->name('removeFirmaFromProdukt');

    Route::put('updateProduktKategorieParams','ProduktController@updateProduktKategorieParams')->name('updateProduktKategorieParams');


    Route::post('addProduktParams','ProduktController@addProduktParams')->name('addProduktParams');
    Route::post('addProderialKategorie','ProduktController@addProderialKategorie')->name('addProderialKategorie');
    Route::post('addAnforderung','ProduktController@addAnforderung')->name('addAnforderung');
    Route::post('addProduktAnforderung','ProduktController@addProduktAnforderung')->name('addProduktAnforderung');
    Route::delete('deleteProduktAnfordrung','ProduktController@deleteProduktAnfordrung')->name('deleteProduktAnfordrung');

Route::get('getFirmenAjaxListe','FirmaController@getFirmenAjaxListe')->name('getFirmenAjaxListe');
Route::get('getFirmenDaten','FirmaController@getFirmenDaten')->name('getFirmenDaten');

Route::get('getAddressenAjaxListe','AddressController@getAddressenAjaxListe')->name('getAddressenAjaxListe');
Route::get('getAddressDaten','AddressController@getAddressDaten')->name('getAddressDaten');

/**
 *
 *
 *
 *   Admin Tool Routes
 *
 *
 *
 */
    Route::get('admin', 'AdminController@index')->name('admin.index');
    Route::get('admin/user', 'AdminController@indexUser')->name('user.index');
    Route::get('admin/reports', 'AdminController@indexReports');
    Route::get('admin/reports/template', 'AdminController@indexReportsTemplate')->name('report.tempate');
    Route::get('admin/systems', 'AdminController@systems')->name('systems');
//    Route::get('registerphone', 'AdminController@systems')->name('registerphone');

    Route::delete('room.destroyRoomAjax', 'RoomController@destroyRoomAjax')->name('room.destroyRoomAjax');
    Route::delete('location.destroyLocationAjax', 'LocationsController@destroyLocationAjax')->name('location.destroyLocationAjax');
    Route::delete('destroyBuildingAjax', 'BuildingsController@destroyBuildingAjax')->name('destroyBuildingAjax');

    Route::get('getBuildingList/{locid}', 'BuildingsController@getBuildingList')->name('room.getBuildingList');

    Route::put('updateUserTheme', 'AdminController@updateUserTheme')->name('updateUserTheme');

    Route::post('createAddressType', 'AdminController@createAddressType')->name('createAddressType');
    Route::post('getAddressTypeData', 'AdminController@getAddressTypeData')->name('getAddressTypeData');
    Route::put('updateAddressType', 'AdminController@updateAddressType')->name('updateAddressType');
    Route::delete('deleteTypeAdress', 'AdminController@deleteTypeAdress')->name('deleteTypeAdress');
    Route::get('getUsedAdressesByAdressType', 'AdminController@getUsedAdressesByAdressType')->name('getUsedAdressesByAdressType');

    Route::post('createAjaxBuildingType', 'AdminController@createAjaxBuildingType')->name('createAjaxBuildingType');
    Route::post('createBuildingType', 'AdminController@createBuildingType')->name('createBuildingType');
    Route::post('getBuildingTypeData', 'AdminController@getBuildingTypeData')->name('getBuildingTypeData');
    Route::put('updateBuildingType', 'AdminController@updateBuildingType')->name('updateBuildingType');
    Route::get('getUsedBuildingsByBuildingType', 'AdminController@getUsedBuildingsByBuildingType')->name('getUsedBuildingsByBuildingType');
    Route::delete('deleteTypeBuilding', 'AdminController@deleteTypeBuilding')->name('deleteTypeBuilding');

    Route::put('updateRoomType', 'AdminController@updateRoomType')->name('updateRoomType');
    Route::post('createRoomType', 'AdminController@createRoomType')->name('createRoomType');
    Route::post('getRoomTypeData', 'AdminController@getRoomTypeData')->name('getRoomTypeData');
    Route::delete('deleteRoomType', 'AdminController@deleteRoomType')->name('deleteRoomType');
    Route::get('getUsedRoomsByRoomType', 'AdminController@getUsedRoomsByRoomType')->name('getUsedRoomsByRoomType');

    Route::put('updateProdKat', 'AdminController@updateProdKat')->name('updateProdKat');
    Route::post('createProdKat', 'AdminController@createProdKat')->name('createProdKat');
    Route::post('getProdKatData', 'AdminController@getProdKatData')->name('getProdKatData');
    Route::delete('deleteProdKat', 'AdminController@deleteProdKat')->name('deleteProdKat');
    Route::get('getUsedProderialsByProdKat', 'AdminController@getUsedProderialsByProdKat')->name('getUsedProderialsByProdKat');

    Route::post('createAnforderung', 'AdminController@createAnforderung')->name('createAnforderung');
    Route::post('addNewAnforderungControlItem', 'AdminController@addNewAnforderungControlItem')->name('addNewAnforderungControlItem');
    Route::put('updateAnforderung', 'AdminController@updateAnforderung')->name('updateAnforderung');
    Route::get('getAnforderungData', 'AdminController@getAnforderungData')->name('getAnforderungData');
    Route::delete('deleteAnforderung', 'AdminController@deleteAnforderung')->name('deleteAnforderung');
    Route::get('getUsedEquipmentByProdAnforderung', 'AdminController@getUsedEquipmentByProdAnforderung')->name('getUsedEquipmentByProdAnforderung');

    Route::post('createVerordnung', 'AdminController@createVerordnung')->name('createVerordnung');
    Route::put('updateVerordnung', 'AdminController@updateVerordnung')->name('updateVerordnung');
    Route::post('getVerordnungData', 'AdminController@getVerordnungData')->name('getVerordnungData');
    Route::delete('deleteVerordnung', 'AdminController@deleteVerordnung')->name('deleteVerordnung');
    Route::get('getAnforderungByVerordnungListe', 'AdminController@getAnforderungByVerordnungListe')->name('getAnforderungByVerordnungListe');
    Route::get('getUsedEquipmentByProdVerordnung', 'AdminController@getUsedEquipmentByProdVerordnung')->name('getUsedEquipmentByProdVerordnung');


    Route::post('createDokumentType', 'AdminController@createDokumentType')->name('createDokumentType');
    Route::put('updateDokumentType', 'AdminController@updateDokumentType')->name('updateDokumentType');
    Route::post('getDokumentTypeData', 'AdminController@getDokumentTypeData')->name('getDokumentTypeData');
    Route::delete('deleteDokumentType', 'AdminController@deleteDokumentType')->name('deleteDokumentType');
    Route::get('getUsedDokumentType', 'AdminController@getUsedDokumentType')->name('getUsedDokumentType');

    Route::post('stellplatz.store', 'StellplatzController@store')->name('stellplatz.store');
    Route::delete('destroyStellplatzAjax', 'StellplatzController@destroyStellplatzAjax')->name('destroyStellplatzAjax');

    Route::put('updateStellPlatzType', 'AdminController@updateStellPlatzType')->name('updateStellPlatzType');
    Route::post('createStellPlatzType', 'AdminController@createStellPlatzType')->name('createStellPlatzType');
    Route::post('getStellPlatzTypeData', 'AdminController@getStellPlatzTypeData')->name('getStellPlatzTypeData');
    Route::delete('deleteStellPlatzType', 'AdminController@deleteStellPlatzType')->name('deleteStellPlatzType');
    Route::get('getUsedObjByStellPlatzType', 'AdminController@getUsedObjByStellPlatzType')->name('getUsedObjByStellPlatzType');


    Route::get('getStandortIdListAll', 'AdminController@getStandortIdListAll')->name('getStandortIdListAll');




/**
 *
 *
 *
 *   E N D   Admin Tool Routes
 *
 *
 *
 */












Route::delete('deleteTypeLager', 'AdminController@deleteTypeLager')->name('deleteTypeLager');
Route::delete('deleteTypeEquip', 'AdminController@deleteTypeEquip')->name('deleteTypeEquip');










Route::get('acAdminLocations', 'SearchController@acAdminLocations')->name('acAdminLocations');


/*

PDF GENERATORS

*/
Route::get('pdf.standortListe', 'PdfGenerator@standortListe')->name('pdf.standortListe');

Route::get('/makePDF/{view}/{title}', function ($view, $title) {
    return App\Http\Controllers\PdfGenerator::makePDF($view, $title);
})->name('makePDF');


/*

Übergabe von GET Variablen an Route
Route::get('kb',function(){
    return view('kb',['kb'=>request('kb')]);
});

Übergabe von Wildcard-eingaben als getvar an Route
Route::get('post/{wildcard}, function($wildcard){
    if (!$wildcard){
        abort(404, 'File not found!!');
    }

    return view('post', 'getvar' => $wildcard);

});

$standorte = App\Location::latest('{var}')->get();  Sotrierung nach {var} desc
$standorte = App\Location::take()3->latest('{var}')->get(); nehme die 3 letzten Sotrierung nach {var} desc

*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth/register', 'HomeController@index')->name('auth.register');
