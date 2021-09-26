<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use App\EquipmentInstruction;
use App\EquipmentQualifiedUser;
use App\ProductInstructedUser;
use App\ProductQualifiedUser;
use App\Profile;
use App\Role;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        /*
        ** if a restoring of deleted useres is prefered exchange this section with the simple return
        if (Auth::user()->isSysAdmin()) {
            $userList = User::with('roles')->withTrashed()->sortable()->paginate(15);
        } else {
            $userList = User::with('roles')->sortable()->paginate(15);
        }*/
        return view('admin.user.index', ['userList' => User::with('roles')->sortable()->paginate(15)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function ldap()
    {
        return view('admin.user.ldap', ['users' => User::with('roles')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (Auth::user()->isSysAdmin()) {
            return view('admin.user.create');
        } else {
            $request->session()->flash('status', __('Sie haben keine Berechtigung Benutzer anzulegen!'));
            return redirect()->route('user.index', ['users' => User::with('roles')->get()]);
        }
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
        $this->validateUser();
        (new User)->addNew($request);
        return redirect()->route('user.index', ['users' => User::with('roles')->get()]);

    }

    /**
     * @return array
     */
    private function validateUser()
    : array
    {
        return request()->validate([
            'username'          => [
                'bail',
                'required',
                'max:100',
                Rule::unique('users')->ignore(\request('id'))
            ],
            'email'             => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore(\request('id'))
            ],
            'email_verified_at' => '',
            'password'          => 'required',
            'api_token'         => 'nullable',
            'name'              => 'nullable',
            'role_id'           => ''
        ], [
            'username.required' => __('Ihr Anzeigename ist notwendig'),
            'username.unique'   => __('Der Anzeigename ist bereits vergeben'),
            'email.required'    => __('Die E-Mail Adress ist notwendig!'),
            'email.unique'      => __('Die E-Mail Adress ist bereits in Benutzung'),
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  User $user
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('admin.user.show', [
            'user'  => $user,
            'roles' => $user->roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  User    $user
     *
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user->update($this->validateUser());
        $request->session()->flash('status', __('Ihr Konto wurde aktualisiert!'));
        return redirect()->back();
    }

    /**
     * Update user from systems view.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatedata(Request $request): RedirectResponse
    {
        $msg = ((new User)->updateData($request)) ?
            __('Ihr Konto wurde aktualisiert!') :
            __('Fehler!') ;

        $request->session()->flash('status', $msg);
        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    : RedirectResponse
    {
        $user_id = $request->id;
//        Profile::where('user_id',$user_id)->delete();

        AnforderungControlItem::where('aci_contact_id',$user_id)->delete();
        ProductInstructedUser::where('product_instruction_trainee_id',$user_id)->delete();
        ProductQualifiedUser::where('user_id',$user_id)->delete();
        EquipmentInstruction::where('equipment_instruction_trainee_id',$user_id)->delete();
        EquipmentQualifiedUser::where('user_id',$user_id)->delete();



        if (User::find($user_id)->delete()) {
            request()->session()->flash('status', __('Der Benutzer wurde gelöscht!'));
        }
        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $user
     *
     * @return RedirectResponse
     */
    public function restore(int $id)
    : RedirectResponse
    {
        if (Auth::user()->isSysAdmin()) {
            $user = User::withTrashed()->where('id', $id)->first();
            if ($user->restore()) {
                request()->session()->flash('status', __('Der Benutzer wurde wiederhergestellt!'));
                return redirect()->route('user.show', $user);
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function revokerole(Request $request)
    : RedirectResponse
    {
        $this->authorize('isAdmin', Auth()->user());
        User::find($request->user_id)->roles()->detach($request->role_id);
        return back();
    }

    /**
     * Add Role to user
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function grantrole(Request $request)
    : RedirectResponse
    {
        $this->authorize('isAdmin', Auth()->user());
        User::find($request->user_id)->roles()->sync($request->roleuser);
        return back();
    }

    /**
     * Revoke user as SysAdmin
     *
     * @param  User $user
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function revokeSysAdmin(User $user)
    : RedirectResponse
    {
        $this->authorize('isAdmin', Auth()->user());
        $user->role_id = 0;
        $user->update();
        return back();
    }

    /**
     * Revoke user as SysAdmin
     *
     * @param  User $user
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function grantSysAdmin(User $user)
    : RedirectResponse
    {
        $this->authorize('isAdmin', Auth()->user());
        $user->role_id = 1;
        $user->update();
        return back();
    }

    public function addTokenToUser(User $user)
    : RedirectResponse
    {
        $user->api_token = Str::random(80);
        $user->save();
        session()->flash('status', __('Ein Token wurde erfolgreich zugewiesen!'));
        return redirect()->back();
    }

    public function resetPassword(Request $request)
    {
        if (isset($request->newPassword) && $request->confirmPassword === $request->newPassword) {
            (new User)->updatePassword($request->newPassword, Auth::user());
            session()->flash('status', __('Passwort wurde aktualisiert!'));
        }
        return back();
    }

    public function setMsgRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }

    public function checkUserEmailAddressExists(Request $request)
    : array
    {
        return ['exists' => User::where('email', $request->term)->count() > 0];
    }

    public function checkUserUserNameExists(Request $request)
    : array
    {
        return ['exists' => User::where('username', $request->term)->count() > 0];
    }
}
