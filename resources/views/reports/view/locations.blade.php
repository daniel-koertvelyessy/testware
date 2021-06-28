@forelse(App\Location::all() as $loc)
    <div nobr="true">
        <h2>{{__('Standort')}} : {{ $loc->l_label }}</h2>
        <p style="font-size: 11pt">{{ $loc->l_name }}</p>
        <p><strong style="font-size: 9pt">{{__('Beschreibung')}}:</strong><br>{{ $loc->l_beschreibung??'-' }}</p>

        <h3>{{ __('Gebäude') }}</h3>
        <table cellspacing="0"
               cellpadding="2"
        >
            <thead>
            <tr style="font-size: 9pt; font-weight: bold;">
                <th width="20%">Nummer / ID</th>
                <th width="30%">Name</th>
                <th width="10%">Typ</th>
                <th width="35%">Räume</th>
                <th width="5%">WE</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($loc->Building as $building)
                <tr>
                    <td style="border-top: 1px solid #7c7c7c;"
                        width="20%"
                    >
                        {{$building->b_label}}
                    </td>
                    <td style="border-top: 1px solid #7c7c7c;"
                        width="30%"
                    >
                        {{$building->b_name}}
                    </td>
                    <td style="border-top: 1px solid #7c7c7c;"
                        width="10%"
                    >
                        {{ $building->BuildingType->btname }}
                    </td>
                    <td style="border-top: 1px solid #7c7c7c;"
                        width="35%"
                    >
                        @forelse($building->room as $room)
                            {{ $room->r_label }} - {{ $room->r_name }} <br>
                        @empty
                            {{ __('Keine Räume im Genäude definiert') }}
                        @endforelse
                    </td>
                    <td style="border-top: 1px solid #7c7c7c;"
                        width="5%"
                    >
                        @if ($building->b_we_has === 1)
                            {{$building->b_we_name}}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



@empty

    keine Standorte gefunden!

@endforelse
