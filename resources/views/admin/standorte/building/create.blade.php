@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neues Gebäude anlegen')}} &triangleright; {{__('Gebäudeverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection


@section('content')
    {{-- `user_id``adress_id``l_beschreibung``l_name``l_label``l_benutzt`--}}
    <div class="container mt-2">
        <h1 class="h3">{{__('Neues Gebäude anlegen')}}</h1>
        <form action="{{ route('building.store') }}" method="post" class=" needs-validation">
            @csrf
            <input type="hidden"
                   name="storage_id"
                   id="storage_id"
                   value="{{ Str::uuid() }}"
            >
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="h5">Standort</h2>

                    <x-selectfield id="location_id" label="{{ __('Das Gebäude befindet sich im Standort') }}">
                        @foreach (App\Location::all() as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->l_label }}</option>
                        @endforeach
                    </x-selectfield>

                    <h2 class="h5">Bezeichner</h2>

                    <x-textfield id="b_label" label="{{ __('Kurzbezeichnung') }}" />

                    <x-textfield id="b_name_ort" label="{{ __('Ort') }}" />

                    <x-textfield id="b_name" label="{{ __('Bezeichnung') }}" />

                    <x-textarea id="b_description" label="{{ __('Beschreibung') }}" />


                </div>
                <div class="col-lg-6">
                    <h2 class="h5">{{__('Eigenschaften')}}</h2>
                    <div class="form-group">
                        <label for="building_type_id">{{__('Gebäudetyp festlegen')}} </label>
                        <select name="building_type_id" id="building_type_id" class="custom-select">
                            @foreach (App\BuildingTypes::all() as $bty)
                                <option value="{{ $bty->id }}">{{ $bty->btname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h2 class="h5">{{__('Wareneingang')}}</h2>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="b_we_has" name="b_we_has" {{ (old('b_we_has')==='1')?' checked ': '' }}>
                            <label class="form-check-label" for="b_we_has"> {{__('Wareneingang vorhanden')}}
                            </label>
                        </div>
                    </div>

                    <x-textfield id="b_we_name" label="{{ __('WE Bezeichnung') }}" />

                </div>
            </div>
                <x-btnMain>{{__('Gebäude anlegen')}} <span class="fas fa-download"></span></x-btnMain>
        </form>
    </div>
@endsection

@section('actionMenuItems')

@endsection()

@section('scripts')
    <script>
        $('#b_we_has').click(function (){
            let nd = $('#b_we_name');
            ($(this).prop('checked'))? nd.attr('disabled',false) : nd.attr('disabled',true)
        });
    </script>


@endsection
