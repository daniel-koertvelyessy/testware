@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col">
                <h1 class="h4">Übersicht aller Geräte</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th>Inventar-Nr</th>
                        <th>Stellplatz</th>
                        <th>Status</th>
                        <th>Prüfung</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(App\Equipment::all() as $equipment)
                        <tr>
                            <td>{{ $equipment->produkt->prod_name_lang }}</td>
                            <td>{{ $equipment->eq_inventar_nr }}</td>
                            <td>{{ $equipment->standort->std_kurzel }}</td>
                            <td><span class="text-{{ $equipment->EquipmentState->estat_color }}">{{ $equipment->EquipmentState->estat_name_kurz }}</span></td>
                            <td>{{ $equipment->id }}</td>
                            <td><a href="{{ route('equipment.show',['equipment'=>$equipment]) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-info text-center">Keine Geräte angelegt!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection




@section('scripts')

@stop
