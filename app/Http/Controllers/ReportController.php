<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
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
        $reports = Report::with('types')->sortable()->paginate(10);
        return view('reports.index',['reports'=>$reports]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function template()
    {
        return view('reports.template');
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Report $report
     *
     * @return Application|Factory|Response|View
     */
    public function show(Report $report)
    {

     return view('reports.view.'.$report->view);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Report $report
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Report $report)
    {
        return view('reports.edit',['report'=>$report]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Report                   $report
     *
     * @return Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Report  $report
     *
     * @return Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
