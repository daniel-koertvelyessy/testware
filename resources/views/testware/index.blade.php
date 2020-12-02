@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Dashboard')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container-fluid">
        <h2 class="h5">{{ __('Status') }}
            <a href="{{ route('equipMain') }}">{{ __('Geräte')}}</a>
        </h2>
        <div class="row">
            @foreach (App\EquipmentState::all() as $equipmentState)
                @php
                    $equipments = App\Equipment::where('equipment_state_id',$equipmentState->id)->get();
                @endphp
                <div class="col-lg-3 col-md-6">
                    <div class="border rounded p-2 mb-3 d-flex justify-content-between align-items-center"
                         style="height: 8em;"
                    >
                        <div class="d-none d-xl-inline-flex"
                             style="display: flex; flex-direction: column;"
                        >
                            <span>{{__('Status')}}: <strong>{{ ucwords($equipmentState->estat_name_kurz) }}</strong></span> <span class="lead mt-2">{{ str_limit($equipmentState->estat_name_lang,60) }}</span>
                        </div>
                        <div class="d-xl-none"
                             style="display: flex; flex-direction: column;"
                        >
                            <span>{{__('Status')}}: <strong>{{ ucwords($equipmentState->estat_name_kurz) }}</strong></span> <span class="lead mt-2">{{ str_limit($equipmentState->estat_name_lang,40) }}</span>
                        </div>
                        @if ($equipmentState->id === 1)
                            <span style="font-size: 3rem;"
                                  class="ml-2 text-{{ ($equipments->count()<1) ? 'warning ' : 'success ' }}"
                            >{{$equipments->count()}}
                        </span>
                        @else
                            <span style="font-size: 3rem;"
                                  class="ml-2 text-{{ ($equipments->count()>0) ? 'warning ' : 'success ' }}"
                            >{{$equipments->count()}}
                        </span>
                        @endif


                    </div>
                </div>
            @endforeach

        </div>
        <div class="row mt-4">
            <x-dashborarditem>
                <h2 class="h5">{{__('Anstehende')}}
                    <a href="{{ route('controlevent.index') }}">{{ __('Prüfungen') }}</a>
                </h2>
                @if (\App\ControlProdukt::count()===0)
                    <div class="m-2 border-warning">
                        <span class="fas fa-exclamation-circle text-warning"></span>
                        Es sind bislang keine Prüfgeräte angelegt!
                    </div>
                @endif
                <nav>
                    <div class="nav nav-tabs"
                         id="nav-tab"
                         role="tablist"
                    >
                        <a class="nav-link active"
                           id="controlWeek-tab"
                           data-toggle="tab"
                           href="#controlWeek"
                           role="tab"
                           aria-controls="controlWeek"
                           aria-selected="true"
                        >4 {{__('Wochen')}}</a>
                        <a class="nav-link"
                           id="controlMonth-tab"
                           data-toggle="tab"
                           href="#controlMonth"
                           role="tab"
                           aria-controls="controlMonth"
                           aria-selected="false"
                        >3 {{__('Monate')}}</a>
                        <a class="nav-link"
                           id="controlYear-tab"
                           data-toggle="tab"
                           href="#controlYear"
                           role="tab"
                           aria-controls="controlYear"
                           aria-selected="false"
                        >{{__('Jahr')}}</a>
                        <a class="nav-link"
                           id="controlAll-tab"
                           data-toggle="tab"
                           href="#controlAll"
                           role="tab"
                           aria-controls="controlAll"
                           aria-selected="false"
                        >{{__('Alle')}}</a>
                    </div>
                </nav>
                <div class="tab-content"
                     id="nav-tabContent"
                >
                    @php
                        $controls = \App\ControlEquipment::take(10);
                    @endphp

                    <div class="tab-pane fade show active"
                         id="controlWeek"
                         role="tabpanel"
                         aria-labelledby="controlWeek-tab"
                    >
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Gerät</th>
                                <th>Anforderung</th>
                                <th>Fällig</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(\App\ControlEquipment::take(10)->where('qe_control_date_due','<=',now()->addWeeks(4))->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                <tr>
                                    <td>
                                        <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_name_kurz }}</a>
                                        <br>
                                        <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                    </td>
                                    <td>{{ $controlEquipment->Anforderung->an_name_lang }}</td>
                                    <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">Keine Prüfungen in den kommenden 4 Wochen fällig</span>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade"
                         id="controlMonth"
                         role="tabpanel"
                         aria-labelledby="controlMonth-tab"
                    >
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Gerät</th>
                                <th>Anforderung</th>
                                <th>Fällig</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(\App\ControlEquipment::take(10)->whereBetween('qe_control_date_due',[now()->addWeeks(4),now()->addMonths(3)])->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                <tr>
                                    <td>
                                        <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_name_kurz }}</a>
                                        <br>
                                        <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                    </td>
                                    <td>{{ $controlEquipment->Anforderung->an_name_lang }}</td>
                                    <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">Keine Prüfungen in diesem Jahr fällig</span>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade"
                         id="controlYear"
                         role="tabpanel"
                         aria-labelledby="controlYear-tab"
                    >
                        <h2 class="h5">{{__('Anstehende Prüfungen') .' '. date('Y')}} </h2>
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Gerät</th>
                                <th>Anforderung</th>
                                <th>Fällig</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(\App\ControlEquipment::take(10)->whereBetween('qe_control_date_due',[now(),date('Y'.'-12-31')])->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                <tr>
                                    <td>
                                        <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_name_kurz }}</a>
                                        <br>
                                        <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                    </td>
                                    <td>{{ $controlEquipment->Anforderung->an_name_lang }}</td>
                                    <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">Keine Prüfungen in diesem Jahr fällig</span>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade"
                         id="controlAll"
                         role="tabpanel"
                         aria-labelledby="controlAll-tab"
                    >
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Gerät</th>
                                <th>Anforderung</th>
                                <th>Fällig</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(\App\ControlEquipment::take(10)->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                <tr>
                                    <td>
                                        <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_name_kurz }}</a>
                                        <br>
                                        <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                    </td>
                                    <td>{{ $controlEquipment->Anforderung->an_name_lang }}</td>
                                    <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">Keine Prüfungen in diesem Jahr fällig</span>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            </x-dashborarditem>

            <x-dashborarditem>
                <h2 class="h5">
                    Offene
                    <a href="{{ route('event.index') }}">{{__('Ereignisse')}}</a>
                </h2>
                @forelse(App\EquipmentEvent::where('read',NULL)->take(10)->latest()->get() as $equipmentEvent)
                    <x-systemmessage
                        link="{{ route('equipment.show', $equipmentEvent->equipment->eq_inventar_nr ) }}"
                        linkText="{{__('zum Gerät')}}"
                        date="{{ $equipmentEvent->created_at }}"
                        subject="{{ $equipmentEvent->equipment->produkt->prod_name_lang }}"
                    >
                        <strong>
                            <a href="{{ route('event.show',$equipmentEvent) }}">Schadensmeldung vom InfoSy App</a>
                        </strong>
                        <p>{{ $equipmentEvent->equipment_event_text }}</p>
                    </x-systemmessage>
                @empty
                    <x-notifyer>Keine ungelesenen Meldungen gefunden!</x-notifyer>
                @endforelse
            </x-dashborarditem>
        </div>

    </div>
@endsection
