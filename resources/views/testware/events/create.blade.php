@extends('layout.layout-admin')

@section('mainSection')
    {{__('Neues Ereignis erstellen')}}
@endsection

@section('pagetitle')
    {{__('Neues Ereignis erstellen')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container-md">
        <div class="row mb-4 d-none d-md-block">
            <div class="col">
                <h1 class="h3">
                    {{ __('Neues Ereignis erstellen') }}
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('event.store') }}"
                      method="post"
                >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text"
                                   name="equipment_id"
                                   id="equipment_id"
                            >
                            <label for="setEquipmetID">{{__('Gerät')}}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="setEquipmentIdIcon"
                                    ><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text"
                                       id="setEquipmetID"
                                       required
                                       class="form-control getEquipment"
                                       placeholder="{{ __('Suche') }}"
                                       aria-label="{{__('Gerät')}}"
                                       aria-describedby="setEquipmentIdIcon"
                                >
                            </div>


                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="equipment_event_user"
                                           label="{{__('Verantwortlicher Benutzer')}}"
                            >
                                @foreach(App\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="equipment_event_text"
                                        label="{{__('Fehlerbeschreibung')}}"
                                        required
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="equipment_state_id"
                                           label="{{__('Neuer Gerätestatus')}}"
                            >
                                @foreach(App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}">
                                        {{ $equipmentState->estat_name }}
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
    {{--    >
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
    <script>

        $(document).on('blur', '#setEquipmetID', function () {
            const setEquipmetID_node = $('#setEquipmetID');
            if (!$('#equipment_id').val()) {
                setEquipmetID_node.addClass('is-invalid');
                $('label[for="setEquipmetID"]').text('{{ __('Bitte ein vorhandenes Gerät eingeben!') }}').addClass('text-danger');
            } else {
                setEquipmetID_node.removeClass('is-invalid').addClass('is-valid');
                $('label[for="setEquipmetID"]').text('{{ __('Gerät') }}').removeClass('text-danger');
            }
        })
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
                                label: `(${obj.eq_serien_nr}) ${obj.prod_name} - ${obj.eq_inventar_nr} `,
                                id: obj.id,
                                value: `${obj.eq_serien_nr} - ${obj.prod_name}`
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
