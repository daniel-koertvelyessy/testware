<?php

namespace App\Http\Controllers;

use App\Role;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
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
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        Gate::allows('isSysAdmin');
        (new Role)->addNew($request);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     *
     * @return Role
     */
    public function show(Role $role)
    : Role
    {
        Gate::allows('isSysAdmin');
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     *
     * @return Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request   $request
     * @param  Role $role
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role)
    : RedirectResponse
    {
        Gate::allows('isSysAdmin');
        $role->update($request->validate([
            'label'=>'',
            'name'=>'',
            'is_super_user'=>'',
        ]));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Role $role)
    : RedirectResponse
    {
        Gate::allows('isSysAdmin');
        $role->delete();
        return back();
    }
}
