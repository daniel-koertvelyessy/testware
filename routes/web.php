<?php

use App\EquipmentDoc;
use App\EquipmentFuntionControl;
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
            return view('testware.app.equipmentdata', [
                'edata' => $edata,
                'ident' => $ident
            ]);
        } else {
            $request->session()->flash('status', __('Das Gerät konnte nicht gefunden werden!'));
            return redirect()->route('app');
        }
    } else {
        $request->session()->flash('status', __('Das Gerät konnte nicht gefunden werden!'));
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
            return view('testware.app.reportdamage', [
                'edata' => $edata,
                'ident' => $ident
            ]);
        } else {
            $request->session()->flash('status', __('Das Gerät konnte nicht gefunden werden!'));
            return redirect()->route('app');
        }
    } else {
        $request->session()->flash('status', __('Das Gerät konnte nicht gefunden werden!'));
        return redirect()->route('app');
    }
})->name('edmg');

/**
 * Documentation-Routes
 */
Route::get('docs', function () {
    return view('docs.index');
})->name('docs.start');
Route::get('docs/modules', function () {
    return view('docs.modules');
})->name('docs.modules');
Route::get('docs/testware', function () {
    return view('docs.testware.index');
})->name('docs.testware.index');
Route::get('docs/backend', function () {
    return view('docs.backend.index');
})->name('docs.backend.index');
Route::get('docs/backend/locations', function () {
    return view('docs.backend.locations');
})->name('docs.backend.locations');
Route::get('docs/api', function () {
    return view('docs.api.index');
})->name('docs.api.index');
Route::get('docs/api/endpoints', function () {
    return view('docs.api.endpoints.index');
})->name('docs.api.endpoints');
Route::get('docs/api/endpoints/backend', function () {
    return view('docs.api.endpoints.backend');
})->name('docs.api.backend');
Route::get('docs/api/endpoints/products', function () {
    return view('docs.api.endpoints.products');
})->name('docs.api.products');
Route::get('docs/api/endpoints/equipment', function () {
    return view('docs.api.endpoints.equipment');
})->name('docs.api.equipment');
Route::get('docs/api/endpoints/control', function () {
    return view('docs.api.endpoints.control');
})->name('docs.api.control');
Route::get('docs/api/endpoints/requirements', function () {
    return view('docs.api.endpoints.requirements');
})->name('docs.api.requirements');
Route::get('docs/api/endpoints/events', function () {
    return view('docs.api.endpoints.events');
})->name('docs.api.events');


Route::put('user.resetPassword', 'UserController@resetPassword')->name('user.resetPassword');
Route::post('event.restore', 'EquipmentEventController@restore')->name('event.restore');
Route::delete('event.close', 'EquipmentEventController@close')->name('event.close');

Route::middleware('throttle:5|60,1')->group(function () {
    Route::post('app.store', 'AppController@store')->name('app.store');
});
Route::put('event.accept', 'EquipmentEventController@accept')->name('event.accept');

Route::resources([
    'location'               => 'LocationsController',
    'building'               => 'BuildingsController',
    'room'                   => 'RoomController',
    'contact'                => 'ContactController',
    'profile'                => 'ProfileController',
    'produkt'                => 'ProduktController',
    'produktDoku'            => 'ProduktDocController',
    'equipDoku'              => 'EquipmentDocController',
    'firma'                  => 'FirmaController',
    'adresse'                => 'AdresseController',
    'testware'               => 'TestwareController',
    'equipment'              => 'EquipmentController',
    'control'                => 'ControlEquipmentController',
    'user'                   => 'UserController',
    'role'                   => 'RoleController',
    'stellplatz'             => 'StellplatzController',
    'anforderung'            => 'AnforderungsController',
    'verordnung'             => 'VerordnungController',
    'anforderungcontrolitem' => 'AnforderungControlItemController',
    'event'                  => 'EquipmentEventController',
    'eventitem'              => 'EquipmentEventItemController',
    'EquipmentInstruction'   => 'EquipmentInstructionController',
    'EquipmentQualifiedUser' => 'EquipmentQualifiedUserController',
    'ProductInstruction'     => 'ProductInstructedUserController',
    'ProductQualifiedUser'   => 'ProductQualifiedUserController',
    'lizenz'                 => 'LizenzController',
    'report'                 => 'ReportController',
    'search'                 => 'SearchController',
    'tag'                    => 'TagController',
    'note'                   => 'NoteController',
    'note-type'              => 'NoteTypeController',
]);

/**
 * Verwaltung/Admin routes laden
 */
require __DIR__ . '/admintools/admintools.php';
/**
 *  Produkt routes laden
 */
require __DIR__ . '/produkttools/produkttools.php';

Route::post('user.setMsgRead', 'UserController@setMsgRead')->name('user.setMsgRead');
Route::delete('user.deleteMsg', 'UserController@deleteMsg')->name('user.deleteMsg');
Route::delete('user.revokerole', 'UserController@revokerole')->name('user.revokerole');
Route::post('user.grantrole', 'UserController@grantrole')->name('user.grantrole');
Route::delete('user.revokeSysAdmin/{user}', 'UserController@revokeSysAdmin')->name('user.revokeSysAdmin');
Route::post('user.grantSysAdmin/{user}', 'UserController@grantSysAdmin')->name('user.grantSysAdmin');

Route::get('getFirmenAjaxListe', 'FirmaController@getFirmenAjaxListe')->name('getFirmenAjaxListe');
Route::get('getFirmenDaten', 'FirmaController@getFirmenDaten')->name('getFirmenDaten');

Route::get('getAddressenAjaxListe', 'AdresseController@getAddressenAjaxListe')->name('getAddressenAjaxListe');
Route::get('getAddressDaten', 'AdresseController@getAddressDaten')->name('getAddressDaten');
Route::get('getControlEventDataSheet', 'ControlEquipmentController@getControlEventDataSheet')->name('getControlEventDataSheet');

Route::get('getEquipmentAjaxListe', 'EquipmentController@getEquipmentAjaxListe')->name('getEquipmentAjaxListe');
Route::get('searchInModules', 'SearchController@searchInModules')->name('searchInModules');
Route::get('searchInDocumentation', 'SearchController@searchInDocumentation')->name('searchInDocumentation');

/*

PDF GENERATORS

*/
Route::get('pdf.storageListe', 'PdfGenerator@storageListe')->name('pdf.storageListe');

Route::get('/makePDF/{view}/{title}', function ($view, $title) {
    App\Http\Controllers\PdfGenerator::makePDF($view, $title);
})->name('makePDF');

Route::get('/report.print/{id}', function ($id) {
    App\Http\Controllers\PdfGenerator::printReport($id);
})->name('printReport');

Route::get('makePDFEquipmentLabel/{equipment}', function ($equipment) {
    App\Http\Controllers\PdfGenerator::makePDFEquipmentLabel($equipment);
})->name('makePDFEquipmentLabel');

Route::get('makePDFEquipmentDataSheet/{equipment}', function ($equipment) {
    App\Http\Controllers\PdfGenerator::makePDFEquipmentDataSheet($equipment);
})->name('makePDFEquipmentDataSheet');

Route::get('makePDFEquipmentControlReport/{controlEvent}', function ($controlEvent) {
    App\Http\Controllers\PdfGenerator::makePDFEquipmentControlReport(App\ControlEvent::find($controlEvent));
})->name('makePDFEquipmentControlReport');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth/register', 'HomeController@index')->name('auth.register');

Route::get('organisationMain', function () {
    return view('admin.organisation.index', [
        'firmas'   => App\Firma::take(5)->latest()->get(),
        'adresses' => App\Adresse::take(5)->latest()->get(),
        'profiles' => App\Profile::take(5)->latest()->get(),
        'contacts' => App\Contact::take(5)->latest()->get(),
    ]);
})->name('organisationMain')->middleware('auth');

Route::get('storageMain', function () {
    return view('admin.standorte.index', [
        'locations'    => App\Location::take(5)->latest()->get(),
        'buildings'    => App\Building::take(5)->latest()->get(),
        'rooms'        => App\Room::take(5)->latest()->get(),
        'compartments' => App\Stellplatz::take(5)->latest()->get(),
    ]);
})->name('storageMain')->middleware('auth');

Route::post('addEquipmentFunctionControl', function (Request $request) {

    $equipment_id = $request->equipment_id;
    $equipment = \App\Equipment::find($equipment_id);

    (new EquipmentFuntionControl())->addControlEvent($request, $equipment_id);

    if ($request->hasFile('equipDokumentFile')) {
        $proDocFile = new EquipmentDoc();
        $file = $request->file('equipDokumentFile');
        $validation = $request->validate([
            'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:10240',
            // size:2048 => 2048kB
            'eqdoc_label'       => 'required|max:150'
        ]);

        $proDocFile->eqdoc_name = $file->getClientOriginalName();
        $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/' . $equipment_id);
        $proDocFile->document_type_id = request('document_type_id');
        $proDocFile->equipment_id = $equipment_id;
        $proDocFile->eqdoc_description = request('eqdoc_description');
        $proDocFile->eqdoc_label = request('eqdoc_label');

        $proDocFile->save();
        $msg = __(' ohne Fehler ');
        $equipment->equipment_state_id = 1;
        $equipment->save();
    } else {
        $equipment->equipment_state_id = 4;
        $equipment->save();
        $msg = __(' ohne Dokumentation ');
    }

    $request->session()->flash('status', __('Die Funktionsprüfung wurde :msg angelegt!', ['msg' => $msg]));

    return back();
})->name('addEquipmentFunctionControl')->middleware('auth');

Route::get('produktMain', function () {
    return view('admin.produkt.main', ['produkts' => App\Produkt::all()->sortDesc()->take(10)]);
})->name('produktMain')->middleware('auth');

Route::get('equipMain', function () {
    $equipmentList = \App\Equipment::with('produkt', 'storage', 'EquipmentState', 'ControlEquipment')->sortable()->paginate(10);
    return view('testware.equipment.main', ['equipmentList' => $equipmentList]);
})->name('equipMain')->middleware('auth');

Route::get('equipment.maker', function () {
    $produktList = \App\Produkt::sortable()->paginate(10);
    return view('testware.equipment.maker', ['produktList' => $produktList]);
})->name('equipment.maker')->middleware('auth');

Route::get('verordnung.main', function () {
    return view('admin.verordnung.main');
})->name('verordnung.main')->middleware('auth');

Route::get('getKategorieProducts', function () {
    return view('admin.produkt.kategorie.index');
})->name('getKategorieProducts')->middleware('auth');

Route::get('firma.checkCompanyLabel', 'FirmaController@checkCompanyLabel')->name('firma.checkCompanyLabel')->middleware('auth');
Route::get('firma.checkCompanyKreditor', 'FirmaController@checkCompanyKreditor')->name('firma.checkCompanyKreditor')->middleware('auth');

Route::post('addApiTokenToUser/{user}', 'UserController@addTokenToUser')->name('addApiTokenToUser')->middleware('auth');

Route::get('/report/template', 'ReportController@template')->name('report.template');

Route::get('/installer', 'InstallerController@index')->name('installer.company');
Route::get('/installer/user', 'InstallerController@create')->name('installer.user');
Route::get('/installer/system', 'InstallerController@system')->name('installer.system');
Route::get('/installer/seed', 'InstallerController@seed')->name('installer.seed');

Route::get('/notes/file/{id}', 'NoteController@downloadNotesFile')->name('downloadNotesFile');

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

$storage = App\Location::latest('{var}')->get();  Sotrierung nach {var} desc
$storage = App\Location::take()3->latest('{var}')->get(); nehme die 3 letzten Sotrierung nach {var} desc

*/
