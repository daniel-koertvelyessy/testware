<table class="table">
    <thead>
    <tr>
        <th class="px-0">{{ __('Prüfpunkt') }}</th>
        <th>{{ __('Ist') }}</th>
        <th class="text-right">{{ __('Bestanden') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach(\App\AciDataSet::where('anforderung_control_item_id',$aci->id)->orderBy('data_point_sort')->get() as
    $setItem)
        <tr>
        <td class="px-0">
            <span class="form-control">{{ $setItem->data_point_value }}
            {{ $aci->aci_value_si??'' }}
            </span>
        </td>
        <td>
            <label for="dataset_item_read{{ $setItem->id }}"
                   class="sr-only"
            >{{__('Ist-Wert')}}
            </label>
            <input type="text"
                   placeholder="{{__('Wert')}}"
                   class="form-control decimal checkSollValue"
                   id="dataset_item_read{{ $setItem->id }}"
                   name="dataset_item_read[{{ $setItem->id }}][]"
                   data-aci_id="{{ $setItem->id }}"
                   data-aci_vaule_soll="{{ $setItem->data_point_value }}"
                   data-aci_value_target_mode="{{ $setItem->data_point_tol_target_mode??'' }}"
                   data-aci_value_tol="{{ $setItem->data_point_tol??'' }}"
                   data-aci_value_tol_mod="{{ $setItem->data_point_tol_mod??'' }}"
                   required
            >
        </td>
        <td class="text-right">
            <div class="btn-group btn-group-toggle"
                 data-toggle="buttons"
            >
                <label class="btn btn-outline-success">
                    <input type="radio"
                           id="aci_Passed_{{ $setItem->id }}"
                           name="control_item_pass[{{ $setItem->id }}][]"
                           value="1"
                           class="checkControlItem itemPassed"
                    >
                    {{ __('JA')}}
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio"
                           id="aci_notPassed_{{ $setItem->id }}"
                           name="control_item_pass[{{ $setItem->id }}][]"
                           value="0"
                           class="checkControlItem itemFailed"
                    >
                    {{ __('NEIN')}}
                </label>
            </div>
        </td>
        </tr>
    @endforeach
    </tbody>
</table>
