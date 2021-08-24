<?php

namespace App\Http\Controllers;

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
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('admin.user.index', ['users' => User::with('roles')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if  (Auth::user()->isSysAdmin()) {
            return view('admin.user.create');
        } else {
            $request->session()->flash('status',__('Sie haben keine Berechtigung Benutzer anzulegen!'));
            return redirect()->route('user.index', ['users' => User::with('roles')->get()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     */
    public function store(Request $request)
    {
//        dd($request);
        (new User)->addNew($request);
        return redirect()->route('user.index', ['users' => User::with('roles')->get()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     *
     * @return Application|RedirectResponse|Response|Redirector
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
     * @return array
     */
    public function validateUser()
    : array
    {
        return request()->validate([
            'email'    => 'bail|email|required',
            'username' => '',
            'name'     => 'required',
            'locale'   => 'required'
            //            'password' => 'required',

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        //
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

    /**
     * @return array
     */
    public function validateNewUser()
    : array
    {
        return request()->validate([
            'email'    => 'bail|email|unique:users,email|required',
            'username' => 'bail|unique:users,username',
            'name'     => 'required',
            'locale'   => 'required'
            //            'password' => 'required',

        ]);
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

}
