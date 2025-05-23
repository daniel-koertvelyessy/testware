<?php

/**
 *   Admin Tool Routes
 *     Räume 29
 *     Gebäude 57
 */
Route::get('registerphone', function () {
    return view('/');
});
Route::get('organisation', function () {
    return view('admin.organisation.index');
});

// Route::get('sync_storages', 'AdminController@sycStorages')->name('storages.sync');
// Route::post('sync_storage', 'AdminController@sycStorage')->name('storage.sync');

Route::get('admin', 'AdminController@index')->name('admin.index');
// Route::get('admin/user', 'AdminController@indexUser')->name('user.index');
// Route::get('admin/user/ldap', 'UserController@ldap')->name('user.ldap');
Route::put('userupdatedata', 'UserController@updatedata')->name('user.updatedata');
Route::get('user/restore/{user}', 'UserController@restore')->name('user.restore');
Route::get('checkUserEmailAddressExists', 'UserController@checkUserEmailAddressExists')->name('checkUserEmailAddressExists');
Route::get('checkUserUserNameExists', 'UserController@checkUserUserNameExists')->name('checkUserUserNameExists');
Route::get('admin/reports', 'AdminController@indexReports');
Route::get('admin/reports/template', 'AdminController@indexReportsTemplate')->name('report.tempate');
Route::get('admin/systems', 'AdminController@systems')->name('systems');
Route::get('storageDataPort', 'AdminController@storageDataPort')->name('storageDataPort');
Route::get('getLocationTree', 'LocationsController@getLocationTree')->name('getLocationTree');
Route::get('location.remove/{location}', 'LocationsController@remove')->name('location.remove');
//    Route::get('registerphone', 'AdminController@systems')->name('registerphone');

/**
 *   Stellplätze
 */
Route::put('updateStellPlatzType', 'AdminController@updateStellPlatzType')->name('updateStellPlatzType');
Route::post('createStellPlatzType', 'AdminController@createStellPlatzType')->name('createStellPlatzType');
Route::post('getStellPlatzTypeData', 'AdminController@getStellPlatzTypeData')->name('getStellPlatzTypeData');
Route::delete('deleteStellPlatzType', 'AdminController@deleteStellPlatzType')->name('deleteStellPlatzType');
Route::get('getUsedObjByStellPlatzType', 'AdminController@getUsedObjByStellPlatzType')->name('getUsedObjByStellPlatzType');
Route::get('getUsedStellplatzByType', 'AdminController@getUsedStellplatzByType')->name('getUsedStellplatzByType');
Route::get('getStellplatzTypeList', 'AdminController@getStellplatzTypeList')->name('getStellplatzTypeList');
Route::get('getStellplatzData', 'StellplatzController@getStellplatzData')->name('getStellplatzData');
Route::get('getStellplatzList', 'StellplatzController@getStellplatzList')->name('getStellplatzList');
Route::get('getObjectsInCompartment', 'StellplatzController@getObjectsInCompartment')->name('getObjectsInCompartment');
Route::get('checkDuplicateStoragePlaceLabel', 'StellplatzController@checkDuplicateLabel')->name('checkDuplicateStoragePlaceLabel');

Route::post('stellplatz.modal', 'StellplatzController@modal')->name('stellplatz.modal');
Route::delete('destroyStellplatzAjax', 'StellplatzController@destroyStellplatzAjax')->name('destroyStellplatzAjax');

Route::post('copyStellplatz', 'StellplatzController@copyStellplatz')->name('copyStellplatz');
Route::get('exportStellplatzJSON', 'DataportController@exportStellplatzJSON')->name('exportStellplatzJSON');
Route::post('importStellplatzJSON', 'DataportController@importStellplatzJSON')->name('importStellplatzJSON');
Route::get('exportjson.compartments', 'ExportController@compartmentsToJson')->name('exportjson.compartments');

/**
 *   Räume
 */
Route::delete('room.destroyRoomAjax', 'RoomController@destroyRoomAjax')->name('room.destroyRoomAjax');
Route::put('updateRoomType', 'AdminController@updateRoomType')->name('updateRoomType');
Route::post('createRoomType', 'AdminController@createRoomType')->name('createRoomType');
Route::post('getRoomTypeData', 'AdminController@getRoomTypeData')->name('getRoomTypeData');
Route::delete('deleteRoomType', 'AdminController@deleteRoomType')->name('deleteRoomType');
Route::get('getUsedRoomsByRoomType', 'AdminController@getUsedRoomsByRoomType')->name('getUsedRoomsByRoomType');
Route::post('copyRoom', 'RoomController@copyRoom')->name('copyRoom');
Route::get('getRoomListeAsKachel', 'RoomController@getRoomListeAsKachel')->name('getRoomListeAsKachel');
Route::get('getRoomListeAsTable', 'RoomController@getRoomListeAsTable')->name('getRoomListeAsTable');
Route::get('getRoomTypeList', 'RoomController@getRoomTypeList')->name('getRoomTypeList');
Route::get('getRoomData', 'RoomController@getRoomData')->name('getRoomData');
Route::get('getRoomList', 'RoomController@getRoomList')->name('getRoomList');
Route::get('getObjectsInRoom', 'RoomController@getObjectsInRoom')->name('getObjectsInRoom');
Route::get('getStellplatzListInRoom', 'RoomController@getStellplatzListInRoom')->name('getStellplatzListInRoom');
Route::get('checkDuplicateRoomLabel', 'RoomController@checkDuplicateLabel')->name('checkDuplicateRoomLabel');

Route::post('room.modal', 'RoomController@modal')->name('room.modal');

Route::get('exportRoomJSON', 'DataportController@exportRoomJSON')->name('exportRoomJSON');
Route::post('importRoomJSON', 'DataportController@importRoomJSON')->name('importRoomJSON');
Route::get('exportjson.rooms', 'ExportController@roomsToJson')->name('exportjson.rooms');

/**
 *   Gebäude
 */
Route::delete('destroyBuildingAjax', 'BuildingsController@destroyBuildingAjax')->name('destroyBuildingAjax');
Route::post('createAjaxBuildingType', 'AdminController@createAjaxBuildingType')->name('createAjaxBuildingType');
Route::get('getObjectsInBuilding', 'BuildingsController@getObjectsInBuilding')->name('getObjectsInBuilding');
Route::post('createBuildingType', 'AdminController@createBuildingType')->name('createBuildingType');
Route::post('getBuildingTypeData', 'AdminController@getBuildingTypeData')->name('getBuildingTypeData');
Route::put('updateBuildingType', 'AdminController@updateBuildingType')->name('updateBuildingType');
Route::get('getUsedBuildingsByBuildingType', 'AdminController@getUsedBuildingsByBuildingType')->name('getUsedBuildingsByBuildingType');
Route::delete('deleteBuildingType', 'AdminController@deleteBuildingType')->name('deleteBuildingType');
Route::get('getBuildingList/{locid}', 'BuildingsController@getBuildingList')->name('room.getBuildingList');
Route::post('copyBuilding', 'BuildingsController@copyBuilding')->name('copyBuilding');
Route::get('getBuildingListeAsTable', 'BuildingsController@getBuildingListeAsTable')->name('getBuildingListeAsTable');
Route::get('getBuildingListeAsKachel', 'BuildingsController@getBuildingListeAsKachel')->name('getBuildingListeAsKachel');
Route::get('getRoomListInBuilding', 'BuildingsController@getRoomListInBuilding')->name('getRoomListInBuilding');
Route::get('checkDuplicateBuildingLabel', 'BuildingsController@checkDuplicateLabel')->name('checkDuplicateBuildingLabel');

Route::get('getBuildingTypeList', 'AdminController@getBuildingTypeList')->name('getBuildingTypeList');
Route::get('getBuildingData', 'BuildingsController@getBuildingData')->name('getBuildingData');

Route::post('building.modal', 'BuildingsController@modal')->name('building.modal');
Route::get('fetchUid', 'AdminController@fetchUid')->name('fetchUid');

Route::get('exportBuildingJSON', 'DataportController@exportBuildingJSON')->name('exportBuildingJSON');
Route::post('importBuildingJSON', 'DataportController@importBuildingJSON')->name('importBuildingJSON');
Route::get('exportjson.buildings', 'ExportController@buildingsToJson')->name('exportjson.buildings');

/**
 *   Standorte
 */
Route::post('addLocationAnforderung', 'LocationsController@addLocationAnforderung')->name('addLocationAnforderung');
Route::delete('deleteLocationAnforderung', 'LocationsController@deleteLocationAnforderung')->name('deleteLocationAnforderung');
Route::delete('location.destroyLocationAjax', 'LocationsController@destroyLocationAjax')->name('location.destroyLocationAjax');

Route::get('getStorageIdListAll', 'AdminController@getStorageIdListAll')->name('getStorageIdListAll');
Route::get('acAdminLocations', 'SearchController@acAdminLocations')->name('acAdminLocations');

Route::get('lexplorer', 'LocationsController@explorer')->name('lexplorer');
Route::get('exportjson.locations', 'ExportController@locationsToJson')->name('exportjson.locations');
Route::get('getBuildingListInLocation', 'LocationsController@getBuildingListInLocation')->name('getBuildingListInLocation');
Route::get('getLocationData', 'LocationsController@getLocationData')->name('getLocationData');
Route::get('getLocationListeAsTable', 'LocationsController@getLocationListeAsTable')->name('getLocationListeAsTable');
Route::get('getLocationListeAsKachel', 'LocationsController@getLocationListeAsKachel')->name('getLocationListeAsKachel');
Route::get('exportLocationJSON', 'DataportController@exportLocationJSON')->name('exportLocationJSON');
Route::post('importLocationJSON', 'DataportController@importLocationJSON')->name('importLocationJSON');

/**
 *   Adressen
 */
Route::post('createAddressType', 'AdminController@createAddressType')->name('createAddressType');
Route::post('getAddressTypeData', 'AdminController@getAddressTypeData')->name('getAddressTypeData');
Route::put('updateAddressType', 'AdminController@updateAddressType')->name('updateAddressType');
Route::delete('deleteTypeAdress', 'AdminController@deleteTypeAdress')->name('deleteTypeAdress');
Route::get('getUsedAdressesByAdressType', 'AdminController@getUsedAdressesByAdressType')->name('getUsedAdressesByAdressType');

/**
 *   Vorgänge   -> anforderung_control_items
 */
// Route::post('createAnforderung', 'AdminController@createAnforderung')->name('createAnforderung');
// Route::post('addNewAnforderungControlItem', 'AdminController@addNewAnforderungControlItem')->name('addNewAnforderungControlItem');
Route::get('getAnforderungControlItemData', 'AnforderungControlItemController@getAnforderungControlItemData')->name('getAnforderungControlItemData');
Route::get('anforderungcontrolitem/{anforderungcontrolitem}/copy', 'AnforderungControlItemController@copy')->name('anforderungcontrolitem.copy');
Route::post('anforderungcontrolitem/{anforderung}/applySort', 'AnforderungControlItemController@applySort')->name('anforderungcontrolitem.applySort');
Route::get('anforderungcontrolitemlistitems', 'AnforderungControlItemController@getAciList')->name('anforderungcontrolitemlistitems');
Route::put('anforderungcontrolitem/{aci}/fix', 'AnforderungControlItemController@fixbroken')->name('anforderungcontrolitem.fixbroken');
Route::post('anforderung/restore', 'AnforderungsController@restore')->name('anforderung.restore');

// Route::put('updateAnforderungControlItem', 'AdminController@updateAnforderungControlItem')->name('updateAnforderungControlItem');
// Route::delete('deleteAnforderungControlItem', 'AdminController@deleteAnforderungControlItem')->name('deleteAnforderungControlItem');
Route::post('control/fix', 'ControlEquipmentController@fixbroken')->name('control.fixbroken');

/**
 *   INSTALLER
 */
Route::get('/installer', 'InstallerController@index')->name('installer.start');
Route::get('/installer/user', 'InstallerController@create')->name('installer.user');
// Route::get('/installer/clear_config', 'InstallerController@clearConfig')->name('installer.clear_config');
// Route::get('/installer/clear_cache', 'InstallerController@clearCache')->name('installer.clear_cache');
Route::get('/installer/company', 'InstallerController@company')->name('installer.company');
Route::get('/installer/system', 'InstallerController@system')->name('installer.system');
Route::get('/installer/server', 'InstallerController@index')->name('installer.server');
Route::post('/installer/set_app_url', 'InstallerController@setAppUrl')->name('installer.setAppUrl');
Route::get('/installer/location', 'InstallerController@location')->name('installer.location');
Route::post('/installer/setCompany', 'InstallerController@setCompany')->name('installer.setCompany');
Route::post('/installer/setAddress', 'InstallerController@setAddress')->name('installer.setAddress');
Route::get('/installer/seed', 'InstallerController@seed')->name('installer.getseed');
Route::put('/installer/seed', 'InstallerController@setseed')->name('installer.putseed');
Route::get('/installer/checkemail', 'InstallerController@checkEmail')->name('installer.checkemail');
Route::get('/installer/checkname', 'InstallerController@checkName')->name('installer.checkname');
Route::get('/installer/checkusername', 'InstallerController@checkUserName')->name('installer.checkusername');
Route::get('installer/getUserData', 'InstallerController@getUserData')->name('installer.getUserData');
Route::post('installer/storeUserData', 'InstallerController@addUserData')->name('installer.storeuserData');
Route::post('installer/deleteUserData', 'InstallerController@deleteUserData')->name('installer.deleteUserData');

Route::get('email/test', 'EmailController@testMailServer')->name('email.test');
Route::post('email/setserver', 'EmailController@store')->name('email.setserver');
Route::get('email/server', 'EmailController@show')->name('email.getserver');

/**
 *   Benutzer Profil
 */
Route::put('updateUserTheme', 'AdminController@updateUserTheme')->name('updateUserTheme');

/**
 *   Geräte
 */
Route::post('controlsync', 'ControlEquipmentController@sync')->name('control.sync');

/**
 *   Produkt Kategorien
 */
Route::put('updateProdKat', 'AdminController@updateProdKat')->name('updateProdKat');
Route::put('updateProdKat', 'AdminController@updateProdKat')->name('updateProdKat');
Route::post('createProdKat', 'AdminController@createProdKat')->name('createProdKat');
Route::post('getProdKatData', 'AdminController@getProdKatData')->name('getProdKatData');
Route::delete('deleteProdKat', 'AdminController@deleteProdKat')->name('deleteProdKat');
Route::get('getUsedProderialsByProdKat', 'AdminController@getUsedProderialsByProdKat')->name('getUsedProderialsByProdKat');

/**
 *   Anforderung Typ
 */
Route::post('addNewAnforderungType', 'AdminController@addNewAnforderungType')->name('addNewAnforderungType');
Route::get('getAnforderungTypData', 'AdminController@getAnforderungTypData')->name('getAnforderungTypData');
Route::put('updateAnforderungType', 'AdminController@updateAnforderungType')->name('updateAnforderungType');
Route::delete('deleteAnforderungType', 'AdminController@deleteAnforderungType')->name('deleteAnforderungType');

/**
 *   Anforderungen
 */
Route::put('updateAnforderung', 'AdminController@updateAnforderung')->name('updateAnforderung');
Route::get('getAnforderungData', 'AdminController@getAnforderungData')->name('getAnforderungData');
Route::delete('deleteAnforderung', 'AdminController@deleteAnforderung')->name('deleteAnforderung');
Route::get('getUsedEquipmentByProdAnforderung', 'AdminController@getUsedEquipmentByProdAnforderung')->name('getUsedEquipmentByProdAnforderung');

/**
 *   Verordnungen
 */
Route::post('createVerordnung', 'AdminController@createVerordnung')->name('createVerordnung');
Route::put('updateVerordnung', 'AdminController@updateVerordnung')->name('updateVerordnung');
Route::post('getVerordnungData', 'AdminController@getVerordnungData')->name('getVerordnungData');
Route::delete('deleteVerordnung', 'AdminController@deleteVerordnung')->name('deleteVerordnung');
Route::get('getAnforderungByVerordnungListe', 'AdminController@getAnforderungByVerordnungListe')->name('getAnforderungByVerordnungListe');
Route::get('getUsedEquipmentByProdVerordnung', 'AdminController@getUsedEquipmentByProdVerordnung')->name('getUsedEquipmentByProdVerordnung');
Route::get('getUsedAnforderungByVerordnung', 'AdminController@getUsedAnforderungByVerordnung')->name('getUsedAnforderungByVerordnung');

/**
 *   Dokument Typen
 */
Route::post('createDokumentType', 'AdminController@createDokumentType')->name('createDokumentType');
Route::put('updateDokumentType', 'AdminController@updateDokumentType')->name('updateDokumentType');
Route::post('getDokumentTypeData', 'AdminController@getDokumentTypeData')->name('getDokumentTypeData');
Route::delete('deleteDokumentType', 'AdminController@deleteDokumentType')->name('deleteDokumentType');
Route::get('getUsedDokumentType', 'AdminController@getUsedDokumentType')->name('getUsedDokumentType');

Route::get('checkStorageValid', 'AdminController@checkStorageValid')->name('checkStorageValid');

Route::delete('deleteTypeLager', 'AdminController@deleteTypeLager')->name('deleteTypeLager');
Route::delete('deleteTypeEquip', 'AdminController@deleteTypeEquip')->name('deleteTypeEquip');

/**
 *      Tests
 */
// Route::get('', 'AdminController@checkStorageValid')->name('checkStorageValid');
