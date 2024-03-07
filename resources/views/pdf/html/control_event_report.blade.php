@extends('layout.layout-htmlpdf')

@section('content')
    <table cellspacing="0"
           cellpadding="0"
    >
        <tr>
            <td></td>
            <td align="right">
                <h1>{{__('Prüfbericht')}} {{ $reportNo }}<br>
                    <span
                            style="font-size: small; margin: 0; padding: 0;"
                    >{{__('Prüfung vom:')}} {{ $controlEvent->control_event_date }}</span>
                </h1>

            </td>
        </tr>
    </table>

    <h2>{{__('Gerät')}}</h2>

    <table style="border-collapse: collapse; margin-top: 20px;"
           cellpadding="0"
           cellspacing="0"
    >
        <tr>
            <th colspan="2"
                style="font-size: small; font-weight: bold;"
            >{{ __('Bezeichnung')}}</th>
        </tr>
        <tr>
            <td colspan="2"
                style="font-size: 14pt;"
            >{{ $equipment->produkt->prod_name }}</td>
        </tr>
        <tr>
            <td colspan="2"><br></td>
        </tr>
        <tr>
            <th style="font-size: small; padding-top:5px; padding-bottom: 5px; font-weight: bold;">{{ __
            ('Inventarnummer')}}</th>
            <th style="font-size: small; padding-top:5px; padding-bottom: 5px; font-weight: bold;">{{ __
            ('Seriennummer')}}</th>
        </tr>
        <tr>
            <td style="font-size: 14px; padding-top:3px;">{{ $equipment->eq_inventar_nr }}</td>
            <td style="font-size: 14px; padding-top:3px;">{{ $equipment->eq_serien_nr }}</td>
        </tr>
    </table>

    <h2>{{__('Vorschrift')}}</h2>
    <span
            style="font-weight: bold; font-size: small;"
    >{{ __('Die Prüfunge erfolgte nach folgender Vorschrift:') }}</span>
    <br>{{ $regulation->vo_label }} {{ $regulation->vo_name }}
    <br><br><span
            style="font-weight: bold; font-size: small;"
    >{{ __('Hierbei wurde folgende Anforderung angewandt:') }}</span>
    <br>{{ $requirement->an_label }} {{ $requirement->an_name }}

    @if($controlEvent->control_event_text)
        <h2>{{__('Bemerkungen')}}</h2>
        <p>{!! nl2br($controlEvent->control_event_text) !!}</p>
    @endif


    <h2>{{ __('Abschluss') }}</h2>
    <p>{{__('Basierend auf den Ergebnissen gilt die Prüfung als')}}
        @if($controlEvent->control_event_pass)
            <strong style="color:#3fb618;">{{  __('bestanden')  }}</strong>
        @else
            <strong style="color:red;">{{ __('nicht bestanden') }}</strong>
        @endif


    </p>
    <p></p>
    <p>{!! __('Die nächste Prüfung wurde auf den <strong>:dueDate</strong> gesetzt.',['dueDate'=>$controlEvent->control_event_next_due_date]) !!}</p>
    <p></p>
    <p></p>
    @if (!$controlStep->aci_execution)
        <table style="border-collapse: collapse; margin-top: 20px;"
               cellpadding="0"
               cellspacing="0"
        >
            <tr>
                <td>@if($controlEvent->control_event_controller_signature)
                        <img src="{{$controlEvent->control_event_controller_signature}}"
                             height="100px"
                             alt="{{__('Unterschrift Prüfer')}} {{ $controlEvent->control_event_controller_name??'-' }}"
                        >
                    @endif

                </td>
                <td>@if ($controlEvent->control_event_supervisor_signature)
                        <img src="{{$controlEvent->control_event_supervisor_signature}}"
                             height="100px"
                             alt="{{__('Unterschrift Leitung')}} {{ $controlEvent->control_event_supervisor_name }}"
                        >
                    @endif
                </td>
            </tr>
            <tr>
                <td><span style="font-size: 9pt;">{{__('Prüfer')}}</span><br>{{
                $controlEvent->control_event_controller_name??'-' }}</td>
                <td><span style="font-size: 9pt;">{{__('Leitung')}}</span><br>{{
                $controlEvent->control_event_supervisor_name??'-' }}</td>
            </tr>
        </table>
    @else
        <table cellspacing="0"
               cellpadding="0"
               style="border-collapse: collapse"
        >
            <tr>
                <td style="width: 50%">
                    <p><span style="font-size: 9pt;">{{ __('Prüfer') }}</span><br>{{
                    $controlEvent->control_event_controller_name }}</p>
                </td>
                <td>
                    @if ($controlEvent->control_event_supervisor_signature)
                        <p><span style="font-size: 9pt;">{{ __('Leitung') }}</span><br>{{
                        $controlEvent->control_event_supervisor_name }}</p>
                    @endif
                </td>
            </tr>
        </table>
    @endif

    {{--    {{ $ControlEquipment->Anforderung->id }}--}}

    @if (App\ControlEventEquipment::where('control_event_id',$controlEvent->id)->count()>0)
        <p style="page-break-before:always; margin:0;"></p>
        <h2>{{__('Prüfmittel')}}</h2>
        <p>{{__('Folgende Prüfmittel wurden verwendet:')}}</p>
        <table style="border-collapse: collapse; margin-top: 20px;"
               cellpadding="0"
               cellspacing="0"
        >
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
                    $conEquip = App\ControlEquipment::where('equipment_id',$coEvEquip->Equipment->id )->first()
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

    @if (!$controlStep->Anforderung->is_external)

        <p style="page-break-before:always; margin:0;"></p>
        <p></p>
        <h2>{{__('Prüfschritte')}}</h2>
        <p>{{ __('Die Anforderung')}} <em>{{  $requirement->an_label }} {{ $requirement->an_name }}</em> {{
        $requirementitems->count() > 1 ? __('umfasst folgende Prüfungen:') : __('umfasst folgende Prüfung:')}}</p>

        @foreach ($requirementitems as $aci)
            @php
                $ceitem =  App\ControlEventItem::withTrashed()->where([['control_item_aci',$aci->id],['control_event_id',$controlEvent->id]])->first()
            @endphp
            @if($ceitem)
                <table style="border-collapse: collapse; margin-bottom: 10px; "
                       cellpadding="0"
                       cellspacing="0"
                       nobr="true"
                >
                    <tr>
                        <td><span style="font-size: 9px; font-weight: bold;">{{ __('Aufgabe / Ziel')
                        }}:</span><br>{!! nl2br($aci->aci_name) !!}<br><br><span style="font-size: 9px; font-weight:
                        bold;">{{ __('Beschreibung der Prüfung') }}:</span><br>{!!  nl2br($aci->aci_task) !!}<br>



                            @if($aci->aci_value_target_mode)
                                <table cellpadding="0"
                                       cellspacing="0"
                                >
                                    <tr>
                                        <td style="font-size: 9px; font-weight: bold;">{{ __('Sollwert') }}</td>
                                        <td style="font-size: 9px; font-weight: bold;">{{ __('Ist') }}</td>
                                        <td style="font-size: 9px; font-weight: bold;">{{ __('Bedingung') }}</td>
                                        <td style="font-size: 9px; font-weight: bold;">{{ __('Ergebnis') }}</td>
                                    </tr>
                                    <tr style="font-size: 11px;">
                                        <td>{{ $aci->aci_vaule_soll??'-' }} {{ $aci->aci_value_si??'' }}</td>
                                        <td>{{ $ceitem->control_item_read??'-' }} {{ $aci->aci_value_si??'' }}</td>
                                        <td>@if ($aci->aci_value_target_mode ==='eq')
                                                @php
                                                    $tol = ($aci->aci_value_tol_mod==='abs')
                                                    ? $aci->aci_value_tol
                                                    : $aci->aci_vaule_soll*$aci->aci_value_tol/100
                                                @endphp
                                                {{__('Soll')}} = {{__('Ist')}}
                                                ±{{ $tol??'' }} {{ $aci->aci_value_si??'' }}
                                            @elseif ($aci->aci_value_target_mode ==='lt')
                                                {{__('Soll')}} < {{__('Ist')}}
                                            @elseif ($aci->aci_value_target_mode ==='gt')
                                                {{__('Soll')}} > {{__('Ist')}}
                                            @else
                                                -
                                            @endif</td>
                                        <td>@if($ceitem->control_item_pass)
                                                <strong style="color:#3fb618;">{{  __('bestanden')  }}</strong>
                                            @else
                                                <strong style="color:red;">{{ __('nicht bestanden') }}</strong>
                                            @endif</td>
                                    </tr>
                                </table>
                            @else
                                <p><span style="font-size: 9px; font-weight: bold;">{{ __('Ergebnis') }}:</span>
                                    <br/>
                                    @if($ceitem->control_item_pass)
                                        <strong style="color:#3fb618;">{{  __('bestanden')  }}</strong>
                                    @else
                                        <strong style="color:red;">{{ __('nicht bestanden') }}</strong>
                                    @endif
                                </p>
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <hr style="height: 1px; background-color: #0a0a0a;">
                        </td>
                    </tr>
                </table>
            @endif
        @endforeach

    @else
        <p>{{ __('Die Prüfung wurde extern durchgeführt.') }}</p>
    @endif

@endsection
