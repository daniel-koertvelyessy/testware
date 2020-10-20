<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('portal-main');
});

Route::get('support', function () {
    return view('support');
});


Route::get('docs', function () {
    return view('docs.index');
});

Route::get('user.resetPassword','UserController@resetPassword')->name('user.resetPassword');



Route::resources([
    'location' => 'LocationsController',
    'building' => 'BuildingsController',
    'room'=> 'RoomController',
    'profile' => 'ProfileController',
    'produkt' => 'ProduktController',
    'produktDoku' => 'ProduktDocController',
    'equipDoku' => 'EquipmentDocController',
    'firma' => 'FirmaController',
    'adresse' => 'AdresseController',
    'testware' => 'TestwareController',
    'equipment' => 'EquipmentController',
    'control' => 'ControlController',
    'user' => 'UserController',
    'stellplatz' => 'StellplatzController',
    'anforderung' => 'AnforderungsController',
    'verordnung' => 'VerordnungController',
    'anforderungcontrolitem' => 'AnforderungControlItemController',

]);

/**
 * Verwaltung/Admin routes laden
 */
require base_path().'/routes/admintools/admintools.php';

/**
 *  Produkt routes laden
 */
require base_path().'/routes/produkttools/produkttools.php';



Route::get('getFirmenAjaxListe','FirmaController@getFirmenAjaxListe')->name('getFirmenAjaxListe');
Route::get('getFirmenDaten','FirmaController@getFirmenDaten')->name('getFirmenDaten');

Route::get('getAddressenAjaxListe','AdresseController@getAddressenAjaxListe')->name('getAddressenAjaxListe');
Route::get('getAddressDaten','AdresseController@getAddressDaten')->name('getAddressDaten');




/*

PDF GENERATORS

*/
Route::get('pdf.standortListe', 'PdfGenerator@standortListe')->name('pdf.standortListe');

Route::get('/makePDF/{view}/{title}', function ($view, $title) {
    return App\Http\Controllers\PdfGenerator::makePDF($view, $title);
})->name('makePDF');

Route::get('makePDFEquipmentLabel/{equipment}', function ($equipment) {
    return App\Http\Controllers\PdfGenerator::makePDFEquipmentLabel($equipment);
})->name('makePDFEquipmentLabel');

Route::get('makePDFEquipmentDataSheet/{equipment}', function ($equipment) {
    return App\Http\Controllers\PdfGenerator::makePDFEquipmentDataSheet($equipment);
})->name('makePDFEquipmentDataSheet');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth/register', 'HomeController@index')->name('auth.register');

Route::get('organisationMain', function () {
    return view('admin.organisation.index');
})->name('organisationMain')->middleware('auth');

Route::get('standorteMain', function () {
    return view('admin.standorte.index');
})->name('standorteMain')->middleware('auth');

Route::get('produktMain', function () {
    return view('admin.produkt.main');
})->name('produktMain')->middleware('auth');

Route::get('equipMain', function () {
    return view('testware.equipment.main');
})->name('equipMain')->middleware('auth');

Route::get('equipMaker', function () {
    return view('testware.equipment.maker');
})->name('equipMaker')->middleware('auth');

Route::get('verordnung.main', function () {
    return view('admin.verordnung.main');
})->name('verordnung.main')->middleware('auth');

Route::get('getKategorieProducts', function () {
    return view('admin.produkt.kategorie.index');
})->name('getKategorieProducts')->middleware('auth');

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


