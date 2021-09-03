@extends('layout.layout-htmlpdf')

@section('content')

    @php
        $equipment = App\Equipment::find($equipment_id);
        @endphp


    <h1>{{__('Geräteübersicht')}}</h1>

    <p style="font-size: 9pt;">{{__('Bezeichnung')}}<br>
    <span style="font-size: 16pt;">{{ $equipment->produkt->prod_name }}</span>
    </p>

    <p style="font-size: 9pt;">{{__('Standort')}}<br>
        <span style="font-size: 16pt;">{{ App\Storage::getLocationPath($equipment->storage_id) }} </span>
    </p>

    <p style="font-size: 9pt;">{{__('Inventarnummer')}}<br>
        <span style="font-size: 16pt;">{{ $equipment->eq_inventar_nr }}</span>
    </p>

    <p style="font-size: 9pt;">{{__('Inbetriebnahme am')}}<br>
        <span style="font-size: 16pt;">{{ $equipment->installed_at }}</span>
    </p>

    <p style="font-size: 9pt;">{{__('Seriennummer')}}<br>
        <span style="font-size: 16pt;">{{ $equipment->eq_serien_nr ?? '-' }}</span>
    </p>

    <p style="font-size: 9pt;">{{__('Hersteller')}}<br>
        <span style="font-size: 16pt;">
            @forelse ($equipment->produkt->firma as $firma) {{ $firma->fa_name }} @empty - @endforelse
        </span>
    </p>


    <h1>{{__('Vorgänge')}}</h1>
    <table cellpadding="3">
        <thead>
        <tr>
            <th style="border-bottom: 1px solid #c7d301; font-weight: bolder; font-size: 10pt;">{{__('letzte')}}</th>
            <th style="border-bottom: 1px solid #c7d301; font-weight: bolder; font-size: 10pt;">{{__('fällig')}}</th>
            <th style="border-bottom: 1px solid #c7d301; font-weight: bolder; font-size: 10pt;">{{__('Vorlaufzeit')}}</th>
            <th style="border-bottom: 1px solid #c7d301; font-weight: bolder; font-size: 10pt;">{{__('Vorgänge')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse (App\ControlEquipment::where('equipment_id',$equipment_id)->get() as $controlEquipment)
            <tr>
                <td style="border-bottom: 1px solid #999;">{{ $controlEquipment->qe_control_date_last }}
                </td>
                <td style="border-bottom: 1px solid #999;">{{ $controlEquipment->qe_control_date_due }}
                </td>
                <td style="border-bottom: 1px solid #999;">{{ $controlEquipment->qe_control_date_warn }} {{__('Wochen')}}
                </td>
                <td style="border-bottom: 1px solid #999;">{{ $controlEquipment->Anforderung->AnforderungControlItem[0]->aci_name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="font-size: 9pt;">
                        {{ __('Keine Daten zum Gerät gefunden') }}
                </td>
            </tr>
        @endforelse


        </tbody>
    </table>



@endsection
