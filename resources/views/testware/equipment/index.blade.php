@extends('layout.layout-admin')

@section('mainSection', __('Geräte'))

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h4">{{__('Übersicht aller Geräte')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-sm">
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th>{{__('Inventarnummer')}}</th>
                        <th>{{__('Stellplatz')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Prüfung fällig')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(App\Equipment::all() as $equipment)
                        <tr>
                            <td>{{ $equipment->produkt->prod_name }}</td>
                            <td>{{ $equipment->eq_inventar_nr }}</td>
                            <td>{{ $equipment->storage->storage_label }}</td>
                            <td style="vertical-align: middle;">
                                <span class="p-1 bg-{{ $equipment->EquipmentState->estat_color }} text-light">{{ $equipment->EquipmentState->estat_label }}</span>

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
                            <td style="vertical-align: middle;"><a href="{{ route('equipment.show',['equipment'=>$equipment]) }}">{{__('öffnen')}}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <p>
                                    <x-notifyer>{{__('Keine Geräte gefunden')}}</x-notifyer>
                                </p>
                                <a href="{{ route('equipment.maker') }}" class="btn mt-2 btn-outline-primary">{{__('neues Gerät anlegen')}}</a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
