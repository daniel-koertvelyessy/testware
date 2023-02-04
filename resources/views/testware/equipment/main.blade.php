@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Start')}} &triangleright; {{__('Geräte')}}@endsection

@section('mainSection')
    {{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h4">{{__('Übersicht')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}:</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <section class="card-body text-dark">
                    <x-tile link="{{ route('equipment.maker') }}" label="{{__('Neu')}}">
                        <i class="fas fa-box fa-2x"></i>
                    </x-tile>
                </section>
            </div>
            <div class="col-md-10">
                <table class="table "
                       id="tabEquipmentListe"
                >
                    <thead>
                    <tr>
                        <th class="">
                            @sortablelink('eq_name', __('Bezeichnung'))
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
                                    {{ $equipment->eq_name }}
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $equipment->eq_inventar_nr }}</td>
                            <td class="d-none d-md-table-cell">{!! ($equipment->storage) ? $equipment->storage->storage_label : '<span class="fas fa-exclamation-circle text-warning"></span> <span class="text-warning text-sm">keine Zuordnung</span>'!!}</td>
                            <td class="d-none d-lg-table-cell">
                                <span class="p-1 bg-{{ $equipment->EquipmentState->estat_color }} text-white">{{ $equipment->EquipmentState->estat_label }}</span>
                                @if($equipment->EquipmentQualifiedUser->count()===0)
                                    <span class="fas fa-user-times text-warning"
                                          title="{{ __('Es ist keine befähigte Person hinterlegt') }}"
                                    ></span>
                                @endif
                                @if(!\App\Http\Services\Equipment\EquipmentService::isTested($equipment))
                                    <i class="fas fa-exclamation-circle text-warning"
                                       title="{{__('Dieses Gerät hat noch keine Funktionsprüfung')}}"
                                    ></i>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell"
                                style="text-align: center;"
                            >
                                {!! $equipment->isControlProduct() !!}
                            </td>
                            <td>
                                @forelse ($equipment->ControlEquipment as $controlItem)
                                    @if($controlItem->Anforderung && ! $controlItem->Anforderung->is_initial_test)
                                        <span class="p-1
                                        @if ($controlItem->qe_control_date_due <  now())
                                            bg-danger text-white
                                        @else
                                        {{ ($controlItem->qe_control_date_due <  now()->addWeeks($controlItem->qe_control_date_warn)) ? 'bg-warning text-white' : '' }}
                                        @endif
                                            "
                                        >
                                        {{ $controlItem->qe_control_date_due }}
                                    </span>
                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endif
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
                                >{{__('neues Gerät anlegen')}}
                                    <span class="fas fa-angle-right ml-3"></span>
                                </a>
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
