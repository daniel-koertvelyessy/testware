<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\AnforderungControlItem;
use App\AnforderungObjekt;
use App\ControlProdukt;
use App\Http\Services\Regulation\RequirementService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AnforderungsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getACI($anforderung_id)
    {
        return AnforderungControlItem::where('anforderung_id', $anforderung_id)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('admin.verordnung.anforderung.index', [
            'requirements' => Anforderung::with('ControlInterval', 'AnforderungControlItem')->sortable()->paginate(10),
            'isSysAdmin' => \Auth::user()->isSysAdmin(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {
        return view('admin.verordnung.anforderung.create', ['vid' => (int) $request->v]);
    }

    /**
     *  Speichere neue Anforderung
     *
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->is_initial_test = $request->has('is_initial_test');
        $request->is_external = $request->has('is_external');
        Anforderung::create($this->validateAnforderung());
        $request->session()->flash('status', 'Die Anforderung <strong>'.request('an_label').'</strong> wurde angelegt!');

        return back();
    }

    /**
     * Display the specified resource.
     *
     *
     * @return Application|Factory|Response|View
     */
    public function show(Anforderung $anforderung)
    {
        return view('admin.verordnung.anforderung.show', ['anforderung' => $anforderung, 'countControlProducts' => ControlProdukt::all()->count()]);
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Anforderung $anforderung)
    {
        $this->validateAnforderung();
        $anforderung->an_label = $request->an_label;
        $anforderung->an_name = $request->an_name;
        $anforderung->an_description = $request->an_description;
        $anforderung->an_control_interval = $request->an_control_interval;
        $anforderung->control_interval_id = $request->control_interval_id;
        $anforderung->verordnung_id = $request->verordnung_id;
        $anforderung->an_date_warn = $request->an_date_warn;
        $anforderung->warn_interval_id = $request->warn_interval_id;
        $anforderung->anforderung_type_id = $request->anforderung_type_id;
        $anforderung->is_initial_test = $request->has('is_initial_test'); // ?1:0;
        $anforderung->is_external = $request->has('is_external'); // ?1:0;

        if ($anforderung->save()) {
            session()->flash('status', __('Die Anforderung <strong>:name</strong> wurde aktualisert!', ['name' => $anforderung->an_name]));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Anforderung $anforderung)
    {
        $service = new RequirementService;

        $service->deleteRelatedItems($anforderung);

        $anforderung->delete();
        session()->flash('status', 'Die Anforderung wurde gelöscht!');

        return redirect()->route('anforderung.index');
    }

    public function restore(Request $request)
    {

        $msg = (Anforderung::withTrashed()->find($request->id)->restore())
            ? __('Anforderung wurde wiederhergestellt')
            : __('Anforderung konnte nicht wiederhergestellt werden!');

        $request->session()->flash('status', $msg);

        return back();

    }

    public function validateAnforderung(): array
    {

        // dd($request);
        return request()->validate([
            'an_label' => 'bail|required|max:20',
            'an_name' => 'bail|max:100',
            'an_description' => '',
            'an_control_interval' => 'integer',
            'control_interval_id' => 'integer',
            'verordnung_id' => 'integer',
            'an_date_warn' => '',
            'warn_interval_id' => 'integer',
            'is_initial_test' => 'nullable|boolean',
            'is_external' => 'nullable|boolean',
            'anforderung_type_id' => 'bail|required|integer',
        ],
            [
                'an_label.required' => __('Bitte ein Label für die Anforderung vergeben.'),
                'an_label.max' => __('Das Label darf maximal 20 Zeichen lang sein.'),
            ]);
    }

    public function validateObjektAnforderung(): array
    {
        return request()->validate([
            'storage_uid' => 'required',
            'anforderung_id' => 'required',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return RedirectResponse
     */
    public function storeAnObjekt(Request $request)
    {
        AnforderungObjekt::create($this->validateObjektAnforderung());
        $request->session()->flash('status', 'Die Anforderung <strong>'.request('an_label').'</strong> wurde zugewiesen!');

        return back();
    }
}
