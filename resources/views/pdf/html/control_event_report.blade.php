@extends('layout.layout-htmlpdf')

@section('content')

    <h1>Prüfbericht PR{{ str_pad($controlEvent->id,5,'0',STR_PAD_LEFT) }}</h1>


    <p>Die Prüfung erfolgte am {{ $controlEvent->control_event_date }}</p>

    <h2>Gerät</h2>

    @php
        $ControlEquipment = App\ControlEquipment::withTrashed()->where('id',$controlEvent->control_equipment_id)->get();
        $equipment = App\Equipment::find( $ControlEquipment[0]->equipment_id);
    @endphp

    <p>Folgendes Gerät wurde überprüft:</p>
    <dl>
        <dt>{{ __('Bezeichnung')}}</dt>
        <dd style="font-size: 14px;">{{ $equipment->produkt->prod_name_lang }}</dd>
    </dl>
    <dl>
        <dt>{{ __('Inventarnummer')}}</dt>
        <dd style="font-size: 14px;">{{ $equipment->eq_inventar_nr }}</dd>
    </dl>

    <dl>
        <dt>{{ __('Seriennummer')}}</dt>
        <dd style="font-size: 14px;">{{ $equipment->eq_serien_nr }}</dd>
    </dl>

{{--    {{ $ControlEquipment[0]->Anforderung->id }}--}}

    @if (App\ControlEventEquipment::where('control_event_id',$controlEvent->id)->count()>0)


    <h2>Prüfmittel</h2>
    <p>Folgende Prüfmittel wurden verwendet:</p>
    <table>
        <thead>
        <tr>
            <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">Gerät</th>
            <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">Seriennummer</th>
            <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">Letzte Prüfung</th>
            <th style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #777777;">Nächste Prüfung</th>
        </tr>
        </thead>
        <tbody>
        @foreach (App\ControlEventEquipment::where('control_event_id',$controlEvent->id)->get() as $coEvEquip)
            @php
                $conEquip = App\ControlEquipment::where('equipment_id',$coEvEquip->Equipment->id )->get();
            @endphp
            <tr>
                <td>{{ $coEvEquip->Equipment->produkt->prod_name_lang }}</td>
                <td>{{ $coEvEquip->Equipment->eq_serien_nr }}</td>
                <td>{{ $conEquip[0]->qe_control_date_last  }}</td>
                <td>{{ $conEquip[0]->qe_control_date_due  }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @endif
    <h2 style="page-break-before:always; margin:0;">Pürfschritte</h2>
    @foreach (App\AnforderungControlItem::where('anforderung_id',$ControlEquipment[0]->anforderung_id)->get() as $aci)
        @php($ceitem =  App\ControlEventItem::withTrashed()->where([['control_item_aci',$aci->id],['control_event_id',$controlEvent->id]])->get())
        <table cellpadding="3" cellspacing="0" border="0" nobr="true">
            <tr>
                <td>
                    <p>
                        <span style="font-size: 11px; font-weight: bold;">
                            {{ __('Aufgabe / Ziel') }}:
                        </span><br/>
                        {!! nl2br($aci->aci_name_lang) !!}
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
                                {{ $ceitem[0]->control_item_read??'-' }}
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
                                {{ $ceitem[0]->control_item_pass?'ja':'nein' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>




    @endforeach

    <h2>Bemerkungen</h2>
    <p>
        {!! nl2br($controlEvent->control_event_text??'') !!}
    </p>
    <h2>Abschluss</h2>
    <p>Basierend auf den Ergebnissen gilt die Prüfung als <strong>{{ $controlEvent->control_event_pass ? 'bestanden' : 'nicht bestanden' }}</strong></p>
    <p>Die nächste Prüfung wurde auf den <strong>{{ $controlEvent->control_event_next_due_date }}</strong> gesetzt.</p>
    <br>
    <br>
   <table>
       <tr>
           <td style="width: 50%">
               <img src="{{$controlEvent->control_event_controller_signature}}"
                    width="30%"
                    alt="Unterschrift Prüfer {{ $controlEvent->control_event_controller_name }}"
               >
               <br>
               <br>
               <p>Prüfer<br>{{ $controlEvent->control_event_controller_name }}</p>
           </td>
           <td>
               @if ($controlEvent->control_event_supervisor_signature)
                   <img src="{{$controlEvent->control_event_supervisor_signature}}"
                        width="30%"
                        alt="Unterschrift Leitung {{ $controlEvent->control_event_supervisor_name }}"
                   >


               <br>
               <br>
               <p>Leitung<br>{{ $controlEvent->control_event_supervisor_name }}</p>
               @endif
           </td>
       </tr>
   </table>

@endsection
