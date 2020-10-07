<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BuildingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return view('admin.standorte.building.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        return view('admin.standorte.building.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->b_we_has = $request->has('b_we_has') ? 1 : 0;

        $building =  Building::create($this->validateNewBuilding());

        $std = (new \App\Standort)->add($request->standort_id, $request->b_name_kurz,'buildings');

        $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_name_kurz') . '</strong> wurde angelegt!');
        return redirect()->back();

    }

    public function copyBuilding(Request $request) {
        if ($request->id){

            $bul = Building::find($request->id);
            $neuname = '';
            switch (true)
            {
                case strlen($bul->b_name_kurz) <= 20 && strlen($bul->b_name_kurz) > 14:
                    $neuname = substr($bul->b_name_kurz,0,13).'_1';
                    break;
                case strlen($bul->b_name_kurz) <= 14:
                    $neuname = $bul->b_name_kurz.'_1';
                    break;
            }



            $bul->b_name_kurz = $neuname;
            $copy = new Building();
            $copy->b_name_kurz = $neuname;
            $copy->b_name_ort = $bul->b_name_ort;
            $copy->b_name_lang = $bul->b_name_lang;
            $copy->b_name_text = $bul->b_name_text;
            $copy->b_we_has = $bul->b_we_has;
            $copy->b_we_name = $bul->b_we_name;
            $copy->location_id = $bul->location_id;
            $copy->building_type_id = $bul->building_type_id;
            $copy->standort_id = Str::uuid();
//            $copy->
            $validator = Validator::make([
                $copy->b_name_kurz,
                $copy->b_name_ort,
                $copy->b_name_lang,
                $copy->b_name_text,
                $copy->b_we_has,
                $copy->b_we_name,
                $copy->location_id,
                $copy->building_type_id,
                $copy->standort_id,

            ], [
                'b_name_kurz' => 'bail|required|unique:buildings,b_name_kurz|min:2|max:10',
                'b_name_ort' =>'',
                'b_name_lang' =>'',
                'b_name_text' =>'',
                'b_we_has' =>'',
                'b_we_name' =>'required_if:b_we_has,1',
                'location_id' =>'required',
                'building_type_id' =>'required',
            ]);
            $copy->save();

            $std = (new \App\Standort)->add($copy->standort_id, $neuname,'buildings');

            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_name_kurz') . '</strong> wurde kopiert!');
            return $copy->id;
        } else {
            return 0;
        }
    }

    public function getBuildingList($id)
    {
        return DB::table('buildings')->where('location_id',$id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Building $building
     * @return Application|Factory|Response|View
     */
    public function show(Building $building)
    {
        return view('admin.standorte.building.show',['building'=>$building]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Building $building
     * @return Application|Factory|View
     */
    public function edit(building $building)
    {
        return view('admin.standorte.building.edit',compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Building $building
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Building $building)
    {
        $building->b_we_has = $request->has('b_we_has') ? 1 : 0;
        $building->update($this->validateBuilding());

        $request->session()->flash('status', 'Das Gebäude <strong>' . $building->b_name_kurz . '</strong> wurde aktualisiert!');
        return redirect($building->path());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Building $building
     * @return Response
     */
    public function destroy(Building $building)
    {
        //  destroyBuildingAjax
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Building $building
     * @return Response
     */
    public function destroyBuildingAjax(Request $request)
    {
        $rname = request('b_name_lang');
        if ( Building::destroy($request->id) ){

            $request->session()->flash('status', 'Das Gebäude <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return array
     */
    public function validateNewBuilding(): array
    {
        return request()->validate([
            'b_name_kurz' => 'bail|required|unique:buildings,b_name_kurz|min:2|max:10',
            'b_name_ort' =>'',
            'b_name_lang' =>'',
            'b_name_text' =>'',
            'b_we_has' =>'',
            'b_we_name' =>'required_if:b_we_has,1',
            'location_id' =>'required',
            'building_type_id' =>'required',
        ]);
    }

    /**
     * @return array
     */
    public function validateBuilding(): array
    {
        return request()->validate([
            'b_name_kurz' => 'bail|required|min:2|max:10',
            'b_name_ort' =>'',
            'b_name_lang' =>'',
            'b_name_text' =>'',
            'b_we_has' =>'',
            'b_we_name' =>'required_if:b_we_has,1',
            'location_id' =>'required',
            'building_type_id' =>'',
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'b_we_name.required_if' => 'custom-message',
            'body.required' => 'A message is required',
        ];
    }
}
