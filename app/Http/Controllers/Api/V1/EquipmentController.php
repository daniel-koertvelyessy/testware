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
use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json(['message' => 'Not implemented']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Equipment  $equipment
     * @return EquipmentShowResource
     */
    public function show(Equipment $equipment)
    {
        return new EquipmentShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Equipment  $equipment
     * @return JsonResponse
     */
    public function update(Request $request, Equipment $equipment)
    {
        return response()->json(['message' => 'Not implemented']);
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
            return '';
        })
        );


    }

    public function summary(): JsonResponse
    {
        $all = Equipment::with(['EquipmentState', 'ControlEquipment', 'produkt.ControlProdukt'])
                        ->whereNull('deleted_at')
                        ->get();

        $total = $all->count();

        // Keine einzige ControlEquipment-Zeile (weder offen noch abgeschlossen)
        $noTestAssigned = $all->filter(fn($e) =>
            ControlEquipment::withTrashed()
                            ->where('equipment_id', $e->id)
                            ->count() === 0
        )->count();

        // Noch nie geprüft: nur abgeschlossene (deleted_at gesetzt) fehlen,
        // aber offene existieren
        $unchecked = $all->filter(function ($e) {
            $completed = ControlEquipment::withTrashed()
                                         ->where('equipment_id', $e->id)
                                         ->whereNotNull('deleted_at')
                                         ->count();
            $open = ControlEquipment::withTrashed()
                                    ->where('equipment_id', $e->id)
                                    ->whereNull('deleted_at')
                                    ->count();
            return $completed === 0 && $open > 0;
        })->count();

        // Offene Prüfung mit überschrittenem Fälligkeitsdatum
        $overdue = $all->filter(fn($e) =>
        $e->ControlEquipment // nur aktive (deleted_at = null)
        ->contains(fn($ce) =>
        \Carbon\Carbon::parse($ce->qe_control_date_due)->isPast()
        )
        )->count();

        // Nur Prüfprodukte (ControlProdukt) sind kalibrierungspflichtig
        $calibEquipment = $all->filter(fn($e) => $e->produkt->ControlProdukt);

        $calibTotal = $calibEquipment->count();

        $calibDue = $calibEquipment->filter(fn($e) =>
        $e->ControlEquipment->contains(fn($ce) =>
        \Carbon\Carbon::parse($ce->qe_control_date_due)->isPast()
        )
        )->count();

        return response()->json([
            'total'            => $total,
            'no_test_assigned' => $noTestAssigned,
            'unchecked'        => $unchecked,
            'overdue'          => $overdue,
            'calib_total'      => $calibTotal,
            'calib_due'        => $calibDue,
        ]);
    }
}
