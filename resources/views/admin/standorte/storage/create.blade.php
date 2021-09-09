@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neuen Stellplatz anlegen')}} &triangleright; {{__('Gebäudeverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('modals')
    <div class="modal"
         id="modalAddCompartmentType"
         tabindex="-1"
         aria-labelledby="modalAddCompartmentTypeLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createStellPlatzType') }}"
                      method="POST"
                      class="needs-validation"
                      id="frmCreateStellplatzType"
                      name="frmCreateStellplatzType"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddCompartmentTypeLabel"
                        >{{ __('Neuen Stellplatztyp erstellen') }}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"
                               name="frmOrigin"
                               id="frmOriginCreateStellplatzType"
                               value="location"
                        >
                        @csrf
                        <div class="row">
                            <div class="col">
                                <x-textfield id="spt_label"
                                             label="{{ __('Kürzel') }}"
                                />
                                <x-textfield id="spt_name"
                                             label="{{ __('Name') }}"
                                />
                                <x-textarea id="spt_description"
                                            label="{{ __('Beschreibung') }}"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{ __('Abbruch') }}
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >{{ __('Stellplatztyp speichern') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container mt-2">
        <h1 class="h3">{{__('Neuen Stellplatz anlegen')}}</h1>
        <form action="{{ route('stellplatz.store') }}"
              method="post"
              class=" needs-validation"
        >
            @csrf
            <input type="hidden"
                   name="storage_id"
                   id="storage_id"
                   value="{{ Str::uuid() }}"
            >
            <div class="row">
                <div class="col-md-6">
                    <x-selectfield id="room_id"
                                   label="{{ __('Der Stellplatz befindet sich im Raum') }}"
                    >
                        @foreach (App\Room::all() as $room)
                            <option value="{{ $room->id }}">{{ $room->r_label }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
                <div class="col-md-6">
                    <x-textfield id="sp_label"
                                 label="{{ __('Kurzbezeichnung') }}"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-textfield id="sp_name"
                                 label="{{ __('Bezeichnung') }}"
                    />
                </div>
                <div class="col-md-6">
                    <x-selectModalgroup id="stellplatz_typ_id"
                                        label="{{ __('Typ') }}"
                                        btnL="Neu"
                                        modalid="modalAddCompartmentType"
                    >
                        @foreach(App\StellplatzTyp::all() as $stellplatzTyp)
                            <option value="{{ $stellplatzTyp->id }}">
                                {{ $stellplatzTyp->spt_name }}
                            </option>
                        @endforeach
                    </x-selectModalgroup>
                </div>
            </div>
            <x-textarea id="sp_description"
                        label="{{ __('Beschreibung') }}"
            />
            <x-btnMain>{{__('Stellplatz anlegen')}} <span class="fas fa-download ml-2"></span></x-btnMain>
        </form>
    </div>
@endsection

@section('actionMenuItems')

@endsection()

@section('scripts')
    <script>
        $('#b_we_has').click(function () {
            let nd = $('#b_we_name');
            ($(this).prop('checked')) ? nd.attr('disabled', false) : nd.attr('disabled', true)
        });
    </script>


@endsection
