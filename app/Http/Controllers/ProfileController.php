<?php

namespace App\Http\Controllers;

use App\Location;
use App\Profile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProfileController extends Controller
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
        $profileList = Profile::with('user')->paginate(15);
        return view('admin.organisation.profile.index',['profileList'=>$profileList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
       return view('admin.organisation.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $profile = Profile::create($this->validateNewProfile());
        $text='';
        if (isset($request->setProfileAsNewMain)){

            $location = Location::find($request->setProfileAsNewMain);
            $location->profile_id = $profile->id;
            $location->save();
            $text=' und als neue Leitung des Standortes '.$location->l_name_kurz.' gesetzt';

        }
        $request->session()->flash('status', 'Der Mitarbeiter wurde angelegt'.$text);
//        return view('admin.organisation.profile.show',['profile'=>$profile]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Profile $profile
     * @return Application|Factory|Response|View
     */
    public function show(Profile $profile)
    {
       return view('admin.organisation.profile.show',['profile'=>$profile]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Profile $profile
     * @return Application|Factory|Response|View
     */
    public function update(Request $request, Profile $profile)
    {
        $profile->update($this->validateProfile());
        $request->session()->flash('status', 'Der Mitarbeiter wurde aktualisiert!');
        return view('admin.organisation.profile.show',['profile'=>$profile]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Profile $profile
     * @return Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    /**
     * @return array
     */
    public function validateNewProfile(): array {

        return request()->validate([
            'ma_name'         => 'required|unique:profiles,ma_name|max:20',
            'ad_name_lang'    => 'max:100',
            'ma_nummer'       => 'max:100',
            'ma_name_2'       => '',
            'ma_vorname'      => '',
            'ma_geburtsdatum' => '',
            'ma_eingetreten'  => '',
            'ma_ausgetreten'  => '',
            'ma_telefon'      => '',
            'ma_mobil'        => '',
            'ma_fax'          => '',
            'ma_com_1'        => '',
            'ma_com_2'        => '',
            'group_id'        => '',
            'user_id'         => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateProfile(): array {

        return request()->validate([
            'ma_name'         => 'required|max:20',
            'ad_name_lang'    => 'max:100',
            'ma_nummer'       => 'max:100',
            'ma_name_2'       => '',
            'ma_vorname'      => '',
            'ma_geburtsdatum' => '',
            'ma_eingetreten'  => '',
            'ma_ausgetreten'  => '',
            'ma_telefon'      => '',
            'ma_mobil'        => '',
            'ma_fax'          => '',
            'ma_com_1'        => '',
            'ma_com_2'        => '',
            'group_id'        => '',
            'user_id'         => ''
        ]);
    }
}
