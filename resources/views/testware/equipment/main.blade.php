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
                <h1 class="h3">{{__('Übersicht')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <section class="card-body text-dark">
                    <nav class="d-felx justify-content-around">
                        <a href="{{ route('equipment.maker') }}"
                           class="tile-small rounded m-lg-3 btn-primary"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-box"></i></span> <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                    </nav>
                </section>
            </div>
            <div class="col-md-10">
                <table class="table "
                       id="tabEquipmentListe"
                >
                    <thead>
                    <tr>
                        <th class="">
                            @sortablelink('produkt.prod_name', __('Bezeichnung'))
                        </th>
                        <th class="d-none d-md-table-cell ">
                            @sortablelink('eq_inventar_nr', __('Inventarnummer'))
                        </th>
                        <th class="d-none d-md-table-cell ">
                            @sortablelink('storage.storage_label', __('memStandort'))
                        </th>
                        <th class="d-none d-lg-table-cell ">
                            @sortablelink('EquipmentState.estat_label', __('Status'))
                        </th>
                        <th class="d-none d-md-table-cell">
                            {{__('Prüfmittel')}}
                        </th>
                        <th class="">
                            {{--                            @sortablelink('ControlEquipment.qe_control_date_due', __('Fällig'))--}}
                            {{__('Prüfung(en) fällig')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($equipmentList as $equipment)
                        <tr>
                            <td>
                                <a href="{{ route('equipment.show',['equipment'=>$equipment]) }}">
                                    {{ $equipment->produkt->prod_name }}
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $equipment->eq_inventar_nr }}</td>
                            <td class="d-none d-md-table-cell">{{ $equipment->storage->storage_label }}</td>
                            <td class="d-none d-lg-table-cell"
                                style="vertical-align: middle;"
                            >
                                <span class="p-1 bg-{{ $equipment->EquipmentState->estat_color }} text-white">{{ $equipment->EquipmentState->estat_label }}</span>
                            </td>
                            <td class="d-none d-md-table-cell"
                                     style="text-align: center;"
                            >
                                {!! $equipment->isControlProduct() !!}
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
                                    <x-notifyer>{{__('Keine Geräte gefunden')}}</x-notifyer>
                                </p>
                                <a href="{{ route('equipment.maker') }}"
                                   class="btn mt-2 btn-primary"
                                >{{__('neues Gerät anlegen')}} <span class="fas fa-angle-right ml-3"></span></a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if(count($equipmentList)>1)
                    <div class="d-flex justify-content-center">
                        <div class="d-none d-lg-block">
                            {!! $equipmentList->withQueryString()->onEachSide(2)->links() !!}
                        </div>
                        <div class="d-lg-none">
                            {!! $equipmentList->withQueryString()->onEachSide(0)->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
