@extends('layout.layout-admin')

@section('mainSection', __('Ereignisse'))

@section('pagetitle')
    {{__('Ereignisse von Geräten')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h4 d-md-block d-none">
                    {{ __('Übersicht') }}
                </h1>
                <table class="table" id="tableEventListe">
                    <thead>
                    <tr>
                        <th>@sortablelink('created_at', __('Vom'))</th>
                        <th class="d-none d-md-table-cell">{{__('gelesen')}}</th>
                        <th>@sortablelink('Equipment.eq_inventar_nr', __('Inventar-Nr'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('user.name', __('Bearbeiter'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($eventListItems as $equipmentEvent)
                        <tr>
                            <td>
                                <a href="{{ route('event.show',$equipmentEvent) }}">{{ $equipmentEvent->created_at->DiffForHumans() }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ Carbon\Carbon::parse($equipmentEvent->read)->DiffForHumans() ?? 'offen' }}</td>
                            <td>
                                {{ $equipmentEvent->equipment->produkt->prod_label }} /
                                {{ $equipmentEvent->equipment->eq_inventar_nr }}
                            </td>
                            <td class="d-none d-md-table-cell">{{ $equipmentEvent->User->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine aktiven Ereignisse gefunden</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($eventListItems->count()>10)
                <div class="d-flex justify-content-center">
                    {!! $eventListItems->withQueryString()->onEachSide(2)->links() !!}
                </div>
                    @endif
            </div>
        </div>

    </div>




@endsection

@section('scripts')

    <script>
        document.addEventListener("keydown", function (zEvent) {

            // if (zEvent.altKey && zEvent.key === "s") {  // case sensitive
            //     document.forms[0].submit()
            // }
            if (zEvent.altKey && zEvent.key === "n") {  // case sensitive
                location.href = "{{ route('event.create') }}"
            }
        });


    </script>
@endsection
