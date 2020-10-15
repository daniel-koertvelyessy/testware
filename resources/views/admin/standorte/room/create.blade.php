@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neuen Raum anlegen')}} &triangleright; {{__('Standortverwaltung')}} @ bitpack.io GmbH
@endsection

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('menu')
  @include('menus._menuStandort')
@endsection

@section('modals')

    <div class="modal fade" id="modalAddRaumTyp" tabindex="-1" aria-labelledby="modalAddRaumTypLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddRaumTypLabel">{{__('Neuen Raumtyp anlegen')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createRoomType') }}" method="POST" class="needs-validation" id="addNewRoomType" name="addNewRoomType">
                        @csrf
                        <x-rtextfield id="rt_name_kurz" label="{{__('Kürzel')}}" />

                        <x-textfield id="rt_name_lang" label="{{__('Name')}} " />

                        <x-textarea id="rt_name_text" label="{{__('Beschreibung des Raumtyps')}}" />

                        <x-btnMain>{{__('Neuen Raumtyp anlegen')}} <span class="fas fa-download"></span></x-btnMain>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container mt-2">
        <h1 class="h3">{{__('Neuen Raum anlegen')}}</h1>
        <form action="{{ route('room.store') }}" method="post" class="needs-validation">
            @csrf
            <input type="hidden"
                   name="standort_id"
                   id="standort_id"
                   value="{{ \Illuminate\Support\Str::uuid() }}"
            >
            <div class="row">
                <div class="col">
                    <x-selectfield id="building_id" label="{{__('Raum befindet sich im Gebäude')}}">
                    @foreach (\App\Building::all() as $building)
                        <option value="{{ $building->id }}">{{ $building->b_name_kurz }}</option>
                    @endforeach
                    </x-selectfield>
                </div>
                <div class="col">
                    <x-selectModalgroup
                        id="room_type_id"
                        label="{{__('Raum Typ')}}"
                        btnL="Neu"
                        modalid="modalAddRaumTyp"
                    >
                    @foreach (\App\RoomType::all() as $roomType)
                            <option value="{{ $roomType->id }}">{{ $roomType->rt_name_kurz }}</option>
                    @endforeach
                    </x-selectModalgroup>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <x-rtextfield id="r_name_kurz" label="{{__('Raum Kürzel')}}"/>
                    <x-textfield id="r_name_lang" label="{{__('Bezeichnung')}}"/>
                    <x-textarea id="r_name_text" label="{{__('Beschreibung')}}" />
                </div>
            </div>
            <x-btnMain>{{__('Raum anlegen')}} <i class="fas fa-download"></i></x-btnMain>
        </form>
    </div>

@endsection


@section('locationActionMenuItems')

@endsection()

