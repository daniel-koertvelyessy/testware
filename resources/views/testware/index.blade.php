@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Dashboard')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('mainSection', __('testWare'))

@section('modals')
    <x-modals.form_modal
        title="Übersicht Prüfungen"
        modalId="modalShowTestingList"
        btnSubmit=""
        btnClose="ok"
        modalSize="lg"
    />
@endsection

@section('content')
    @if($initialiseApp)

        <div class="alert alert-info alert-dismissible fade show my-4 w-75 ml-auto mr-auto"
             role="alert"
        >
            <h2 class="h5">Initialisierung</h2>
            <p>Sie sind noch als <span class="badge badge-dark">testware</span> Benutzer angemeldet.</p>
            <p>Ergänzen Sie Ihre Firmierung und Benutzerdaten. Dies können Sie entweder über die jeweilgen Seiten vornehmen oder einfach den Installer aufrufen.</p>
            <a href="{{ route('installer.company') }}"
               class="btn btn-outline-primary"
            >Installation abschließen
            </a>

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container-fluid">
        <h2 class="h5">
            <a href="{{ route('equipMain') }}">{{ __('Geräte')}}</a>
            <br> <span class="small">
                {{ __('Anzahl') }}: <span class="badge badge-info">{{ App\Equipment::all()->count() }}</span>
            </span>
        </h2>
        <div class="row">
            @foreach (App\EquipmentState::all() as $equipmentState)
                @php
                    $equipments = App\Equipment::where('equipment_state_id',$equipmentState->id)->get()
                @endphp
                <div class="col-lg-3 col-md-6">
                    <div class="border rounded p-2 mb-3 d-flex justify-content-between align-items-center"
                         style="height: 8em;"
                    >
                        <div class="d-none d-lg-inline-flex align-items-center"
                             style="display: flex; flex-direction: column;"
                        >
                            <span>{{__('Status')}}: <strong>{{ ucwords($equipmentState->estat_label) }}</strong>
                            </span>
                            <span class="mt-2 display-4 text-{{ $equipmentState->estat_color }}"><i class="{{ $equipmentState->estat_icon }}"></i></span>
                        </div>
                        <div class="d-lg-none"
                             style="display: flex; flex-direction: column;"
                        >
                            <span>{{__('Status')}}: <strong>{{ ucwords($equipmentState->estat_label) }}</strong></span> <span class="lead mt-2">{{ str_limit($equipmentState->estat_name,40) }}</span>
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
                <h2 class="h5">
                    <a href="{{ route('control.index') }}">{{ __('Prüfungen') }}</a>
                </h2>
                {{-- <div id="testcalender">
                     <x-testcalendar setdate="{{ date('Y-m-d') }}"/>
                 </div>
                --}}
                 {{--                <x-testcalendar setdate="{{ date('Y-m-d') }}" />--}}

                      <nav>
                          <div class="nav nav-tabs"
                               id="nav-tab"
                               role="tablist"
                          >
                              <a class="nav-link"
                                 id="controlWeek-tab"
                                 data-toggle="tab"
                                 href="#controlWeek"
                                 role="tab"
                                 aria-controls="controlWeek"
                                 aria-selected="false"
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
                              <a class="nav-link active"
                                 id="controlAll-tab"
                                 data-toggle="tab"
                                 href="#controlAll"
                                 role="tab"
                                 aria-controls="controlAll"
                                 aria-selected="true"
                              >{{__('Alle')}}</a>
                          </div>
                      </nav>
                      <div class="tab-content"
                           id="nav-tabContent"
                      >
                          @php
                              $controls = \App\ControlEquipment::take(10)
                          @endphp

                          <div class="tab-pane fade"
                               id="controlWeek"
                               role="tabpanel"
                               aria-labelledby="controlWeek-tab"
                          >
                              <table class="table table-responsive-md table-striped table-sm">
                                  <thead>
                                  <tr>
                                      <th>{{__('Gerät')}}</th>
                                      <th>{{__('Anforderung')}}</th>
                                      <th>{{__('Fällig')}}</th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @forelse(\App\ControlEquipment::take(10)->where('qe_control_date_due','<=',now()->addWeeks(4))->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                      <tr>
                                          <td>
                                              <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_label }}</a>
                                              <br>
                                              <x-notifyer>{{__('Inventar-Nr')}}: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                          </td>
                                          <td>{{ $controlEquipment->Anforderung->an_name }}</td>
                                          <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                          <td></td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="4">
                                              <span class="text-success">{{__('Keine Prüfungen in den kommenden 4 Wochen fällig')}}</span>
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
                              <table class="table table-responsive-md table-striped table-sm">
                                  <thead>
                                  <tr>
                                      <th>{{__('Gerät')}}</th>
                                      <th>{{__('Anforderung')}}</th>
                                      <th>{{__('Fällig')}}</th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @forelse(\App\ControlEquipment::take(10)->whereBetween('qe_control_date_due',[now()->addWeeks(4),now()->addMonths(3)])->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                      <tr>
                                          <td>
                                              <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_label }}</a>
                                              <br>
                                              <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                          </td>
                                          <td>{{ $controlEquipment->Anforderung->an_name }}</td>
                                          <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                          <td></td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="4">
                                              <span class="text-success">{{__('Keine Prüfungen in diesem Jahr fällig')}}</span>
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
                              <table class="table table-responsive-md table-striped table-sm">
                                  <thead>
                                  <tr>
                                      <th>{{__('Gerät')}}</th>
                                      <th>{{__('Anforderung')}}</th>
                                      <th>{{__('Fällig')}}</th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @forelse(\App\ControlEquipment::take(10)->whereBetween('qe_control_date_due',[now(),date('Y'.'-12-31')])->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                      <tr>
                                          <td>
                                              <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_label }}</a>
                                              <br>
                                              <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                          </td>
                                          <td>{{ $controlEquipment->Anforderung->an_name }}</td>
                                          <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                          <td></td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="4">
                                              <span class="text-success">{{__('Keine Prüfungen in diesem Jahr fällig')}}</span>
                                          </td>
                                      </tr>
                                  @endforelse
                                  </tbody>
                              </table>
                          </div>
                          <div class="tab-pane fade  show active"
                               id="controlAll"
                               role="tabpanel"
                               aria-labelledby="controlAll-tab"
                          >
                              <table class="table table-responsive-md table-striped table-sm">
                                  <thead>
                                  <tr>
                                      <th>{{__('Gerät')}}</th>
                                      <th>{{__('Anforderung')}}</th>
                                      <th>{{__('Fällig')}}</th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @forelse(\App\ControlEquipment::take(10)->orderBy('qe_control_date_due')->get() as $controlEquipment)
                                      <tr>
                                          <td>
                                              <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_label }}</a>
                                              <br>
                                              <x-notifyer>Inventar-Nr: {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
                                          </td>
                                          <td>{{ $controlEquipment->Anforderung->an_name }}</td>
                                          <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                                          <td></td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="4">
                                              <span class="text-success">{{__('Keine Prüfungen in diesem Jahr fällig')}}</span>
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
                    <a href="{{ route('event.index') }}">{{__('Ereignisse')}}</a>
                </h2>
                @forelse(App\EquipmentEvent::where('read',null)->take(10)->latest()->get() as $equipmentEvent)
                    <x-systemmessage
                        link="{{ route('equipment.show', $equipmentEvent->equipment->eq_inventar_nr ) }}"
                        linkText="{{__('zum Gerät')}}"
                        date="{{ $equipmentEvent->created_at }}"
                        subject="{{ $equipmentEvent->equipment->produkt->prod_name }}"
                    >
                        <strong>
                            <a href="{{ route('event.show',$equipmentEvent) }}">{{__('Schadensmeldung vom InfoSy App')}}</a>
                        </strong>
                        <p>{{ $equipmentEvent->equipment_event_text }}</p>
                    </x-systemmessage>
                @empty
                    <x-notifyer>{{__('Keine ungelesenen Meldungen gefunden!')}}</x-notifyer>
                @endforelse
            </x-dashborarditem>

{{--            <x-dashborarditem>
                <h2 class="h5">{{ __('Status') }}
                    <a href="{{ route('equipMain') }}">{{ __('Geräte')}}</a>
                </h2>
                <div id="myChart"
                     style="max-width: 350px;"
                ></div>

            </x-dashborarditem>--}}
        </div>
        {{--        {!!  App\Testware::checkTWStatus() !!}--}}
    </div>
@endsection


@section('scripts')

{{--    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>--}}
    <script>
/*
        let equipmentStateNumbers = [
            @foreach(App\EquipmentState::all() as $eqs)
            {{ App\Equipment::where('equipment_state_id',$eqs->id)->count() }},  // freigegeben
            @endforeach
        ];
        let equipmentStateColors = [
            "rgb(84,177,25)",
            "rgb(208,191,31)",
            "rgb(191,78,33)",
            "rgb(193,8,8)"
        ];
        let equipmentStateLabels = [
            "Freigegegben",
            "Beschädigt",
            "Reparatur",
            "Gesperrt"
        ];
        const options = {
            chart: {
                type: 'pie'
            },
            colors: equipmentStateColors,

            series: equipmentStateNumbers,

            labels: [
                "Freigegegben",
                "Beschädigt",
                "Reparatur",
                "Gesperrt"
            ]

        }

        var chart = new ApexCharts(document.querySelector("#myChart"), options);

        chart.render();*/

        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            language: "de-DE",
            // calendarWeeks: true
        }).on('changeDate', function() {
            $('#my_hidden_input').val(
                $('#datepicker').datepicker('getFormattedDate')
            );
        });

$('.btnOpenTestListeOfDate').click(function () {
    let testingdate = $(this).data('testingdate');
    $('.modal-title').html(`<p>Übersicht der Prüfung vom ${testingdate}</p>`);
    $('.modal-body').html(`
            `);
    $('#modalShowTestingList').modal('show');
});

$(document).on('click', '.setTestingCalenderDate', function () {

    const nextmonth = $(this).data('nextmonth');
    const nextyear = $(this).data('nextyear');


    $.ajax({
        type: "get",
        dataType: 'json',
        url: `getTestingCalender/${nextyear}-${nextmonth}-01`,
        success: (res) => {
            $('#testcalender').html(res.html);
        }
    });
});
    </script>

@endsection
