<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Firma;
use App\Location;
use App\Profile;
use App\User;
use Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallerController extends Controller
{
    protected array $env_fields = [
        'APP_URL',
        'APP_PORT',
        //        'APP_DEBUG',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {

        $this->checkUserCanUseInstaller($request);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return view('admin.installer.server_data', [
            'env_app' => [
                'APP_URL' => env('APP_URL'),
                'APP_PORT' => env('APP_PORT'),
            ],
            'env_smtp' => [
                'MAIL_HOST' => env('MAIL_HOST'),
                'MAIL_PORT' => env('MAIL_PORT'),
                'MAIL_USERNAME' => env('MAIL_USERNAME'),
                'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
                'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
                'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
                'MAIL_FROM_NAME' => env('MAIL_FROM_NAME')
            ]
        ]);
    }

    public function checkUserCanUseInstaller(Request $request)
    {
        if (!Auth::user()->can('use_installer')) {
            $request->session()->flash('error', __('Sie haben keine Berechtigung für diese Aktion!'));
            return redirect()->route('portal-main');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function company(Request $request)
    {

        $this->checkUserCanUseInstaller($request);
        $company = (Firma::count() > 0) ? Firma::first() : null;
        $address = (Adresse::count() > 0) ? Adresse::first() : null;
        return view('admin.installer.company_data', [
            'company' => $company,
            'address' => $address
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function setCompany(Request $request): RedirectResponse
    {
        $this->checkUserCanUseInstaller($request);

        $company = (isset($request->company_id)) ?
            (new Firma)->updateCompany($request, true) :
            (new Firma)->addCompany($request);

        $address = (isset($request->address_id)) ?
            (new Adresse)->updateAddress($request):
            (new Adresse)->addNew($request, true) ;

        return redirect()->route('installer.location', [
            'company' => $company,
            'address' => $address
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RedirectResponse
     b*/
    public function setAddress(Request $request): RedirectResponse
    {

        $this->checkUserCanUseInstaller($request);

        $address = (isset($request->address_id)) ?
            (new Adresse)->addNew($request, true) :
            (new Adresse)->updateAddress($request);

        $request->session()->flash('status', __('Addressdaten wurden gespreichert'));
        $company = (isset($request->company_id)) ? Firma::find($request->company_id) : null;
        return redirect()->route('installer.company', [
            'company' => $company,
            'address' => $address
        ]);

    }

    /**
     * Display the systems page to set system variables
     *
     * @return Application|Factory|View
     */
    public function system(Request $request)
    {
        $this->checkUserCanUseInstaller($request);
        return view('admin.installer.system_data');

    }


    /**
     * Display the systems page to set system variables
     *
     * @return Application|Factory|View
     */
    public function location(Request $request)
    {
        $this->checkUserCanUseInstaller($request);

        $location = Location::first();

        return view('admin.installer.location_data', compact('location'));

    }

    /**
     * Display the systems page to set system variables
     *
     * @return Application|Factory|View
     */
    public function seed(Request $request)
    {
        $this->checkUserCanUseInstaller($request);

        $company = Firma::find(1);
        $address = Adresse::find(1);

        return view('admin.installer.location_data', compact('company', 'address'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $this->checkUserCanUseInstaller($request);

        if (isset($request->address_id)) {
            $address = Adresse::find($request->address_id);
            $address->update($request->validate([
                'ad_label' => 'bail|required|max:20',
                'address_type_id' => 'required',
                'ad_name' => 'max:100',
                'ad_anschrift_strasse' => 'required|max:100',
                'ad_anschrift_hausnummer' => '',
                'ad_anschrift_ort' => 'required|max:100',
                'ad_anschrift_plz' => 'required|max:100',
                'land_id' => 'required',
                'ad_name_firma' => 'max:100',
            ]));
            $request->session()->flash(__('Die Adresse wurde aktualisiert'));

        } elseif (isset($request->adresse_id)) {
            $request->adresse_id = (new Adresse)->addNew($request);
            $request->session()->flash(__('Die Adresse wurde angeleget'));
        }


        if (isset($request->company_id)) {
            $company = Firma::find($request->company_id);
            $company->update($request->validate([
                'fa_label' => 'required|max:20',
                'fa_name' => 'max:100',
                'fa_description' => '',
                'fa_kreditor_nr' => '',
                'fa_debitor_nr' => '',
                'fa_vat' => 'max:30',
                'adresse_id' => 'integer',
            ]));
            $request->session()->flash(__('Die Firma wurde aktualisiert'));
        } elseif (isset($request->fa_label)) {
            (new Firma)->addCompany($request);
            $request->session()->flash(__('Die Firma wurde angeleget'));
        }

        return view('admin.installer.user_data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkUserCanUseInstaller($request);

        return back();
    }

    public function getUserData(Request $request): array
    {

        $data['user'] = User::find($request->id);
        $data['profile'] = Profile::where('user_id', $request->id)->first();
        return $data;
    }

    public function addUserData(Request $request)
    {
        /**
         * Check if user_id was submitted. If so update given User
         */
        if (isset($request->user_id)) {
            $user = User::find($request->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->role_id = $request->role_id;
            $user->user_theme = 'css/tbs.css';
            $user->save();
            $data['user_id'] = $user->id;

        } else {
            $data['user_id'] = (new User)->addNew($request);
            $user = User::find($data['user_id']);
        }
        $request->user_id = $user->id;
        /**
         * Check if profile_id was submitted. If so update given User
         */
        if (isset($request->profile_id)) {
            $employee = Profile::find($request->profile_id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->username = $request->username;
            $employee->role_id = $request->role_id;
            $employee->user_id = $user->id;
            $employee->save();
            $data['employee_id'] = $employee->id;
        } else {
            $data['employee_id'] = (new Profile)->addNew($request);
        }


        /**
         * make new table row for userList
         */
        $data['html'] = '
<tr id="userListItem' . $data['user_id'] . '">
    <td>' . $request->username . '</td>
    <td>';
        foreach ($user->roles as $role) {
            $data['html'] .= $role->name;
        }
        $data['html'] .= '</td>
    <td>';
        $data['html'] .= ($user->profile) ? '<span class="fas fa-check"></span>' : '';
        $data['html'] .= '</td>
    <td>';
        $data['html'] .= ($user->role_id === 1) ? '<span class="fas fa-check"></span>' : '';
        $data['html'] .= ' </td>
    <td>
        <button type="button"
                class="btn btn-sm btn-outline-secondary btnEditUser"
                data-userid="' . $data['user_id'] . '"
        ><span class="fas fa-edit"></span></button>
        <button type="button"
                class="btn btn-sm btn-outline-secondary btnRemoveUser"
                data-userid="' . $data['user_id'] . '"
        ><span class="far fa-trash-alt"></span></button>
    </td>
</tr>
';

        return $data;
    }

    public function deleteUserData(Request $request)
    {
        $data['user'] = User::find($request->id)->delete();
        $data['employee'] = Profile::where('user_id', $request->id)->delete();
        return $data;
    }

    /**
     * @param Request $request
     *
     * @return false|string
     */
    public function checkEmail(Request $request)
    {
        return json_encode(User::where('email', $request->email)->count() > 0);
    }

    /**
     * @param Request $request
     *
     * @return false|string
     */
    public function checkUserName(Request $request)
    {
        return json_encode(User::where('username', $request->username)->count() > 0);
    }

    /**
     * @param Request $request
     *
     * @return false|string
     */
    public function checkName(Request $request)
    {
        return json_encode(User::where('name', $request->name)->count() > 0);
    }

    public function setAppUrl(Request $request): RedirectResponse
    {
        foreach ($this->env_fields as $field) {
            (new DotEnvController)->changeenv('.env', $field, request($field));
            (new DotEnvController)->changeenv('app.env', $field, request($field));
        }

        return back();
    }

}
