<?php

namespace App\Http\Controllers;

use App\ControlEquipment;
use App\Jobs\CheckEquipmentTestDueDates;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TestwareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(): View
    {
        $maxListItems = 15;
        $now = now();

        // Fetch everything once
        $equipmentTestList = ControlEquipment::join('anforderungs', 'anforderung_id', '=', 'anforderungs.id')
            ->with(['Equipment', 'Anforderung'])
            ->whereNull('control_equipment.archived_at')
            ->where('anforderungs.is_initial_test', false)
            ->where('qe_control_date_due', '<=', $now->copy()->endOfYear())
            ->orderBy('qe_control_date_due')
            ->get();

        // Filter in-memory (no new queries!)
        $equipmentTestWeekList = $equipmentTestList->filter(
            fn ($item) => $item->qe_control_date_due <= $now->copy()->addWeeks(4)
        );

        $equipmentTestMonthList = $equipmentTestList->filter(
            fn ($item) => $item->qe_control_date_due > $now->copy()->addWeeks(4) &&
                $item->qe_control_date_due <= $now->copy()->addMonths(4)
        );

        $equipmentTestYearList = $equipmentTestList->filter(
            fn ($item) => $item->qe_control_date_due > $now->copy()->addMonths(4) &&
                $item->qe_control_date_due <= $now->copy()->endOfYear()
        );

        $initialiseApp = User::count() === 1 && Auth::user()?->name === 'testware';

        return view('dashboard', compact(
            'initialiseApp',
            'maxListItems',
            'equipmentTestWeekList',
            'equipmentTestMonthList',
            'equipmentTestYearList',
            'equipmentTestList'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //        CheckEquipmentTestDueDates::dispatchSync();
        $initialiseApp = (User::count() === 1 && Auth::user()->name === 'testware');

        return view('dashboard', compact('initialiseApp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('dashboard');
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
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
