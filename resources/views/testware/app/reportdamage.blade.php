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
            {{ $edata }}
            <h1 class="h3">Schaden am Gerät melden</h1>
            <form action="{{ route('equipmentevent.store') }}"
                  method="post">
                @csrf
                <input type="hidden"
                       name="equipment_id"
                       id="equipment_id"
                       value="{{ $edata->eq_uid }}"
                >
                @auth

                    <input type="hidden"
                           name="equipment_event_user"
                           id="equipment_event_user"
                           value="{{ Auth::user()->id }}"
                    >

                @endauth
                <x-textarea id="equipment_event_text" label="Beschreibung"/>
                <button class="btn btn-primary">
                    Schaden melden!
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
