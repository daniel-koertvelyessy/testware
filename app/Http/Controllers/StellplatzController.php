<?php

namespace App\Http\Controllers;

use App\Stellplatz;
use App\StellplatzTyp;
use App\Storage;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StellplatzController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $compartments = Stellplatz::with('stellplatztypes', 'rooms')->sortable()->paginate(10);
        return view('admin.standorte.storage.index', compact('compartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.standorte.storage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //        dump($request);
        //        dd($request->room_id);
        $sp = Stellplatz::create($this->validateStellPlatz());
        (new Storage)->add($request->storage_id, $request->sp_label, 'stellplatzs');
        $request->session()->flash('status', 'Der Stellplatzt <strong>' . request('sp_label') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateStellPlatz()
    : array
    {
        return request()->validate([
            'sp_label'          => [
                'bail',
                'required',
                'min:1',
                'max:20',
                Rule::unique('stellplatzs')->ignore(\request('id'))
            ],
            'sp_name'           => 'max:100',
            'sp_description'    => '',
            'storage_id'        => 'required',
            'room_id'           => 'required',
            'stellplatz_typ_id' => 'required',
        ]);
    }

    /**
     * @param  Request $reuest
     *
     * @return RedirectResponse
     */
    public function copyStellplatz(Request $reuest)
    {
        $stellplatz = Stellplatz::find($reuest->id);
        $name = substr('stor_' . md5($stellplatz->sp_label), 0, 15);
        $newStellplatz = $stellplatz->replicate()->fill([
            'sp_label' => $name
        ]);

        $newStellplatz->save();

        session()->flash('status', __('Der Stellplatzt <strong>:name</strong> wurde kopiert!', ['name'=>$stellplatz->sp_label]));
        return redirect()->route('stellplatz.show',$newStellplatz);
    }

    /**
     * Display the specified resource.
     *
     * @param  Stellplatz $stellplatz
     *
     * @return Application|Factory|Response|View
     */
    public function show(Stellplatz $stellplatz)
    {
        return view('admin.standorte.storage.show', compact('stellplatz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Stellplatz $stellplatz
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Stellplatz $stellplatz)
    {
        return view('admin.standorte.storage.edit', compact('stellplatz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request    $request
     * @param  Stellplatz $stellplatz
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Stellplatz $stellplatz)
    : RedirectResponse
    {
        (new Storage)->checkUpdate($request->storage_id, $request->sp_label);
        $stellplatz->update($this->validateStellPlatz());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request    $request
     * @param  Stellplatz $stellplatz
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, Stellplatz $stellplatz)
    {
        $stellplatz->delete();
        $request->session()->flash('status', 'Der Stellplatz <strong>' . $request->sp_label . '</strong>  wurde gelöscht!');
        return redirect()->back();
    }

    /**
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function destroyStellplatzAjax(Request $request)
    : RedirectResponse
    {
        $compartment = Stellplatz::find($request->id);
        $request->session()->flash('status', __('Der Stellplatz <strong>:label</strong>  wurde gelöscht!', ['label' => $compartment->sp_label]));
        $compartment->delete();
        return back();
    }

    public function modal(Request $request)
    : RedirectResponse
    {

        if ($request->stellplatz_typ_id === 'new' && isset($request->stellplatz_typ_id)) {
            $bt = new StellplatzTyp();
            $bt->spt_label = $request->newStellplatzType;
            $bt->save();
            $request->stellplatz_typ_id = $bt->id;
        }
        $this->validateStellPlatz();
        if ($request->modalType === 'edit') {
            $stellplatz = Stellplatz::find($request->id);

            if ($stellplatz->sp_label !== $request->sp_label) {
                $storage = Storage::where('storage_uid', $request->storage_id)->first();
                $storage->storage_label = $request->sp_label;
                $storage->save();
            }
            $stellplatz->sp_label = $request->sp_label;
            $request->session()->flash('status', 'Der Stellplatz <strong>' . request('sp_label') . '</strong> wurde aktualisiert!');
        } else {

            $stellplatz = new Stellplatz();
            $stellplatz->sp_label = $request->sp_label;
            (new Storage)->add($request->storage_id, $request->sp_label, 'stellplatzs');
            $request->session()->flash('status', __('Der Stellplatz <strong>:label</strong> wurde angelegt!', ['label' => request('sp_label')]));
        }

        $stellplatz->storage_id = $request->storage_id;
        $stellplatz->sp_name = $request->sp_name;
        $stellplatz->sp_description = $request->sp_description;
        $stellplatz->room_id = $request->room_id;
        $stellplatz->stellplatz_typ_id = $request->stellplatz_typ_id;
        $stellplatz->save();

        return redirect()->back();
    }


    public function getStellplatzData(Request $request)
    {
        return Stellplatz::find($request->id);
    }

    public function getObjectsInCompartment(Request $request)
    {
        $compartment = Stellplatz::find($request->id);
        $data['html'] = '
<p class="mt-3">' . __('Folgende Objekte werden von der Lösung betroffen sein.') . '</p>
<ul class="list-group">';
        $countEquipment = $compartment->countTotalEquipmentInCompartment() ?? 0;
        $bgEquipment = $countEquipment > 0 ? 'list-group-item-danger' : '';
        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center ' . $bgEquipment . ' ">' . __('Geräte') . '<span class="badge badge-primary badge-pill">' . $countEquipment . '</span></li>';

        return $data;
    }
}
