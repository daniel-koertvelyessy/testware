@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Ereignis erstellen')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container-md">
        <div class="row">
            <div class="col">
                <h1 class="h3">
                    {{ __('Neues Ereignis erstellen') }}
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('equipmentevent.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden"
                                   name="equipment_id"
                                   id="equipment_id"
                            >
                            <x-textfield id="setEquipmetID" label="Gerät" required class="getEquipment"  />
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="equipment_event_user" label="Verantwortlicher Benutzer">
                                @foreach(App\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="equipment_event_text" label="Fehlerbeschreibung" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="equipment_state_id" label="Neuer Gerätestatus">
                                @foreach(App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}">
                                        {{ $equipmentState->estat_name_lang }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <button class="btn btn-primary">
                        {{__('Ereignis anlegen')}}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('autoloadscripts')
{{--    <link rel="stylesheet"--}}
{{--          href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"--}}
{{--    >--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>

        $(".getEquipment").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('getEquipmentAjaxListe') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        let resp = $.map(data, function (obj) {
                            return {
                                label: `(${obj.eq_serien_nr}) ${obj.prod_name_lang} - ${obj.eq_inventar_nr} `,
                                id: obj.id,
                                value: `${obj.eq_serien_nr} - ${obj.prod_name_lang}`
                            };
                        });
                        response(resp);
                    }
                });
            },
            select: function (event, ui) {
                $('#equipment_id').val(ui.item.id);
            }
        });


    </script>
@endsection
