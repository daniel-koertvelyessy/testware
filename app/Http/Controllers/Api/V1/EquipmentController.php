<?php

namespace App\Http\Controllers\Api\V1;

use App\ControlEquipment;
use App\Equipment;
use App\Http\Controllers\Controller;
use App\Http\Resources\equipment\Equipment as EquipmentResource;
use App\Http\Resources\equipment\EquipmentShow as EquipmentShowResource;
use App\Http\Resources\equipment\EquipmentStats as EquipmentStatsResource;
use App\Http\Resources\equipment\TestEquipment as TestEquipmentResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return EquipmentResource::collection(Equipment::with('EquipmentState'))->paginate($request->input('per_page'));
        }

        return EquipmentResource::collection(Equipment::with('EquipmentState')->get());
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
     * @return EquipmentShowResource
     */
    public function show(Equipment $equipment)
    {
        return new EquipmentShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return response()->json([
            'status' => 'eqipment deleted',
        ]);
    }

    public function status()
    {
        return EquipmentStatsResource::collection(
            Equipment::with(['EquipmentState', 'ControlEquipment'])->get()
        );
    }

    public function testEquipment()
    {
        return TestEquipmentResource::collection(Equipment::with('EquipmentState')->get()->filter(function ($equipment) {
            if ($equipment->produkt->ControlProdukt) {
                return $equipment;
            }
        })
        );


    }

    public function summary(): JsonResponse
    {
        $all = Equipment::with(['EquipmentState', 'ControlEquipment'])
                        ->whereNull('deleted_at')
                        ->get();

        $total = $all->count();

        // Noch nie geprüft: keine einzige abgeschlossene (soft-deleted) ControlEquipment-Zeile
        $unchecked = $all->filter(function ($e) {
            $completed = ControlEquipment::withTrashed()
                                         ->where('equipment_id', $e->id)
                                         ->whereNotNull('deleted_at')
                                         ->count();
            return $completed === 0;
        })->count();

        // Offene (nicht abgeschlossene) Prüfungen mit überschrittenem Fälligkeitsdatum
        $overdue = $all->filter(function ($e) {
            return $e->ControlEquipment // nur aktive, nicht soft-deleted
            ->contains(fn($ce) =>
            \Carbon\Carbon::parse($ce->qe_control_date_due)->isPast()
            );
        })->count();

        // Kalibrierungspflichtig: hat mind. eine aktive ControlEquipment-Zeile
        $calibTotal = $all->filter(fn($e) =>
        $e->ControlEquipment->isNotEmpty()
        )->count();

        // Kalibrierung überfällig
        $calibDue = $all->filter(fn($e) =>
        $e->ControlEquipment->contains(fn($ce) =>
        \Carbon\Carbon::parse($ce->qe_control_date_due)->isPast()
        )
        )->count();

        return response()->json([
            'total'       => $total,
            'overdue'     => $overdue,
            'unchecked'   => $unchecked,
            'calib_total' => $calibTotal,
            'calib_due'   => $calibDue,
        ]);
    }
}
