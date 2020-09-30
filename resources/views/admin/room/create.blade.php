@extends('layout.layout-admin')

@section('pagetitle')
    Standortverwaltung | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standort
@endsection

@section('menu')
  @include('menus._menuStandort')
@endsection


@section('content')
    <div class="container mt-2">
        <h1 class="h3">Neuen Raum anlegen</h1>
        <form action="{{ route('room.store') }}" method="post" class="needs-validation">
            @csrf
            <input type="hidden"
                   name="standort_id"
                   id="standort_id"
                   value="{{ \Illuminate\Support\Str::uuid() }}"
            >
            <div class="row">
                <div class="col">
                    <x-selectfield id="building_id" label="Raum befindet sich im Gebäude">
                    @foreach (\App\Building::all() as $building)
                        <option value="{{ $building->id }}">{{ $building->b_name_kurz }}</option>
                    @endforeach
                    </x-selectfield>
                </div>
                <div class="col">
                    <x-selectfield id="room_type_id" label="Raum Typ">
                    @foreach (\App\RoomType::all() as $roomType)
                            <option value="{{ $roomType->id }}">{{ $roomType->rt_name_kurz }}</option>
                    @endforeach
                    </x-selectfield>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <x-rtextfield id="r_name_kurz" label="Raum Kürzel"/>
                    <x-textfield id="r_name_lang" label="Bezeichnung"/>
                    <label for="r_name_text">Beschreibung</label>
                    <textarea name="r_name_text" id="r_name_text" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button class="btn btn-primary btn-block">Raum anlegen</button>
        </form>
    </div>

@endsection


@section('locationActionMenuItems')

@endsection()

