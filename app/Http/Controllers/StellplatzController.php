<?php

namespace App\Http\Controllers;

use App\Storage;
use App\Stellplatz;
use App\StellplatzTyp;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class StellplatzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //        dump($request);
        //        dd($request->room_id);
        $sp = Stellplatz::create($this->validateNeuStellPlatz());
        (new \App\Storage)->add($request->storage_id, $request->sp_label, 'stellplatzs');
        $request->session()->flash('status', 'Der Stellplatzt <strong>' . request('sp_label') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNeuStellPlatz(): array
    {
        return request()->validate([
            'sp_label'      => 'bail|unique:stellplatzs,sp_label|required|min:1|max:20',
            'sp_name'      => 'max:100',
            'sp_description'      => '',
            'storage_id'       => 'required',
            'room_id'           => 'required',
            'stellplatz_typ_id' => 'required',
        ]);
    }

    /**
     * @param  Request $reuest
     * @return RedirectResponse
     */
    public function copyStellplatz(Request $reuest)
    {
        $stellplatz = Stellplatz::find($reuest->id);
        $name = strtr('Kopie_' . $stellplatz->sp_label, 0, 19);
        $newStellplatz = $stellplatz->replicate()->fill([
            'sp_label' => $name
        ]);

        $newStellplatz->save();

        session()->flash('status', 'Der Stellplatzt <strong>' . $stellplatz->sp_label . '</strong> wurde kopiert!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Stellplatz $stellplatz
     * @return Response
     */
    public function show(Stellplatz $stellplatz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Stellplatz $stellplatz
     * @return Response
     */
    public function edit(Stellplatz $stellplatz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request    $request
     * @param  Stellplatz $stellplatz
     * @return Response
     */
    public function update(Request $request, Stellplatz $stellplatz)
    {
        if ($stellplatz->sp_label !== $request->sp_label) {
            $storage = Storage::where('storage_uid', $request->storage_id)->first();
            $storage->storage_label = $request->sp_label;
            $storage->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request    $request
     * @param  Stellplatz $stellplatz
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Stellplatz $stellplatz)
    {
        $stellplatz->delete();
        $request->session()->flash('status', 'Der Stellplatz <strong>' . $request->sp_label . '</strong>  wurde gelöscht!');
        return redirect()->back();
    }

    /**
     * @param  Request $request
     * @return boolean
     */
    public function destroyStellplatzAjax(Request $request)
    {
        if (Stellplatz::destroy($request->id)) {
            $request->session()->flash('status', 'Der Stellplatz <strong>' . $request->sp_label . '</strong>  wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    public function modal(Request $request)
    {

        if ($request->stellplatz_typ_id === 'new' && isset($request->stellplatz_typ_id)) {
            $bt = new StellplatzTyp();
            $bt->spt_label = $request->newStellplatzType;
            $bt->save();
            $request->stellplatz_typ_id = $bt->id;
        }

        if ($request->modalType === 'edit') {
            $this->validateStellPlatz();
            $stellplatz = Stellplatz::find($request->id);

            if ($stellplatz->sp_label !== $request->sp_label) {
                $storage = Storage::where('storage_uid', $request->storage_id)->first();
                $storage->storage_label = $request->sp_label;
                $storage->save();
            }

            $stellplatz->sp_label = $request->sp_label;
            $stellplatz->sp_name = $request->sp_name;
            $stellplatz->sp_description = $request->sp_description;
            $stellplatz->room_id = $request->room_id;
            $stellplatz->stellplatz_typ_id = $request->stellplatz_typ_id;
            $stellplatz->save();


            $request->session()->flash('status', 'Der Stellplatz <strong>' . request('sp_label') . '</strong> wurde aktualisiert!');
        } else {

            $this->validateNeuStellPlatz();

            $stellplatz = new Stellplatz();
            $stellplatz->sp_label = $request->sp_label;
            $stellplatz->sp_name = $request->sp_name;
            $stellplatz->sp_description = $request->sp_description;
            $stellplatz->room_id = $request->room_id;
            $stellplatz->stellplatz_typ_id = $request->stellplatz_typ_id;
            $stellplatz->storage_id = $request->storage_id;
            $stellplatz->save();

            $std = (new \App\Storage)->add($request->storage_id, $request->sp_label, 'stellplatzs');
            $request->session()->flash('status', 'Der Stellplatz <strong>' . request('sp_label') . '</strong> wurde angelegt!');
        }

        return redirect()->back();
    }

    public function getStellplatzData(Request $request)
    {
        return Stellplatz::find($request->id);
    }

    /**
     * @return array
     */
    public function validateStellPlatz(): array
    {
        return request()->validate([
            'sp_label'      => 'bail|required|min:1|max:20',
            'sp_name'      => 'max:100',
            'sp_description'      => '',
            'room_id'           => 'required',
            'stellplatz_typ_id' => 'required',
        ]);
    }
}
