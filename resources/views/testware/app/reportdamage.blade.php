@extends('layout.layout-app')

@section('pagetitle')
    {{__('Schaden melden!')}}
@endsection

@section('navigation')
    {{--    @include('menus._menuPortal')--}}
@endsection

@section('content')
<div class="container">
    <div class="row mt-md-5 mt-sm-1">
        <div class="col">
            <h1 class="h3">Schaden am Gerät melden</h1>
            <x-staticfield id="setEquipmentName" label="{{ __('Gerät') }}" value="{{ $edata->produkt->prod_name_lang }}" />
            <form action="{{ route('app.store') }}"
                  method="post">
                @csrf
                <input type="hidden"
                       name="equipment_id"
                       id="equipment_id"
                       value="{{ $edata->eq_uid??'' }}"
                >
                @auth

                    <input type="hidden"
                           name="equipment_event_user"
                           id="equipment_event_user"
                           value="{{ Auth::user()->id }}"
                    >

                @endauth
                <x-textarea id="equipment_event_text" label="{{__('Beschreibung des Schadens')}}"/>
                <button class="btn btn-primary">
                    Schaden melden!
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
