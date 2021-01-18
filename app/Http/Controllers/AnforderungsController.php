<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\AnforderungControlItem;
use App\AnforderungObjekt;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AnforderungsController extends Controller
{

    use SoftDeletes;

    public function __construct()
    {
        $this->middleware('auth');
    }

    static function getACI($anforderung_id)
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

        if (Anforderung::all()->count() > 10) {
            return view('admin.verordnung.anforderung.index', [
                'requirements' => Anforderung::with('ControlInterval')->sortable()->paginate(10)
            ]);
        } else {
            return view('admin.verordnung.anforderung.index', [
                'requirements' => Anforderung::with('ControlInterval')->sortable()->get()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.verordnung.anforderung.create');
    }

    /**
     *  Speichere neue Anforderung
     *
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        Anforderung::create($this->validateAnforderung());

        $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_label') . '</strong> wurde angelegt!');
        return back();
    }

    /**
     * @return array
     */
    public function validateAnforderung(): array
    {
        return request()->validate([
            'an_label'        => 'bail|required|max:20',
            'an_name'        => 'bail|max:100',
            'an_description'        => '',
            'an_control_interval' => 'integer',
            'control_interval_id' => '',
            'verordnung_id'       => '',
            'anforderung_type_id' => 'bail|required|integer',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function storeAnObjekt(Request $request)
    {
        AnforderungObjekt::create($this->validateObjektAnforderung());

        $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_label') . '</strong> wurde zugewiesen!');
        return back();
    }

    /**
     * @return array
     */
    public function validateObjektAnforderung(): array
    {
        return request()->validate([
            'storage_uid'         => 'required',
            'anforderung_id' => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Anforderung $anforderung
     * @return Application|Factory|Response|View
     */
    public function show(Anforderung $anforderung)
    {
        return view('admin.verordnung.anforderung.show', ['anforderung' => $anforderung]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request     $request
     * @param  Anforderung $anforderung
     * @return RedirectResponse
     */
    public function update(Request $request, Anforderung $anforderung)
    {
        $anforderung->update($this->validateAnforderung());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Anforderung $anforderung
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Anforderung $anforderung)
    {

        $anforderung->delete();
        session()->flash('status', 'Die Anforderung wurde gelöscht!');
        return redirect()->back();
    }
}
