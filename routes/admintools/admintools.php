<?php
/**
*
*
*
*   Admin Tool Routes
*
 *
 *     Räume 29
 *     Gebäude 57
*
*
*/

Route::get('registerphone', function () {
    return view('admin.registerphone');
});
Route::get('organisation', function () {
    return view('admin.organisation.index');
});


Route::get('admin', 'AdminController@index')->name('admin.index');
Route::get('admin/user', 'AdminController@indexUser')->name('user.index');
Route::get('admin/reports', 'AdminController@indexReports');
Route::get('admin/reports/template', 'AdminController@indexReportsTemplate')->name('report.tempate');
Route::get('admin/systems', 'AdminController@systems')->name('systems');
Route::get('standortDataPort', 'AdminController@standortDataPort')->name('standortDataPort');
//    Route::get('registerphone', 'AdminController@systems')->name('registerphone');


/**
 *
 *
 *
 *   Stellplätze
 *
 *
 */


Route::delete('destroyStellplatzAjax', 'StellplatzController@destroyStellplatzAjax')->name('destroyStellplatzAjax');
Route::put('updateStellPlatzType', 'AdminController@updateStellPlatzType')->name('updateStellPlatzType');
Route::post('createStellPlatzType', 'AdminController@createStellPlatzType')->name('createStellPlatzType');
Route::post('getStellPlatzTypeData', 'AdminController@getStellPlatzTypeData')->name('getStellPlatzTypeData');
Route::delete('deleteStellPlatzType', 'AdminController@deleteStellPlatzType')->name('deleteStellPlatzType');
Route::get('getUsedObjByStellPlatzType', 'AdminController@getUsedObjByStellPlatzType')->name('getUsedObjByStellPlatzType');
Route::get('getUsedStellplatzByType', 'AdminController@getUsedStellplatzByType')->name('getUsedStellplatzByType');

Route::get('exportStellplatzJSON','DataportController@exportStellplatzJSON')->name('exportStellplatzJSON');
Route::post('importStellplatzJSON','DataportController@importStellplatzJSON')->name('importStellplatzJSON');


/**
 *
 *
 *
 *   Räume
 *
 *
 */

Route::delete('room.destroyRoomAjax', 'RoomController@destroyRoomAjax')->name('room.destroyRoomAjax');
Route::put('updateRoomType', 'AdminController@updateRoomType')->name('updateRoomType');
Route::post('createRoomType', 'AdminController@createRoomType')->name('createRoomType');
Route::post('getRoomTypeData', 'AdminController@getRoomTypeData')->name('getRoomTypeData');
Route::delete('deleteRoomType', 'AdminController@deleteRoomType')->name('deleteRoomType');
Route::get('getUsedRoomsByRoomType', 'AdminController@getUsedRoomsByRoomType')->name('getUsedRoomsByRoomType');
Route::get('copyRoom', 'RoomController@copyRoom')->name('copyRoom');
Route::get('getRoomListeAsKachel', 'RoomController@getRoomListeAsKachel')->name('getRoomListeAsKachel');
Route::get('getRoomListeAsTable', 'RoomController@getRoomListeAsTable')->name('getRoomListeAsTable');

Route::get('exportRoomJSON','DataportController@exportRoomJSON')->name('exportRoomJSON');
Route::post('importRoomJSON','DataportController@importRoomJSON')->name('importRoomJSON');



/**
 *
 *
 *
 *   Gebäude
 *
 *
 */

Route::delete('destroyBuildingAjax', 'BuildingsController@destroyBuildingAjax')->name('destroyBuildingAjax');
Route::post('createAjaxBuildingType', 'AdminController@createAjaxBuildingType')->name('createAjaxBuildingType');
Route::post('createBuildingType', 'AdminController@createBuildingType')->name('createBuildingType');
Route::post('getBuildingTypeData', 'AdminController@getBuildingTypeData')->name('getBuildingTypeData');
Route::put('updateBuildingType', 'AdminController@updateBuildingType')->name('updateBuildingType');
Route::get('getUsedBuildingsByBuildingType', 'AdminController@getUsedBuildingsByBuildingType')->name('getUsedBuildingsByBuildingType');
Route::delete('deleteBuildingType', 'AdminController@deleteBuildingType')->name('deleteBuildingType');
Route::get('getBuildingList/{locid}', 'BuildingsController@getBuildingList')->name('room.getBuildingList');
Route::get('copyBuilding', 'BuildingsController@copyBuilding')->name('copyBuilding');
Route::get('getBuildingListeAsTable', 'BuildingsController@getBuildingListeAsTable')->name('getBuildingListeAsTable');
Route::get('getBuildingListeAsKachel', 'BuildingsController@getBuildingListeAsKachel')->name('getBuildingListeAsKachel');

Route::get('exportBuildingJSON','DataportController@exportBuildingJSON')->name('exportBuildingJSON');
Route::post('importBuildingJSON','DataportController@importBuildingJSON')->name('importBuildingJSON');

/**
 *
 *
 *
 *   Standorte
 *
 *
 */

Route::post('addLocationAnforderung', 'LocationsController@addLocationAnforderung')->name('addLocationAnforderung');
Route::delete('deleteLocationAnforderung', 'LocationsController@deleteLocationAnforderung')->name('deleteLocationAnforderung');
Route::delete('location.destroyLocationAjax', 'LocationsController@destroyLocationAjax')->name('location.destroyLocationAjax');


Route::get('getStandortIdListAll', 'AdminController@getStandortIdListAll')->name('getStandortIdListAll');
Route::get('acAdminLocations', 'SearchController@acAdminLocations')->name('acAdminLocations');

Route::get('getLocationListeAsTable', 'LocationsController@getLocationListeAsTable')->name('getLocationListeAsTable');
Route::get('getLocationListeAsKachel', 'LocationsController@getLocationListeAsKachel')->name('getLocationListeAsKachel');
Route::get('exportLocationJSON', 'DataportController@exportLocationJSON')->name('exportLocationJSON');
Route::post('importLocationJSON', 'DataportController@importLocationJSON')->name('importLocationJSON');


/**
 *
 *
 *
 *   Adressen
 *
 *
 */
Route::post('createAddressType', 'AdminController@createAddressType')->name('createAddressType');
Route::post('getAddressTypeData', 'AdminController@getAddressTypeData')->name('getAddressTypeData');
Route::put('updateAddressType', 'AdminController@updateAddressType')->name('updateAddressType');
Route::delete('deleteTypeAdress', 'AdminController@deleteTypeAdress')->name('deleteTypeAdress');
Route::get('getUsedAdressesByAdressType', 'AdminController@getUsedAdressesByAdressType')->name('getUsedAdressesByAdressType');


/**
 *
 *
 *
 *   Vorgänge   -> anforderung_control_items
 *
 *
 */
Route::post('createAnforderung', 'AdminController@createAnforderung')->name('createAnforderung');
Route::post('addNewAnforderungControlItem', 'AdminController@addNewAnforderungControlItem')->name('addNewAnforderungControlItem');
Route::get('getAnforderungControlItemData', 'AdminController@getAnforderungControlItemData')->name('getAnforderungControlItemData');
Route::put('updateAnforderungControlItem', 'AdminController@updateAnforderungControlItem')->name('updateAnforderungControlItem');
Route::delete('deleteAnforderungControlItem', 'AdminController@deleteAnforderungControlItem')->name('deleteAnforderungControlItem');





/**
 *
 *
 *
 *   Benutzer Profil
 *
 *
 */
Route::put('updateUserTheme', 'AdminController@updateUserTheme')->name('updateUserTheme');




/**
 *
 *
 *
 *   Produkt Kategorien
 *
 *
 */

Route::put('updateProdKat', 'AdminController@updateProdKat')->name('updateProdKat');
Route::post('createProdKat', 'AdminController@createProdKat')->name('createProdKat');
Route::post('getProdKatData', 'AdminController@getProdKatData')->name('getProdKatData');
Route::delete('deleteProdKat', 'AdminController@deleteProdKat')->name('deleteProdKat');
Route::get('getUsedProderialsByProdKat', 'AdminController@getUsedProderialsByProdKat')->name('getUsedProderialsByProdKat');



/**
 *
 *
 *
 *   Anforderung Typ
 *
 *
 */

Route::post('addNewAnforderungType', 'AdminController@addNewAnforderungType')->name('addNewAnforderungType');
Route::get('getAnforderungTypData', 'AdminController@getAnforderungTypData')->name('getAnforderungTypData');
Route::put('updateAnforderungType', 'AdminController@updateAnforderungType')->name('updateAnforderungType');
Route::delete('deleteAnforderungType', 'AdminController@deleteAnforderungType')->name('deleteAnforderungType');


/**
 *
 *
 *
 *   Anforderungen
 *
 *
 */

Route::put('updateAnforderung', 'AdminController@updateAnforderung')->name('updateAnforderung');
Route::get('getAnforderungData', 'AdminController@getAnforderungData')->name('getAnforderungData');
Route::delete('deleteAnforderung', 'AdminController@deleteAnforderung')->name('deleteAnforderung');
Route::get('getUsedEquipmentByProdAnforderung', 'AdminController@getUsedEquipmentByProdAnforderung')->name('getUsedEquipmentByProdAnforderung');



/**
 *
 *
 *
 *   Verordnungen
 *
 *
 */

Route::post('createVerordnung', 'AdminController@createVerordnung')->name('createVerordnung');
Route::put('updateVerordnung', 'AdminController@updateVerordnung')->name('updateVerordnung');
Route::post('getVerordnungData', 'AdminController@getVerordnungData')->name('getVerordnungData');
Route::delete('deleteVerordnung', 'AdminController@deleteVerordnung')->name('deleteVerordnung');
Route::get('getAnforderungByVerordnungListe', 'AdminController@getAnforderungByVerordnungListe')->name('getAnforderungByVerordnungListe');
Route::get('getUsedEquipmentByProdVerordnung', 'AdminController@getUsedEquipmentByProdVerordnung')->name('getUsedEquipmentByProdVerordnung');
Route::get('getUsedAnforderungByVerordnung', 'AdminController@getUsedAnforderungByVerordnung')->name('getUsedAnforderungByVerordnung');



/**
 *
 *
 *
 *   Dokument Typen
 *
 *
 */

Route::post('createDokumentType', 'AdminController@createDokumentType')->name('createDokumentType');
Route::put('updateDokumentType', 'AdminController@updateDokumentType')->name('updateDokumentType');
Route::post('getDokumentTypeData', 'AdminController@getDokumentTypeData')->name('getDokumentTypeData');
Route::delete('deleteDokumentType', 'AdminController@deleteDokumentType')->name('deleteDokumentType');
Route::get('getUsedDokumentType', 'AdminController@getUsedDokumentType')->name('getUsedDokumentType');



Route::get('checkStandortValid', 'AdminController@checkStandortValid')->name('checkStandortValid');





Route::delete('deleteTypeLager', 'AdminController@deleteTypeLager')->name('deleteTypeLager');
Route::delete('deleteTypeEquip', 'AdminController@deleteTypeEquip')->name('deleteTypeEquip');



