@extends('layout.layout-admin')

@section('pagetitle')
{{__('Start')}} &triangleright; {{__('Geräte')}}
@endsection

@section('mainSection')
    {{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Verwaltung')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <section class="card-body text-dark">
                    <nav class="d-felx justify-content-around">
                        <a href="{{ route('equipment.maker') }}"
                           class="tile-small rounded m-lg-3"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-box"></i></span> <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                    </nav>
                </section>
            </div>
            <div class="col-md-10">
                <table class="table" id="tabEquipmentListe">
                    <thead>
                    <tr>
                        <th class="">
                            {{__('Bezeichnung')}}
                        </th>
                        <th class="d-none d-md-table-cell ">
                            {{__('Inventar-Nr')}}
                        </th>
                        <th class="d-none d-md-table-cell ">
                            {{__('Stellplatz')}}
                        </th>
                        <th class="d-none d-lg-table-cell ">
                            {{__('Status')}}
                        </th>
                        <th class="">
                            {{__('Prüfung fällig')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($equipmentList as $equipment)
                        <tr>
                            <td>
                                <a href="{{ route('equipment.show',['equipment'=>$equipment]) }}">
                                    {{ $equipment->produkt->prod_name_lang }}
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $equipment->eq_inventar_nr }}</td>
                            <td class="d-none d-md-table-cell">{{ $equipment->standort->std_kurzel }}</td>
                            <td class="d-none d-lg-table-cell"
                                style="vertical-align: middle;"
                            >
                                @if ($equipment->equipment_state_id >1)
                                    <span class="p-1 bg-{{ $equipment->EquipmentState->estat_color }} text-white">{{ $equipment->EquipmentState->estat_name_kurz }}</span>
                                @else
                                    <span class="align-self-center">{{ $equipment->EquipmentState->estat_name_kurz }}</span>
                                @endif
                            </td>
                            <td>
                                @forelse ($equipment->ControlEquipment as $controlItem)
                                    <span
                                        class="p-1
                                        @if ($controlItem->qe_control_date_due <  now())
                                            bg-danger text-white
                                        @else
                                        {{ ($controlItem->qe_control_date_due <  now()->addWeeks($controlItem->qe_control_date_warn)) ? 'bg-warning text-white' : '' }}
                                        @endif
                                            "
                                    >
                                        {{ $controlItem->qe_control_date_due }}
                                    </span>
                                    @if (!$loop->last) <br> @endif
                                @empty
                                    -
                                @endforelse
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <p>
                                    <x-notifyer>Keine Geräte gefunden</x-notifyer>
                                </p>
                                <a href="{{ route('equipment.maker') }}"
                                   class="btn mt-2 btn-primary"
                                >{{__('neues Gerät anlegen')}} <span class="fas fa-angle-right ml-3"></span></a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if(count($equipmentList)>0)
                    <div class="d-flex justify-content-center">
                        {!! $equipmentList->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection


{{--@section('scripts')
    @if($equipmentList->count()>0)
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"
    >

    <script type="text/javascript"
            charset="utf8"
            src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"
    ></script>

    <script>


        $('#tabEquipmentListe').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
            },
            // "columnDefs": [
            //     {"orderable": false, "targets": 2}
            // ],
            "dom": 't'
        });
    </script>

    @endif
@endsection--}}
