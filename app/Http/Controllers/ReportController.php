<?php

namespace App\Http\Controllers;

use App\Report;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
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

        return view('reports.index', ['reports' => $reports]);
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
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *L
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        Report::create($request->validate([
            'label' => 'required',
            'name' => '',
            'report_type_id' => '',
            'description' => '',
        ]));
        $request->session()->flash('status', __('Der Bericht <strong>:label</strong> wurde angelegt!', ['label' => request('l_label')]));

        return redirect()->route('report.index', ['reports' => Report::with('types')->sortable()->paginate(10)]);
    }

    /**
     * Display the specified resource.
     *
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
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Report $report)
    {
        return view('reports.edit', ['report' => $report]);
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Report $report)
    {
        $report->update($this->validateReportData());
        $request->session()->flash('status', __('Der Bericht <strong>:label</strong> wurde aktualisiert!', ['label' => $request->label]));

        return redirect()->route('report.index', ['reports' => Report::with('types')->sortable()->paginate(10)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Report $report, Request $request): RedirectResponse
    {
        $report->delete();
        $request->session()->flash('status', 'Der Bericht wurde gelöscht!');

        return redirect()->back();
    }

    public function validateReportData()
    {
        return request()->validate([
            'id' => 'nullable|required',
            'label' => 'required',
            'name' => '',
            'report_type_id' => '',
            'description' => '',
        ]);
    }
}
