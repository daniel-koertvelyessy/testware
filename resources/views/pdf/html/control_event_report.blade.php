@extends('layout.layout-htmlpdf')

@section('content')

    <h1>{{__('Prüfbericht PR')}}{{ str_pad($controlEvent->id,5,'0',STR_PAD_LEFT) }}</h1>

    <p>{{__('Die Prüfung erfolgte am')}} {{ $controlEvent->control_event_date }}</p>

    <h2>{{__('Gerät')}}</h2>

    @php
        $ControlEquipment = App\ControlEquipment::withTrashed()->where('id',$controlEvent->control_equipment_id)->first();
        $equipment = App\Equipment::find( $ControlEquipment->equipment_id);
        $aci_execution = App\AnforderungControlItem::where('anforderung_id',$ControlEquipment->Anforderung->id)->first()
    @endphp

    <p>{{__('Folgendes Gerät wurde überprüft:')}}</p>
    <dl>
        <dt>{{ __('Bezeichnung')}}</dt>
        <dd style="font-size: 14px;">{{ $equipment->produkt->prod_name }}</dd>
    </dl>
    <dl>
        <dt>{{ __('Inventarnummer')}}</dt>
        <dd style="font-size: 14px;">{{ $equipment->eq_inventar_nr }}</dd>
    </dl>

    <dl>
        <dt>{{ __('Seriennummer')}}</dt>
        <dd style="font-size: 14px;">{{ $equipment->eq_serien_nr }}</dd>
    </dl>

    <h2>{{__('Bemerkungen')}}</h2>
    <p>
        {!! nl2br($controlEvent->control_event_text??'') !!}
    </p>
    <h2>{{ __('Abschluss ')}}</h2>
    <p>Basierend auf den Ergebnissen gilt die Prüfung als <strong>{{ $controlEvent->control_event_pass ? 'bestanden' : 'nicht bestanden' }}</strong></p>
    <p>Die nächste Prüfung wurde auf den <strong>{{ $controlEvent->control_event_next_due_date }}</strong> gesetzt.</p>
    <br>
    <br>
    @if ($aci_execution->aci_execution===0)
        <table>
            <tr>
                <td style="width: 50%">
                    @if($controlEvent->control_event_controller_signature)
                    <img src="{{$controlEvent->control_event_controller_signature}}"
                         width="30%"
                         alt="Unterschrift Prüfer {{ $controlEvent->control_event_controller_name }}"
                    >
                    <br> <br>
                    @endif
                    <p>{{__('Prüfer')}}<br>{{ $controlEvent->control_event_controller_name??'-' }}</p>
                </td>
                <td>
                    @if ($controlEvent->control_event_supervisor_signature)
                        <img src="{{$controlEvent->control_event_supervisor_signature}}"
                             width="30%"
                             alt="Unterschrift Leitung {{ $controlEvent->control_event_supervisor_name }}"
                        >


                        <br>
                        <br>
                        <p>{{__('Leitung')}}<br>{{ $controlEvent->control_event_supervisor_name??'-' }}</p>
                    @endif
                </td>
            </tr>
        </table>
    @else
        <table>
            <tr>
                <td style="width: 50%">
                    <p>{{ __('Prüfer') }}<br>{{ $controlEvent->control_event_controller_name }}</p>
                </td>
                <td>
                    @if ($controlEvent->control_event_supervisor_signature)
                        <p>{{ __('Leitung') }}<br>{{ $controlEvent->control_event_supervisor_name }}</p>
                    @endif
                </td>
            </tr>
        </table>
    @endif

    {{--    {{ $ControlEquipment->Anforderung->id }}--}}

    @if (App\ControlEventEquipment::where('control_event_id',$controlEvent->id)->count()>0)
        <h2>{{__('Prüfmittel')}}</h2>
        <p>{{__('Folgende Prüfmittel wurden verwendet:')}}</p>
        <table>
            <thead>
            <tr>
                <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">{{__('Gerät')}}</th>
                <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">{{__('Seriennummer')}}</th>
                <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">{{__('Letzte Prüfung')}}</th>
                <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">{{__('Nächste Prüfung')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach (App\ControlEventEquipment::where('control_event_id',$controlEvent->id)->get() as $coEvEquip)
                @php
                    $conEquip = App\ControlEquipment::where('equipment_id',$coEvEquip->Equipment->id )->first();
                @endphp
                <tr>
                    <td>{{ $coEvEquip->Equipment->produkt->prod_name }}</td>
                    <td>{{ $coEvEquip->Equipment->eq_serien_nr }}</td>
                    <td>{{ $conEquip->qe_control_date_last  }}</td>
                    <td>{{ $conEquip->qe_control_date_due  }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

    @if ($aci_execution->aci_execution===0)
        <h2 style="page-break-before:always; margin:0;">{{__('Pürfschritte')}}</h2>
        @foreach (App\AnforderungControlItem::where('anforderung_id',$ControlEquipment->anforderung_id)->get() as $aci)

            @php($ceitem =  App\ControlEventItem::withTrashed()->where([['control_item_aci',$aci->id],['control_event_id',$controlEvent->id]])->first())
            <table cellpadding="3"
                   cellspacing="0"
                   border="0"
                   nobr="true"
            >
                <tr>
                    <td>
                        <p>
                        <span style="font-size: 11px; font-weight: bold;">
                            {{ __('Aufgabe / Ziel') }}:
                        </span><br/>
                            {!! nl2br($aci->aci_name) !!}
                        </p>

                        <p>
                        <span style="font-size: 11px; font-weight: bold;">
                            {{ __('Beschreibung der Prüfung') }}:
                        </span><br/>
                            {!!  nl2br($aci->aci_task) !!}
                        </p>

                        <table cellpadding="4">
                            <tr>
                                <td style="font-size: 11px; font-weight: bold;">Soll</td>
                                <td style="font-size: 11px; font-weight: bold;">Ist</td>
                                <td style="font-size: 11px; font-weight: bold;">Ziel</td>
                                <td style="font-size: 11px; font-weight: bold;">Bestanden</td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $aci->aci_vaule_soll??'-' }}
                                </td>
                                <td>
                                    {{ $ceitem->control_item_read??'-' }}
                                </td>
                                <td>
                                    @if ($aci->aci_value_target_mode ==='eq')
                                        Soll = Ist ± Toleranz
                                    @elseif ($aci->aci_value_target_mode ==='lt')
                                        Soll < Ist
                                    @else
                                        Soll > Ist
                                    @endif
                                </td>
                                <td>
                                    {{ $ceitem->control_item_pass?'ja':'nein' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        @endforeach

    @else
        <p>{{ __('Die Prüfung wurde extern durchgeführt.') }}</p>
    @endif

@endsection
