<?php

namespace App\Http\Controllers;

use App\Location;
use App\Profile;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
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
        $profileList = Profile::with('user')->paginate(10);
        return view('admin.organisation.profile.index', compact('profileList'));
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
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        $profile = Profile::create($this->validateNewProfile());
        $text = '';
        if (isset($request->setProfileAsNewMain)) {

            $location = Location::find($request->setProfileAsNewMain);
            $location->profile_id = $profile->id;
            $location->save();
            $text = __(' und als neue Leitung des Standortes :locName gesetzt',['locname'=>$location->l_label]);
        }
        $request->session()->flash('status', __('Der Mitarbeiter wurde angelegt') . $text);
        //        return view('admin.organisation.profile.show',['profile'=>$profile]);
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNewProfile()
    : array
    {

        return request()->validate([
            'ma_name'         => 'required|unique:profiles,ma_name|max:20',
            'ad_name'         => 'max:100',
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
     * Display the specified resource.
     *
     * @param  Profile $profile
     *
     * @return Application|Factory|Response|View
     */
    public function show(Profile $profile)
    {
        return view('admin.organisation.profile.show', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Profile $profile
     *
     * @return Application|Factory|Response|View
     */
    public function update(Request $request, Profile $profile)
    {
        $profile->update($this->validateProfile());
        $request->session()->flash('status', __('Der Mitarbeiter wurde aktualisiert!'));
        return view('admin.organisation.profile.show', compact('profile'));
    }

    /**
     * @return array
     */
    public function validateProfile()
    : array
    {

        return request()->validate([
            'ma_name'         => 'required|max:20',
            'ad_name'         => 'max:100',
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
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  Profile $profile
     *
     * @return Application|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function destroy(Request $request, Profile $profile)
    {
        $profile->delete();
        $request->session()->flash('status', __('Der Mitarbeiter wurde gelöscht!'));
        return redirect(route('profile.index'));
    }
}
