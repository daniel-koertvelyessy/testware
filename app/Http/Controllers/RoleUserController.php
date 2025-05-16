<?php

namespace App\Http\Controllers;

use App\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleUserController extends Controller
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
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     *
     * @return Response
     */
    public function show(RoleUser $roleuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return Response
     */
    public function edit(RoleUser $roleuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return Response
     */
    public function update(Request $request, RoleUser $roleuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return Response
     */
    public function destroy(RoleUser $roleuser)
    {
        dd($roleuser);
    }
}
