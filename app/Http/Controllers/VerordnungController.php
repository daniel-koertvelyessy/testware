<?php

namespace App\Http\Controllers;

use App\Verordnung;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class VerordnungController extends Controller
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
        if (Verordnung::all()->count() > 10) {
            return view('admin.verordnung.index', [
                'verordnungen' => Verordnung::with('anforderung')->sortable()->paginate(10)
            ]);
        } else {
            return view('admin.verordnung.index', [
                'verordnungen' => Verordnung::with('anforderung')->sortable()->get()
            ]);
        }
    }


    public function main()
    {
        return view('admin.verordnung.main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.verordnung.create');
    }

    /**
     *  Speichere neue Anforderung
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $verordnung = Verordnung::create($this->validateNewVerordnug());

        $request->session()->flash('status', 'Die Verordnung <strong>' . request('vo_label') . '</strong> wurde angelegt!');
        return view('admin.verordnung.show', ['verordnung' => $verordnung]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Verordnung $verordnung
     * @return Application|Factory|Response|View
     */
    public function show(Verordnung $verordnung)
    {
        return view('admin.verordnung.show', ['verordnung' => $verordnung]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Verordnung $verordnung
     * @return Response
     */
    public function edit(Verordnung $verordnung)
    {
        //
    }

    /**
     * Aktualisiere die gegebene Verordnung
     *
     * @param Request $request
     * @param Verordnung $anforderung
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Verordnung $verordnung)
    {
        $data = Verordnung::findOrFail($request->id);
        $data->update($this->validateVerordnug());
        $request->session()->flash('status', 'Die Verordnung <strong>' . request('vo_label') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Request $request, Verordnung $verordnung)
    {
        $verordnung->delete();
        $request->session()->flash('status', 'Die Verordnung wurde gelöscht!');
        return back();
    }

    /**
     * @return array
     */
    public function validateVerordnug(): array
    {
        return request()->validate([
            'vo_label' => 'bail|required|min:1|max:20',
            'vo_name' => 'bail|min:1|max:100',
            'vo_nummer' => 'bail|min:1|max:100',
            'vo_stand' => 'bail|min:1|max:100',
            'vo_description' => '',
        ]);
    }

    /**
     * @return array
     */
    public function validateNewVerordnug(): array
    {
        return request()->validate([
            'vo_label' => 'bail|unique:verordnungs,vo_label|required|min:1|max:20',
            'vo_name' => 'bail|min:1|max:100',
            'vo_nummer' => 'bail|min:1|max:100',
            'vo_stand' => 'bail|min:1|max:100',
            'vo_description' => '',
        ]);
    }
}
