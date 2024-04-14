<?php

use App\Contact;
use App\ControlEquipment;
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
use App\ProduktAnforderung;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/update', function () {

    return redirect()->route('dashboard');
    /*   if (Auth::user()->isSysAdmin()) {
          $result_git = exec('git pull https://github.com/daniel-koertvelyessy/testware.git', $res_git_pull);
           $result_migrate = Artisan::call('migrate',[]);
           $output = Artisan::output();

           $database = env('DB_DATABASE');
           $path     =  storage_path().'/dbbk/';
           $ip       = env('DB_HOST');
           $port     = env('DB_PORT');
           $user    = env('DB_USERNAME');
           $passw    = env('DB_PASSWORD');

           $cmd = "docker-compose exec db pg_dump -U $user -P $passw  -h db $database > $path/dump.sql";

           $dumpSQL = exec($cmd,$result_sql_dump);

           return view('admin.update', [
               'result_sql_dump' => $result_sql_dump,
               'dumpSQL' => $dumpSQL,
               'result_git' => $result_git,
               'res_git_pull' => $res_git_pull,
               'response_migrate' => $output,
               'result_migrate' => $result_migrate,
           ]);

       } else {
           return back();
       }*/
})->middleware('auth');

Route::get('/', function () {
    return view('portal-main');
})->name('portal-main');

Route::get('support', function () {
    return view('support');
})->name('support');

Route::get('imprint', function () {
    $firma = \App\Location::with('Adresse', 'Profile')->first();

    return view('imprint', [
        'company_name' => $firma->ad_name_firma ?? '',
        'address'      => $firma->Adresse->postalAddress(),
        'contact'      => $firma->Profile->fullName(),
        'telefon'      => $firma->Profile->ma_telefon,
        'email'        => $firma->Profile->ma_email
    ]);
})->name('imprint');

Route::get('app', function () {
    return view('testware.app.index');
})->name('app');

Route::get('edata/{ident}', function ($ident, Request $request) {

    $equipment = EquipmentUid::where('equipment_uid', $ident)->first();
    if ($equipment) {
        $edata = Equipment::findOrFail($equipment->equipment_id);
        return view('testware.app.equipmentdata', [
            'edata' => $edata,
            'ident' => $ident
        ]);
    } else {
        $request->session()->flash('status',
                                   __('Das Gerät konnte nicht gefunden werden!'));
        return redirect()->route('app');
    }

    /*     $str = str_split($ident, strlen(env('APP_HSKEY')));
         if ($str[0] === env('APP_HSKEY')) {
             $e = explode(env('APP_HSKEY'), $ident);
             $uid = $e[1];

             $equipment = EquipmentUid::where('equipment_uid', $uid)->first();
             if ($equipment) {
                 $edata = Equipment::findOrFail($equipment->equipment_id);
                 return view('testware.app.equipmentdata', [
                     'edata' => $edata,
                     'ident' => $ident
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
         }*/
})->name('edata');

Route::get('edmg/{ident}', function ($ident, Request $request) {

    $equipment = EquipmentUid::where('equipment_uid', $ident)->first();


    if ($equipment) {
        $edata = Equipment::findOrFail($equipment->equipment_id);
        //            dd($edata);
        return view('testware.app.reportdamage', [
            'edata' => $edata,
            'ident' => $ident
        ]);
    } else {
        $request->session()->flash('status',
                                   __('Das Gerät konnte nicht gefunden werden!'));
        return redirect()->route('app');
    }


    /*   $str = str_split($ident, strlen(env('APP_HSKEY')));

       if ($str[0] === env('APP_HSKEY')) {
           $e = explode(env('APP_HSKEY'), $ident);
           $uid = $e[1];
           $equipment = EquipmentUid::where('equipment_uid', $uid)->first();


           if ($equipment) {
               $edata = Equipment::findOrFail($equipment->equipment_id);
               //            dd($edata);
               return view('testware.app.reportdamage', [
                   'edata' => $edata,
                   'ident' => $ident
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
       }*/
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

    $maxListItems = 15;

    $equipmentTestWeekList = ControlEquipment::join('anforderungs', 'anforderung_id', '=', 'anforderungs.id')
                                             ->with('Equipment')
                                             ->where('qe_control_date_due', '<=', now()->addWeeks(4))
                                             ->where('archived_at', NULL)
                                             ->where('is_initial_test', false)
                                             ->orderBy('qe_control_date_due')
                                             ->get();

    $equipmentTestMonthList = ControlEquipment::join('anforderungs', 'anforderung_id', '=', 'anforderungs.id')
                                              ->with('Equipment')
                                              ->where('archived_at', NULL)
                                              ->where('qe_control_date_due', '>', now()->addWeeks(4))
                                              ->where('qe_control_date_due', '<=', now()->addMonths(4))
                                              ->where('is_initial_test', false)
                                              ->orderBy('qe_control_date_due')
                                              ->get();

    $equipmentTestYearList = ControlEquipment::join('anforderungs', 'control_equipment.anforderung_id', '=', 'anforderungs.id')
                                             ->where('is_initial_test', false)
                                             ->where('archived_at', NULL)
                                             ->whereBetween('qe_control_date_due', [now(), date('Y' . '-12-31')])
                                             ->orderBy('qe_control_date_due')
                                             ->get();

    $equipmentTestList = ControlEquipment::join('anforderungs', 'anforderung_id', '=', 'anforderungs.id')
                                         ->with('Equipment')
                                         ->where('archived_at', NULL)
                                         ->where('is_initial_test', false)
                                         ->orderBy('qe_control_date_due')
                                         ->get();

    $initialiseApp = (User::count() === 1 && Auth::user()->name === 'testware');
    return view('dashboard', [
        'initialiseApp'          => $initialiseApp,
        'maxListItems'           => $maxListItems,
        'equipmentTestWeekList'  => $equipmentTestWeekList,
        'equipmentTestMonthList' => $equipmentTestMonthList,
        'equipmentTestYearList'  => $equipmentTestYearList,
        'equipmentTestList'      => $equipmentTestList,
    ]);
})->name('dashboard')->middleware('auth');

Route::put('user.resetPassword',
           'UserController@resetPassword')->name('user.resetPassword');

Route::put('user.setPassword',
           'UserController@setPassword')->name('user.setPassword');

Route::post('event.restore',
            'EquipmentEventController@restore')->name('event.restore');
Route::delete('event.close',
              'EquipmentEventController@close')->name('event.close');

Route::middleware('throttle:5|60,1')->group(function () {
    Route::post('app.store', 'AppController@store')->name('app.store');
});

Route::get('event/read/{event}/{notification?}', 'EquipmentEventController@read')->name('event.read');
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
                     'equipmentlabel'         => 'EquipmentLabelController',
                     'ProductInstruction'     => 'ProductInstructedUserController',
                     'ProductQualifiedUser'   => 'ProductQualifiedUserController',
                     'productparameter'       => 'ProductParameterController',
                     'equipmentparameter'     => 'EquipmentParameterController',
                     'lizenz'                 => 'LizenzController',
                     'report'                 => 'ReportController',
                     'search'                 => 'SearchController',
                     'tag'                    => 'TagController',
                     'note'                   => 'NoteController',
                     'note-type'              => 'NoteTypeController',
                     'testreportformat'       => 'TestReportFormatController',
                     'acidataset'             => 'AciDataSetController'
                 ]);

/**
 * Verwaltung/Admin routes laden
 */
require __DIR__ . '/admintools/admintools.php';
/**
 *  Produkt routes laden
 */
require __DIR__ . '/produkttools/produkttools.php';

Route::post('equip_document_add', 'EquipmentDocController@add')->name('equipdoc.add');
Route::post('control_add', 'ControlEquipmentController@add')->name('control.add');
Route::put('control_archive/{controlequipment}', 'ControlEquipmentController@archive')->name('control.archive');
Route::put('control/{controlequipment}/reactivate', 'ControlEquipmentController@reactivate')->name('control.reactivate');

Route::get('equipment/status/{equipmentState}', 'EquipmentController@statuslist')->name('equipment.statuslist');

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
})->name('printReport')->middleware('auth');

Route::get('makePDFEquipmentLabel/{equipment}', function ($equipment) {
    $equip = Equipment::find($equipment);
    if ($equip->produkt->equipment_label_id) {
        App\Http\Controllers\PdfGenerator::makePDFLabel($equip->produkt->equipment_label_id, $equipment);
    } elseif (EquipmentLabel::count() > 0) {
        $latestEquipmentlabelId = EquipmentLabel::first()->id;
        App\Http\Controllers\PdfGenerator::makePDFLabel($latestEquipmentlabelId, $equipment);
    } else {
        return back();
    }
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
    })->name('makePDFEquipmentControlReport')->middleware('auth');

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
                                               'label' => 'copy_' . $label->label
                                           ]);
    if ($copyLabel->save()) {
        $msg = __('Das Label wurde kopiert');
    } else {
        $msg = __('Ein Fehler ist beim Kopieren passiert!');
        Log::warning('error on copying an existing label');
    }
    request()->session()->flash('status', $msg);
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

Route::get('control.manual', 'ControlEquipmentController@manual')->name('control.manual')->middleware('auth');

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
        $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/' . $equipment_id);

        $proDocFile->document_type_id = request('document_type_id');
        $proDocFile->equipment_id = $equipment_id;
        $proDocFile->eqdoc_description = request('eqdoc_description');
        $proDocFile->eqdoc_label = request('eqdoc_label');

        if ($proDocFile->save()) {
            $msg = __(' ohne Fehler ');
        } else {
            $msg = __(' mit Fehler ');
            \Illuminate\Support\Facades\Log::warning('Fehler beim Erfassen einer Funktionsprüfung: ' . $file);
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
    $produktList = Produkt::where('prod_active', '1')->with('ProduktAnforderung')->sortable()->paginate(10);
    return view('testware.equipment.maker', ['produktList' => $produktList]);
})->name('equipment.maker')->middleware('auth');

Route::get('equipment.controlequipment', 'EquipmentController@controlequipment')->name('equipment.controlequipment')->middleware('auth');

Route::post('equipment/fixuid', 'EquipmentController@fixuid')->name('equipment.fixuid')->middleware('auth');
Route::post('equipment/syncuid', 'EquipmentController@syncuid')->name('equipment.syncuid')->middleware('auth');

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


require __DIR__ . '/auth.php';
