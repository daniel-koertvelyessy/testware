<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portal-main');
});

Route::get('support', function () {
    return view('support');
});

Route::get('organisationMain', function () {
    return view('admin.organisation.index');
})->name('organisationMain');

Route::get('standorteMain', function () {
    return view('admin.standorte.index');
})->name('standorteMain');

Route::get('produktMain', function () {
    return view('admin.produkt.main');
})->name('produktMain');

Route::get('getKategorieProducts', function () {
    return view('admin.produkt.kategorie.index');
})->name('getKategorieProducts');

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
    'firma' => 'FirmaController',
    'adresse' => 'AdresseController',
    'testware' => 'TestwareController',
    'equipment' => 'EquipmentController',
    'control' => 'ControlController',
    'user' => 'UserController',
    'stellplatz' => 'StellplatzController',

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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth/register', 'HomeController@index')->name('auth.register');




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


