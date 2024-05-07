@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Dashboard')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('mainSection', __('testWare'))

@section('content')
    @if($initialiseApp)

        <div class="alert alert-info alert-dismissible fade show my-4 w-75 ml-auto mr-auto"
             role="alert"
        >
            <h2 class="h5">Initialisierung</h2>
            <p>Sie sind noch als
                <span class="badge badge-dark">testWare</span>
                Benutzer angemeldet. </p>
            <p>Ergänzen Sie Ihre Firmierung und Benutzerdaten. Dies können Sie entweder über die jeweiligen Seiten
                vornehmen oder einfach den Installer aufrufen.</p>
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
            <br>
            <span class="small">
                {{ __('Anzahl') }}: <span class="badge badge-info">{{ App\Equipment::select('id')->count() }}</span>
            </span>
        </h2>
        <div class="row">
            @foreach (App\EquipmentState::all() as $equipmentState)
                @php
                    $equipmentStateList = App\Equipment::select('id')->where('equipment_state_id',$equipmentState->id)->get()
                @endphp
                <div class="col-lg-3 col-md-6">
                    <div class="border rounded p-2 mb-3 d-flex justify-content-between align-items-center"
                         style="height: 8em;"
                    >
                        <div class="d-none d-lg-inline-flex align-items-center"
                             style="display: flex; flex-direction: column;"
                        >
                            <span>{{__('Status')}}: <strong><a href="equipment/status/{{$equipmentState->id}}">{{ucwords($equipmentState->estat_label) }}</a></strong>
                            </span>
                            <span class="mt-2 display-4 text-{{ ($equipmentStateList->count()>0) ? $equipmentState->estat_color : 'light' }}">
                                <i class="{{$equipmentState->estat_icon }}"></i>
                            </span>
                        </div>
                        <div class="d-lg-none"
                             style="display: flex; flex-direction: column;"
                        >
                            <span>{{__('Status')}}:
                                <strong><a href="equipment/status/{{$equipmentState->id}}"> {{ ucwords($equipmentState->estat_label) }} </a></strong>
                            </span>
                            {{--                            <span class="lead mt-2">{{ $equipmentState->estat_name }}</span>--}}
                            <span class="lead mt-2">{{ str_limit($equipmentState->estat_name,40) }}</span>
                        </div>
                        @if ($equipmentState->id === 1)
                            <span style="font-size: 3rem;"
                                  class="ml-2 text-{{ ($equipmentStateList->count()<1) ? 'warning ' : 'success ' }}"
                            >{{$equipmentStateList->count()}}
                        </span>
                        @else
                            <span style="font-size: 3rem;"
                                  class="ml-2 text-{{ ($equipmentStateList->count()>0) ? 'warning ' : 'muted '
                                   }}"
                            >{{$equipmentStateList->count()}}
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
                        <a class="nav-link active"
                           id="controlWeek-tab"
                           data-toggle="tab"
                           href="#controlWeek"
                           role="tab"
                           aria-controls="controlWeek"
                           aria-selected="true"
                        >4 {{__('Wochen')}}
                            <x-notifyer>({{ $equipmentTestWeekList->count() }})</x-notifyer>
                        </a>
                        <a class="nav-link"
                           id="controlMonth-tab"
                           data-toggle="tab"
                           href="#controlMonth"
                           role="tab"
                           aria-controls="controlMonth"
                           aria-selected="false"
                        >3 {{__('Monate')}}
                            <x-notifyer>({{ $equipmentTestMonthList->count() }})</x-notifyer>
                        </a>
                        <a class="nav-link"
                           id="controlYear-tab"
                           data-toggle="tab"
                           href="#controlYear"
                           role="tab"
                           aria-controls="controlYear"
                           aria-selected="false"
                        >{{__('dieses Jahr')}}
                            <x-notifyer>({{ $equipmentTestYearList->count() }})</x-notifyer>
                        </a>
                        <a class="nav-link"
                           id="controlAll-tab"
                           data-toggle="tab"
                           href="#controlAll"
                           role="tab"
                           aria-controls="controlAll"
                           aria-selected="false"
                        >{{__('Alle')}}
                            <x-notifyer>({{ $equipmentTestList->count() }})</x-notifyer>
                        </a>
                    </div>
                </nav>
                <div class="tab-content"
                     id="nav-tabContent"
                >
                    <div class="tab-pane fade show active"
                         id="controlWeek"
                         role="tabpanel"
                         aria-labelledby="controlWeek-tab"
                    >
                        <table class="table table-responsive-md table-striped table-sm mt-2">
                            <thead>
                            <tr>
                                <th class=" border-top-0">{{__('Gerät')}}</th>
                                <th class=" border-top-0">{{__('Anforderung')}}</th>
                                <th class=" border-top-0">{{__('Fällig')}}</th>
                                <th class=" border-top-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($equipmentTestWeekList->take($maxListItems) as $controlEquipment)
                                <x-dashboardTestitemList :controlEquipment="$controlEquipment"/>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">{{__('Keine Prüfungen in den kommenden 4 Wochen fällig')}}</span>
                                    </td>
                                </tr>
                            @endforelse
                            @if($equipmentTestWeekList->count()>0 && $equipmentTestWeekList->count() > $maxListItems)
                                <tr>
                                    <td colspan="4"
                                        class="text-center"
                                    >
                                        <a href="{{ route('control.index') }}">{{ __(':num weitere Prüfungen',
                                            ['num' => $equipmentTestWeekList->count()-$maxListItems])
                                            }}</a>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade"
                         id="controlMonth"
                         role="tabpanel"
                         aria-labelledby="controlMonth-tab"
                    >
                        <table class="table table-responsive-md table-striped table-sm mt-2">
                            <thead>
                            <tr>
                                <th class="border-top-0">{{__('Gerät')}}</th>
                                <th class="border-top-0">{{__('Anforderung')}}</th>
                                <th class="border-top-0">{{__('Fällig')}}</th>
                                <th class="border-top-0"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($equipmentTestMonthList->take($maxListItems) as $controlEquipment)
                                <x-dashboardTestitemList :controlEquipment="$controlEquipment"/>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">{{__('Keine Prüfungen in diesem Jahr fällig')}}</span>
                                    </td>
                                </tr>
                            @endforelse
                            @if($equipmentTestMonthList->count()>0 && $equipmentTestMonthList->count() > $maxListItems)
                                <tr>
                                    <td colspan="4"
                                        class="text-center"
                                    >
                                        <a href="{{ route('control.index') }}">{{ __(':num weitere Prüfungen',
                                            ['num' => $equipmentTestMonthList->count()-$maxListItems])
                                            }}</a>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade"
                         id="controlYear"
                         role="tabpanel"
                         aria-labelledby="controlYear-tab"
                    >
                        <table class="table table-responsive-md table-striped table-sm mt-2">
                            <thead>
                            <tr>
                                <th class="border-top-0">{{__('Gerät')}}</th>
                                <th class="border-top-0">{{__('Anforderung')}}</th>
                                <th class="border-top-0">{{__('Fällig')}}</th>
                                <th class="border-top-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($equipmentTestYearList->take($maxListItems) as $controlEquipment)
                                <x-dashboardTestitemList :controlEquipment="$controlEquipment"/>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">{{__('Keine Prüfungen in diesem Jahr fällig')}}</span>
                                    </td>
                                </tr>
                            @endforelse
                            @if($equipmentTestYearList->count()>0 && $equipmentTestYearList->count() > $maxListItems)
                                <tr>
                                    <td colspan="4"
                                        class="text-center"
                                    >
                                        <a href="{{ route('control.index') }}">{{ __(':num weitere Prüfungen',
                                            ['num' => $equipmentTestYearList->count()-$maxListItems])
                                            }}</a>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade "
                         id="controlAll"
                         role="tabpanel"
                         aria-labelledby="controlAll-tab"
                    >
                        <table class="table table-responsive-md table-striped table-sm mt-2">
                            <thead>
                            <tr>
                                <th class="border-top-0">{{__('Gerät')}}</th>
                                <th class="border-top-0">{{__('Anforderung')}}</th>
                                <th class="border-top-0">{{__('Fällig')}}</th>
                                <th class="border-top-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($equipmentTestList->take($maxListItems) as $controlEquipment)
                                <x-dashboardTestitemList :controlEquipment="$controlEquipment"/>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-success">{{__('Keine Prüfungen in diesem Jahr fällig')}}</span>
                                    </td>
                                </tr>
                            @endforelse
                            @if($equipmentTestList->count()>0 && $equipmentTestList->count() > $maxListItems)
                                <tr>
                                    <td colspan="4"
                                        class="text-center"
                                    >
                                        <a href="{{ route('control.index') }}">{{ __(':num weitere Prüfungen',
                                            ['num' => $equipmentTestList->count()-$maxListItems])
                                            }}</a>
                                    </td>
                                </tr>
                            @endif
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
                    {{--                    @dump($equipmentEvent)--}}
                    <x-systemmessage linkshow="{{ route('equipment.show', $equipmentEvent->equipment ) }}"
                                     linkshowtext="{{__('zum Gerät')}}"
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
        </div>
    </div>
@endsection


@section('scripts')

    <script>

        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            language: "de-DE",
            // calendarWeeks: true
        }).on('changeDate', function () {
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
