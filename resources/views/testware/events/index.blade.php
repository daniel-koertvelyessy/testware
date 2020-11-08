@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Meldungen')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">
                    {{ __('Meldungen & Ereignisse') }}
                </h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Vom</th>
                        <th class="d-none d-md-table-cell">gelesen</th>
                        <th>Gerät / Inv-#</th>
                        <th class="d-none d-md-table-cell">Bearbeiter</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (\App\EquipmentEvent::all() as $equipmentEvent)
                        <tr>
                            <td>
                                <a href="{{ route('equipmentevent.show',$equipmentEvent) }}">{{ $equipmentEvent->created_at->DiffForHumans() }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ Carbon\Carbon::parse($equipmentEvent->read)->DiffForHumans() ?? 'offen' }}</td>
                            <td>
                                {{ $equipmentEvent->equipment->produkt->prod_name_kurz }} /
                                {{ $equipmentEvent->equipment->eq_inventar_nr }}
                            </td>
                            <td class="d-none d-md-table-cell">{{ $equipmentEvent->User->name }}</td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>




@endsection

@section('scripts')
    <script>
        document.addEventListener("keydown", function (zEvent) {

            if (zEvent.altKey && zEvent.key === "s") {  // case sensitive
                document.forms[0].submit()
            }
            if (zEvent.altKey && zEvent.key === "n") {  // case sensitive
                location.href = "{{ route('profile.create') }}"

            }
        });


    </script>
@endsection
