<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentParam;
use App\ProduktKategorieParam;
use App\ProduktParam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ProductParameterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->validateProduktParam();
        $parameter = (new ProduktParam)->makeNewParameter($request);

        $msg = __('Der Parameter <strong>:name</strong> wurde angelegt!',
            ['name' => request('pp_name')]);
        if (isset($request->checkAddParameterToEquipment)) {
            $msg .= $this->updateEquipment($parameter,
                'store');
        }
        $request->session()->flash('status',
            $msg);

        return redirect()->back();
    }

    public function validateProduktParam(): array
    {
        return request()->validate([
            'pp_label' => [
                'bail',
                'required',
                'max:20',
                Rule::unique('produkt_params')->ignore(\request('id')),
            ],
            'pp_value' => 'bail|max:150',
            'pp_name' => 'bail|string|max:150',
            'produkt_id' => 'required',
        ]);
    }

    public function updateEquipment(ProduktParam $parameter, string $method): string
    {
        $countEquipmentUpdated = [];
        foreach (Equipment::select('id')->where('produkt_id',
            $parameter->produkt_id)->get() as $equipment) {
            if ($method === 'store') {
                $countEquipmentUpdated[] = (new EquipmentParam)->storeProductParameter($parameter->toArray(),
                    $equipment->id);
            }
            if ($method === 'delete') {
                $countEquipmentUpdated[] = (new EquipmentParam)->deleteProductParameter(request()->toArray(),
                    $equipment->id);
            }
        }
        $equipmentUpdatedWithParameter = count($countEquipmentUpdated);

        return ($equipmentUpdatedWithParameter > 0) ? __('<br>Es wurden <strong>:counter</strong> Geräte aktualisiert!',
            ['counter' => $equipmentUpdatedWithParameter]) : __('<br>Es wurden keine Geräte aktualisiert');
    }

    public function show($id): Response
    {
        return ProduktKategorieParam::find($id);
    }

    public function getCategogryParam(Request $request): Response
    {
        return ProduktKategorieParam::find($request->id);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->validateProduktParam();
        $ProduktParam = ProduktParam::find($request->id);
        $ProduktParam->pp_label = $request->pp_label;
        $ProduktParam->pp_name = $request->pp_name;
        $ProduktParam->pp_value = $request->pp_value;

        $msg = ($ProduktParam->save()) ? __('Der Parameter <strong>:name</strong> wurde aktualisiert!',
            ['name' => request('pp_name')]) : 'Error!!';
        $request->session()->flash('status',
            $msg);

        if (isset($request->checkUpdateEquipmentToo)) {
            $msg .= $this->updateEquipment($ProduktParam,
                'store');
            $request->session()->flash('status',
                $msg);
        }

        return back();
    }

    public function destroy(int $id): RedirectResponse
    {
        $parameter = ProduktParam::find($id);
        $msg = __('Der Parameter <strong>:name</strong> wurde entfernt!',
            ['name' => $parameter->pp_name]);
        if (request('checkDeleteParamOnEquipment')) {
            $msg .= $this->updateEquipment($parameter,
                'delete');
        }
        request()->session()->flash('status',
            $msg);
        $parameter->delete();

        return back();
    }

    public function getParamData(Request $request): ProduktParam
    {
        return ProduktParam::find($request->id);
    }
}
