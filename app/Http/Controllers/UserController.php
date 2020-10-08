<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function show(User $user)
    {
        return view('admin.user.show',['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
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
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {



        $user->update($this->validateUser());
        $request->session()->flash('status', 'Dein Konto wurde aktualisiert!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @return array
     */
    public function validateUser(): array
    {
        return request()->validate([
            'email' => 'bail|email|required',
            'username' => '',
            'name' => 'required',
            'locale' => 'required'
//            'password' => 'required',

        ]);
    }

    /**
     * @return array
     */
    public function validateNewUser(): array
    {
        return request()->validate([
            'email' => 'bail|email|unique:users,email|required',
            'username' => 'bail|unique:users,username',
            'name' => 'required',
            'locale' => 'required'
            //            'password' => 'required',

        ]);
    }

    public function resetPassword(Request $request) {
        $ops = password_hash($request->pswd, PASSWORD_DEFAULT);
        $user = User::find($request->id);
    }

}
