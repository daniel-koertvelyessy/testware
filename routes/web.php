<?php

use App\Equipment;
use App\EquipmentDoc;
use App\EquipmentFuntionControl;
use App\EquipmentLabel;
use App\EquipmentUid;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Produkt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

        $equipment = EquipmentUid::where('equipment_uid', $uid)->first();
        if ($equipment) {
            $edata = Equipment::findOrFail($equipment->equipment_id);
            return view('testware.app.equipmentdata', [
                'edata' => $edata, 'ident' => $ident
            ]);
        } else {
            $request->session()->flash('status',
                __('Das Gerät konnte nicht gefunden werden!'));
            return redirect()->route('app');
        }
    } else {
        $request->session()->flash('status',
            __('Das Gerät konnte nicht gefunden werden!'));
        return redirect()->route('app');
    }
})->name('edata');

Route::get('edmg/{ident}', function ($ident, Request $request) {
    $str = str_split($ident, strlen(env('APP_HSKEY')));

    if ($str[0] === env('APP_HSKEY')) {
        $e = explode(env('APP_HSKEY'), $ident);
        $uid = $e[1];
        $equipment = EquipmentUid::where('equipment_uid', $uid)->first();


        if ($equipment) {
            $edata = Equipment::findOrFail($equipment->equipment_id);
            //            dd($edata);
            return view('testware.app.reportdamage', [
                'edata' => $edata, 'ident' => $ident
            ]);
        } else {
            $request->session()->flash('status',
                __('Das Gerät konnte nicht gefunden werden!'));
            return redirect()->route('app');
        }
    } else {
        $request->session()->flash('status',
            __('Das Gerät konnte nicht gefunden werden!'));
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

Route::get('/dashboard', function () {
    $initialiseApp = (User::count() === 1 && Auth::user()->name === 'testware');
    return view('dashboard', compact('initialiseApp'));
})->name('dashboard')->middleware('auth');

Route::put('user.resetPassword',
    'UserController@resetPassword')->name('user.resetPassword');
Route::post('event.restore',
    'EquipmentEventController@restore')->name('event.restore');
Route::delete('event.close',
    'EquipmentEventController@close')->name('event.close');

Route::middleware('throttle:5|60,1')->group(function () {
    Route::post('app.store', 'AppController@store')->name('app.store');
});
Route::put('event.accept',
    'EquipmentEventController@accept')->name('event.accept');

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
    //    'testware'               => 'TestwareController',
    'equipment'              => 'EquipmentController',
    'control'                => 'ControlEquipmentController',
    'user'                   => 'UserController', 'role' => 'RoleController',
    'stellplatz'             => 'StellplatzController',
    'anforderung'            => 'AnforderungsController',
    'verordnung'             => 'VerordnungController',
    'anforderungcontrolitem' => 'AnforderungControlItemController',
    'event'                  => 'EquipmentEventController',
    'eventitem'              => 'EquipmentEventItemController',
    'EquipmentInstruction'   => 'EquipmentInstructionController',
    'EquipmentQualifiedUser' => 'EquipmentQualifiedUserController',
    'equipmentlabel'         => 'EquipmentLabelController',
    'ProductInstruction'     => 'ProductInstructedUserController',
    'ProductQualifiedUser'   => 'ProductQualifiedUserController',
    'productparameter'       => 'ProductParameterController',
    'lizenz'                 => 'LizenzController',
    'report'                 => 'ReportController',
    'search'                 => 'SearchController', 'tag' => 'TagController',
    'note'                   => 'NoteController',
    'note-type'              => 'NoteTypeController',
    'testreportformat'       => 'TestReportFormatController',
]);

/**
 * Verwaltung/Admin routes laden
 */
require __DIR__.'/admintools/admintools.php';
/**
 *  Produkt routes laden
 */
require __DIR__.'/produkttools/produkttools.php';

Route::post('user.setMsgRead',
    'UserController@setMsgRead')->name('user.setMsgRead');
Route::delete('user.deleteMsg',
    'UserController@deleteMsg')->name('user.deleteMsg');
Route::delete('user.revokerole',
    'UserController@revokerole')->name('user.revokerole');
Route::post('user.grantrole',
    'UserController@grantrole')->name('user.grantrole');
Route::delete('user.revokeSysAdmin/{user}',
    'UserController@revokeSysAdmin')->name('user.revokeSysAdmin');
Route::post('user.grantSysAdmin/{user}',
    'UserController@grantSysAdmin')->name('user.grantSysAdmin');

Route::get('getFirmenAjaxListe',
    'FirmaController@getFirmenAjaxListe')->name('getFirmenAjaxListe');
Route::get('getFirmenDaten',
    'FirmaController@getFirmenDaten')->name('getFirmenDaten');

Route::get('getAddressenAjaxListe',
    'AdresseController@getAddressenAjaxListe')->name('getAddressenAjaxListe');
Route::get('getAddressDaten',
    'AdresseController@getAddressDaten')->name('getAddressDaten');
Route::get('getControlEventDataSheet',
    'ControlEquipmentController@getControlEventDataSheet')->name('getControlEventDataSheet');

Route::get('getEquipmentAjaxListe',
    'EquipmentController@getEquipmentAjaxListe')->name('getEquipmentAjaxListe');
Route::get('searchInModules',
    'SearchController@searchInModules')->name('searchInModules');
Route::get('searchInDocumentation',
    'SearchController@searchInDocumentation')->name('searchInDocumentation');

/*

PDF GENERATORS

*/
Route::get('pdf.storageListe',
    'PdfGenerator@storageListe')->name('pdf.storageListe');

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

Route::get('test_equipment_label/{label}', function ($label) {
    App\Http\Controllers\PdfGenerator::makePDFLabel($label);
})->name('test_equipment_label');

Route::get('makePDFEquipmentControlReport/{controlEvent}',
    function ($controlEvent) {
        App\Http\Controllers\PdfGenerator::makePDFEquipmentControlReport(App\ControlEvent::find($controlEvent));
    })->name('makePDFEquipmentControlReport');

//Auth::routes();

Route::get('/expired', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return view('auth.expired');
})->name('auth.expired');


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

Route::get('unlockScreen', function () {
    return ['status' => request('pin') === '2231'];
})->name('unlockScreen')->middleware('auth');

Route::post('equipmentlabel/copy/{id}', function ($id) {
    $label = EquipmentLabel::find($id);
    $copyLabel = $label->replicate()->fill([
        'label' => 'copy_'.$label->label
    ]);
    if ( $copyLabel->save() ) {
        $msg = __('Das Label wurde kopiert');
    } else {
        $msg = __('Ein Fehler ist beim Kopieren passiert!');
        Log::warning('error on copying an existing label');
    }
    request()->session()->flash('status',$msg);
    return back();

})->name('equipmentlabel.copy')->middleware('auth');

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
    $equipment = Equipment::find($equipment_id);

    (new EquipmentFuntionControl())->addControlEvent($request, $equipment_id);

    if ($request->hasFile('equipDokumentFile')) {
        $proDocFile = new EquipmentDoc();
        $file = $request->file('equipDokumentFile');
        $request->validate([
            'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:20480',
            // size:2048 => 2048kB
            'eqdoc_label'       => 'required|max:150'
        ]);

        $proDocFile->eqdoc_name = $file->getClientOriginalName();
        $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/'.$equipment_id);

        $proDocFile->document_type_id = request('document_type_id');
        $proDocFile->equipment_id = $equipment_id;
        $proDocFile->eqdoc_description = request('eqdoc_description');
        $proDocFile->eqdoc_label = request('eqdoc_label');

        if ($proDocFile->save()) {
            $msg = __(' ohne Fehler ');
        } else {
            $msg = __(' mit Fehler ');
            \Illuminate\Support\Facades\Log::warning('Fehler beim Erfassen einer Funktionsprüfung: '.$file);
        }
        $equipment->equipment_state_id = 1;
        $equipment->save();
    } else {
        $equipment->equipment_state_id = 4;
        $equipment->save();
        $msg = __(' ohne Dokumentation ');
    }

    $request->session()->flash('status',
        __('Die Funktionsprüfung wurde :msg angelegt!', ['msg' => $msg]));

    return back();
})->name('addEquipmentFunctionControl')->middleware('auth');

Route::get('produktMain', function () {
    return view('admin.produkt.main',
        ['produkts' => App\Produkt::all()->sortDesc()->take(10)]);
})->name('produktMain')->middleware('auth');

Route::get('equipMain', function () {
    $equipmentList = Equipment::with('produkt', 'storage', 'EquipmentState',
        'ControlEquipment')->sortable()->paginate(10);
    return view('testware.equipment.main', ['equipmentList' => $equipmentList]);
})->name('equipMain')->middleware('auth');

Route::get('equipment.maker', function () {
    $produktList = Produkt::sortable()->paginate(10);
    return view('testware.equipment.maker', ['produktList' => $produktList]);
})->name('equipment.maker')->middleware('auth');

Route::get('verordnung.main', function () {
    return view('admin.verordnung.main');
})->name('verordnung.main')->middleware('auth');

//Route::get('getKategorieProducts', function () {
//    return view('admin.produkt.kategorie.index');
//})->name('getKategorieProducts')->middleware('auth');

Route::get('firma.checkCompanyLabel',
    'FirmaController@checkCompanyLabel')->name('firma.checkCompanyLabel')->middleware('auth');
Route::get('firma.checkCompanyKreditor',
    'FirmaController@checkCompanyKreditor')->name('firma.checkCompanyKreditor')->middleware('auth');

Route::post('addApiTokenToUser/{user}',
    'UserController@addTokenToUser')->name('addApiTokenToUser')->middleware('auth');

Route::get('/report/template',
    'ReportController@template')->name('report.template');

Route::get('/notes/file/{id}',
    'NoteController@downloadNotesFile')->name('downloadNotesFile');

//Route::get('getTestingCalender/{setdate}', function ($setdate) {
//    $data['html'] = view('components.testcalendar', compact('setdate'))->render();
//    return json_encode($data);
//
//});

Route::get('/register', [
    RegisteredUserController::class, 'create'
])->middleware('guest')->name('register');

Route::post('/register', [
    RegisteredUserController::class, 'store'
])->middleware('guest');

Route::get('/login', [
    AuthenticatedSessionController::class, 'create'
])->middleware('guest')->name('login');

Route::post('/login', [
    AuthenticatedSessionController::class, 'store'
])->middleware('guest');

Route::get('/forgot-password', [
    PasswordResetLinkController::class, 'create'
])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [
    PasswordResetLinkController::class, 'store'
])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [
    NewPasswordController::class, 'create'
])->middleware('guest')->name('password.reset');

Route::post('/reset-password', [
    NewPasswordController::class, 'store'
])->middleware('guest')->name('password.update');

Route::post('/logout', [
    AuthenticatedSessionController::class, 'destroy'
])->middleware('auth')->name('logout');
