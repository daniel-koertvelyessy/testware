<?php


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
