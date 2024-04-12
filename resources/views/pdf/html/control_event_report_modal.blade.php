@extends('layout.layout-htmlpdf')

@section('content')

    <h2 class="my-4">{{ __('Übersicht') }}</h2>

    <h3>{{__('Gerät')}}</h3>

    <dl class="row">
        <dt class="col-sm-3">{{ __('Bezeichnung')}}</dt>
        <dd class="col-sm-9">{{ $equipment->produkt->prod_name }}</dd>

        <dt class="col-sm-3">{{ __('Inventarnummer')}}</dt>
        <dd class="col-sm-9">{{ $equipment->eq_inventar_nr }}</dd>

        <dt class="col-sm-3">{{ __('Seriennummer')}}</dt>
        <dd class="col-sm-9">{{ $equipment->eq_serien_nr }}</dd>

    </dl>

    <h3>{{__('Vorschrift')}}</h3>
    <dl class="row">
        <dt class="col-sm-5">{{ __('Die Prüfunge erfolgte nach Vorschrift:')}}</dt>
        <dd class="col-sm-7">{{ $regulation->vo_label }} {{ $regulation->vo_name }}</dd>

        <dt class="col-sm-5">{{ __('Hierbei wurde Anforderung angewandt:')}}</dt>
        <dd class="col-sm-7">{{ $requirement->an_label }} {{ $requirement->an_name }}</dd>
    </dl>


    @if($controlEvent->control_event_text)
        <h2>{{__('Bemerkungen')}}</h2>
        <p>{!! nl2br($controlEvent->control_event_text) !!}</p>
    @endif

    <article class="row">
        <section class="col">
            <h2>{{ __('Abschluss') }}</h2>
            <p>{{__('Basierend auf den Ergebnissen gilt die Prüfung als')}}
                @if($controlEvent->control_event_pass)
                    <span class="text-success bold"><strong>{{ __('bestanden') }}</strong></span>
                @else
                    <span class="text-danger bold"><strong>{{ __('nicht bestanden') }}</strong></span>
                @endif
            </p>
            <p>{!! __('Die nächste Prüfung wurde auf den <strong>:dueDate</strong> gesetzt.',['dueDate'=>$controlEvent->control_event_next_due_date]) !!}</p>
        </section>
    </article>

    @if (!$aci_execution->Anforderung->is_external)

        <div class="row">
            <div class="col-md-6">
                <figure>
                    @if($controlEvent->control_event_controller_signature)
                        <img src="{{$controlEvent->control_event_controller_signature}}"
                             class="img-fluid"
                             alt="{{__('Unterschrift Prüfer')}} {{ $controlEvent->control_event_controller_name??'-' }}"
                        >
                    @endif
                    <figcaption>
                        {{__('Prüfer')}}<br>{{ $controlEvent->control_event_controller_name??'-' }}
                    </figcaption>
                </figure>
            </div>
            <div class="col-md-6">
                @if ($controlEvent->control_event_supervisor_signature)
                    <figure>
                        <img src="{{$controlEvent->control_event_supervisor_signature}}"
                             class="img-fluid"
                             alt="{{__('Unterschrift Leitung')}} {{ $controlEvent->control_event_supervisor_name }}"
                        >

                        <figcaption>
                            {{__('Leitung')}}<br>{{ $controlEvent->control_event_supervisor_name??'-' }}
                        </figcaption>
                    </figure>
                @endif
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-md-6">
                <p>{{ __('Prüfer') }}<br>{{ $controlEvent->control_event_controller_name }}</p>
            </div>
            <div class="col-md-6">
                @if ($controlEvent->control_event_supervisor_signature)
                    <p>{{ __('Leitung') }}<br>{{ $controlEvent->control_event_supervisor_name }}</p>
                @endif
            </div>
        </div>

    @endif

    {{--    {{ $ControlEquipment->Anforderung->id }}--}}

    @if (App\ControlEventEquipment::where('control_event_id',$controlEvent->id)->count()>0)
        <article class="row">
            <section class="col">
                <h2>{{__('Prüfmittel')}}</h2>
                <p>{{__('Folgende Prüfmittel wurden verwendet:')}}</p>


                <table class="table">
                    <thead>
                    <tr>
                        <th>{{__('Gerät')}}</th>
                        <th>{{__('Seriennummer')}}</th>
                        <th>{{__('Letzte Prüfung')}}</th>
                        <th>{{__('Nächste Prüfung')}}</th>
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
            </section>
        </article>
    @endif



    @if (!$requirement->is_external)
        <h2 class="my-6">{{__('Prüfschritte')}}</h2>
        <p class="mb-3">{{ __('Die Anforderung')}} {{  $requirement->an_label }} {{ $requirement->an_name }} {{ $requirementitems->count() > 1 ?__('umfasst folgende Prüfungen:') : __('umfasst folgende Prüfung:')}}</p>

        @foreach ($requirementitems as $aci)

            @php
                $ceitem =  App\ControlEventItem::withTrashed()->where([['control_item_aci',$aci->id],['control_event_id',$controlEvent->id]])->first()
            @endphp
            @if($ceitem)

                <dl class="row">
                    <dt class="col-md-4">{{ __('Aufgabe / Ziel:')}}</dt>
                    <dd class="col-sm-8 lead">{!! nl2br($aci->aci_name) !!}</dd>

                    <dt class="col-md-4">{{ __('Beschreibung der Prüfung:')}}</dt>
                    <dd class="col-sm-8">{!!  nl2br($aci->aci_task) !!}</dd>
                    <dt class="col-md-4">{{ __('Ergebnis:')}}</dt>
                    <dd class="col-sm-8">
                        @if($aci->aci_value_target_mode && $aci->aci_value_target_mode !== 'dp')
                            <table class="table-sm table-responsive">
                                <tr>
                                    <th>{{ __('Sollwert') }}</th>
                                    <th>{{ __('Ist') }}</th>
                                    <th>{{ __('Bedingung') }}</th>
                                    <th>{{ __('Ergebnis') }}</th>
                                </tr>
                                <tr>
                                    <td>{{ $aci->aci_vaule_soll??'-' }} {{ $aci->aci_value_si??'' }}
                                    </td>
                                    <td>{{ $ceitem->control_item_read??'-' }} {{ $aci->aci_value_si??'' }}
                                    </td>
                                    <td>{{ $aci->makeTolString() }}</td>
                                    <td>
                                        @if($ceitem->control_item_pass)
                                            <span
                                                class="text-success bold"><strong>{{ __('bestanden') }}</strong></span>
                                        @else
                                            <span class="text-danger bold"><strong>{{ __('nicht bestanden') }}</strong></span>

                                        @endif
                                    </td>
                                </tr>
                            </table>

                            @elseif($aci->aci_value_target_mode === 'dp')
                            <table class="table">
                                <tr>
                                    <th style="font-weight: bold;text-align: right;">{{ __('Sollwert') }}</th>
                                    <th style="font-weight: bold;text-align: right;">{{ __('Ist') }}</th>
                                    <th style="font-weight: bold;text-align: right;">{{ __('Abweichung') }}</th>
                                    <th style="font-weight: bold;text-align: right;">{{ __('Tol') }}</th>
                                    <th style="font-weight: bold; text-align: right;">{{ __('Result') }}</th>
                                </tr>
                                @foreach(\App\ControlEventDataset::where('control_event_item_id',$ceitem->id)->orderBy('id')->get() as
                                $datasetItem )
                                    <tr>
                                        <td style="text-align: right;">{{
                                            $datasetItem->valueString($datasetItem->AciDataSet->data_point_value)
                                            }}</td>
                                        <td style="text-align: right;">{{ $datasetItem->valueString($datasetItem->control_event_dataset_read)
                                            }}</td>
                                        <td style="text-align: right;">{{ $datasetItem->valueString
                                            ($datasetItem->AciDataSet->data_point_value - $datasetItem->control_event_dataset_read)
                                            }}</td>
                                        <td style="text-align: right;">{{ $datasetItem->AciDataSet->makeTolString()
                                            }}</td>
                                        <td style="text-align: right;">@if($datasetItem->control_event_dataset_pass)
                                                <span style="color:#3fb618;">{{ __('bestanden') }}</span>
                                            @else
                                                <span style="color:red;">{{__('nicht bestanden')}}</span>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                            </table>
                            @if($ceitem->control_item_pass)
                                <span class="text-success bold"><strong>{{ __('bestanden') }}</strong></span>
                            @else
                                <span class="text-danger bold"><strong>{{ __('nicht bestanden') }}</strong></span>

                            @endif

                        @else
                            @if($ceitem->control_item_pass)
                                <span class="text-success bold"><strong>{{ __('bestanden') }}</strong></span>
                            @else
                                <span class="text-danger bold"><strong>{{ __('nicht bestanden') }}</strong></span>

                            @endif
                        @endif</dd>


                </dl>

            @endif
            {!! $loop->last ? '' : '<hr>' !!}
        @endforeach

    @else
        <p>{{ __('Die Prüfung wurde extern durchgeführt.') }}</p>
    @endif

@endsection
