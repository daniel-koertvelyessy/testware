<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('portal-main');
})->name('portal-main');

Route::get('support', function () {
    return view('support');
})->name('support');

Route::get('app', function () {
    return view('testware.app.index');
})->name('app');

Route::get('edata/{ident}', function ($ident, Request $request) {
    $str = str_split($ident, strlen(env('APP_HSKEY')));
    if ($str[0] === env('APP_HSKEY')) {
        $e = explode(env('APP_HSKEY'), $ident);
        $uid = $e[1];

        $equipment = \App\EquipmentUid::where('equipment_uid', $uid)->first();
        if ($equipment) {
            $edata = \App\Equipment::findOrFail($equipment->equipment_id);
            return view('testware.app.equipmentdata', ['edata' => $edata, 'ident' => $ident]);
        } else {
            $request->session()->flash('status', 'Das Gerät konnte nicht gefunden werden!');
            return redirect()->route('app');
        }
    } else {
        $request->session()->flash('status', 'Das Gerät konnte nicht gefunden werden!');
        return redirect()->route('app');
    }
})->name('edata');

Route::get('edmg/{ident}', function ($ident, Request $request) {
    $str = str_split($ident, strlen(env('APP_HSKEY')));

    if ($str[0] === env('APP_HSKEY')) {
        $e = explode(env('APP_HSKEY'), $ident);
        $uid = $e[1];
        $equipment = \App\EquipmentUid::where('equipment_uid', $uid)->first();


        if ($equipment) {
            $edata = \App\Equipment::findOrFail($equipment->equipment_id);
//            dd($edata);
            return view('testware.app.reportdamage', ['edata' => $edata, 'ident' => $ident]);
        } else {
            $request->session()->flash('status', 'Das Gerät konnte nicht gefunden werden!');
            return redirect()->route('app');
        }
    } else {
        $request->session()->flash('status', 'Das Gerät konnte nicht gefunden werden!');
        return redirect()->route('app');
    }
})->name('edmg');


Route::get('docs', function () {
    return view('docs.index');
});

Route::get('user.resetPassword', 'UserController@resetPassword')->name('user.resetPassword');
Route::post('equipmentevent.restore', 'EquipmentEventController@restore')->name('equipmentevent.restore');
Route::delete('equipmentevent.close', 'EquipmentEventController@close')->name('equipmentevent.close');

Route::middleware('throttle:5|60,1')->group(function () {
    Route::post('app.store', 'AppController@store')->name('app.store');
});
Route::put('equipmentevent.accept', 'EquipmentEventController@accept')->name('equipmentevent.accept');


Route::resources([
    'location'               => 'LocationsController',
    'building'               => 'BuildingsController',
    'room'                   => 'RoomController',
    'profile'                => 'ProfileController',
    'produkt'                => 'ProduktController',
    'produktDoku'            => 'ProduktDocController',
    'equipDoku'              => 'EquipmentDocController',
    'firma'                  => 'FirmaController',
    'adresse'                => 'AdresseController',
    'testware'               => 'TestwareController',
    'equipment'              => 'EquipmentController',
    'controlevent'           => 'ControlEventController',
    'user'                   => 'UserController',
    'stellplatz'             => 'StellplatzController',
    'anforderung'            => 'AnforderungsController',
    'verordnung'             => 'VerordnungController',
    'anforderungcontrolitem' => 'AnforderungControlItemController',
    'equipmentevent'         => 'EquipmentEventController',
    'equipmenteventitem'     => 'EquipmentEventItemController',
    'EquipmentInstruction'     => 'EquipmentInstructionController',
    'EquipmentQualifiedUser'     => 'EquipmentQualifiedUserController',

]);

/**
 * Verwaltung/Admin routes laden
 */
require base_path() . '/routes/admintools/admintools.php';

/**
 *  Produkt routes laden
 */
require base_path() . '/routes/produkttools/produkttools.php';

Route::post('user.setMsgRead', 'UserController@setMsgRead')->name('user.setMsgRead');
Route::delete('user.deleteMsg', 'UserController@deleteMsg')->name('user.deleteMsg');

Route::get('getFirmenAjaxListe', 'FirmaController@getFirmenAjaxListe')->name('getFirmenAjaxListe');
Route::get('getFirmenDaten', 'FirmaController@getFirmenDaten')->name('getFirmenDaten');

Route::get('getAddressenAjaxListe', 'AdresseController@getAddressenAjaxListe')->name('getAddressenAjaxListe');
Route::get('getAddressDaten', 'AdresseController@getAddressDaten')->name('getAddressDaten');
Route::get('getControlEventDataSheet', 'ControlEventController@getControlEventDataSheet')->name('getControlEventDataSheet');

Route::get('getEquipmentAjaxListe', 'EquipmentController@getEquipmentAjaxListe')->name('getEquipmentAjaxListe');

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

Route::get('makePDFEquipmentControlReport/{controlEvent}', function ($controlEvent) {
    return App\Http\Controllers\PdfGenerator::makePDFEquipmentControlReport(

        App\ControlEvent::find($controlEvent)
    );
})->name('makePDFEquipmentControlReport');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth/register', 'HomeController@index')->name('auth.register');

Route::get('organisationMain', function () {
    return view('admin.organisation.index', [
        'firmas'   => App\Firma::take(5)->latest()->get(),
        'adresses' => App\Adresse::take(5)->latest()->get(),
        'profiles' => App\Profile::take(5)->latest()->get(),
    ]);
})->name('organisationMain')->middleware('auth');

Route::get('standorteMain', function () {
    return view('admin.standorte.index', [
        'locations' => App\Location::take(5)->latest()->get(),
        'buildings' => App\Building::take(5)->latest()->get(),
        'rooms'     => App\Room::take(5)->latest()->get(),
    ]);
})->name('standorteMain')->middleware('auth');

Route::get('produktMain', function () {
    return view('admin.produkt.main');
})->name('produktMain')->middleware('auth');

Route::get('equipMain', function () {
    $equipmentList = \App\Equipment::paginate(10);
    return view('testware.equipment.main', ['equipmentList' => $equipmentList]);
})->name('equipMain')->middleware('auth');

Route::get('equipment.maker', function () {
    $produktList = \App\Produkt::paginate(10);
    return view('testware.equipment.maker', ['produktList' => $produktList]);
})->name('equipment.maker')->middleware('auth');

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


