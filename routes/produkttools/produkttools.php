<?php

Route::get('/downloadEquipmentDokuFile', 'EquipmentDocController@downloadEquipmentDokuFile')->name('downloadEquipmentDokuFile');
Route::get('/downloadProduktDokuFile', 'ProduktDocController@downloadProduktDokuFile')->name('downloadProduktDokuFile');
Route::get('getProduktListe', 'ProduktController@getProduktListe')->name('getProduktListe');
Route::get('importProdukt', 'ProduktController@importProdukt')->name('importProdukt');
Route::get('exportProdukt', 'ProduktController@exportProdukt')->name('exportProdukt');
Route::get('produkt.getProduktIdListAll', 'ProduktController@getProduktIdListAll')->name('produkt.getProduktIdListAll');

Route::get('/produkt/kategorie/{id}', 'ProduktController@getKategorieProducts')->name('getKategorieProducts');
Route::delete('deleteProduktKategorieParam', 'ProduktController@deleteProduktKategorieParam')->name('deleteProduktKategorieParam');
Route::get('getProduktKategorieParams', 'ProduktController@getProduktKategorieParams')->name('getProduktKategorieParams');
Route::post('addProduktKategorieParam', 'ProduktController@addProduktKategorieParam')->name('addProduktKategorieParam');
Route::post('produkt.ajaxstore', 'ProduktController@ajaxstore')->name('produkt.ajaxstore');

Route::get('getUsedProduktsByPK', 'ProduktController@getUsedProduktsByPK')->name('getUsedProduktsByPK');
Route::get('exportProduktToJson', 'DataportController@exportProduktToJson')->name('exportProduktToJson');

Route::get('produktsetuuids', '\App\Http\Services\Product\ProductService@setuuid')->name('products.setuuids');

Route::post('addProduktFirma', 'ProduktController@addProduktFirma')->name('addProduktFirma');
Route::delete('removeFirmaFromProdukt', 'ProduktController@removeFirmaFromProdukt')->name('removeFirmaFromProdukt');

Route::put('updateProduktKategorieParams', 'ProduktController@updateProduktKategorieParams')->name('updateProduktKategorieParams');
Route::post('addProderialKategorie', 'ProduktController@addProderialKategorie')->name('addProderialKategorie');

Route::post('addProduktParams', 'ProduktController@addProduktParams')->name('addProduktParams');
Route::put('updateProduktParams', 'ProduktController@updateProduktParams')->name('updateProduktParams');
Route::delete('deleteProduktParams', 'ProduktController@deleteProduktParams')->name('deleteProduktParams');
Route::get('getParamData', 'ProductParameterController@getParamData')->name('getParamData');
Route::get('getCategogryParam', 'ProductParameterController@getCategogryParam')->name('getCategogryParam');

Route::post('addAnforderung', 'ProduktController@addAnforderung')->name('addAnforderung');
Route::post('addProduktAnforderung', 'ProduktController@addProduktAnforderung')->name('addProduktAnforderung');
Route::put('updateProduktAnforderung', 'ProduktController@updateProduktAnforderung')->name('updateProduktAnforderung');
Route::delete('deleteProduktAnfordrung', 'ProduktController@deleteProduktAnfordrung')->name('deleteProduktAnfordrung');
