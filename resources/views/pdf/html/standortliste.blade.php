@extends('layout.layout-htmlpdf')

@section('content')
    @foreach (App\Location::all() as $loc)
        <div nobr="true" >
            <h2>{{__('Standort')}} : {{ $loc->l_label }}</h2>
            <p style="font-size: 11pt">{{ $loc->l_name }}</p>
            <p><strong style="font-size: 9pt">{{__('Beschreibung')}}:</strong><br>{{ $loc->l_beschreibung }}</p>
            <table  cellspacing="0" cellpadding="2" border="0">
                <thead>
                <tr style="font-size: 9pt; font-weight: bold;">
                    <th width="20%">Nummer / ID</th>
                    <th width="50%">Name</th>
                    <th width="10%">Typ</th>
                    <th width="10%">Räume</th>
                    <th width="10%">WE</th>
                </tr>
                </thead>
                <tbody>
                @foreach (App\Location::find($loc->id)->Building as $building)
                    <tr>
                        <td style="border-top: 1px solid #7c7c7c;" width="20%">
                            {{$building->b_label}}
                        </td>
                        <td style="border-top: 1px solid #7c7c7c;" width="50%">
                            {{$building->b_raum_lang}}
                        </td>
                        <td style="border-top: 1px solid #7c7c7c;" width="10%">
                            {{ $building->BuildingType->btname }}
                        </td>
                        <td style="border-top: 1px solid #7c7c7c;" width="10%">
                            {{ App\Building::find($loc->id)->getRooms($building->id) }}
                        </td>
                        <td style="border-top: 1px solid #7c7c7c;" width="10%">
                            @if ($building->b_we_has === 1)
                                {{$building->b_we_name}}
                            @else
                                <span class="fas fa-times"></span>
                            @endif
                        </td>
                    </tr>


                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
