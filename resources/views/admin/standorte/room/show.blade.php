@extends('layout.layout-admin')

@section('pagetitle')
{{ __('Raum')}} {{  $room->r_label  }} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('Raum')}}: {{  $room->r_label  }}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storageMain') }}">{{__('memStandorte')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.index') }}">{{ __('Standorte') }} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item">
                @if($room->building)
                    <a href="{{ route('location.show', $room->building->location) }}"> {{ $room->building->location->l_label }}</a>
                @else
                    -
                @endif
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('building.index') }}">{{__('Gebäude')}} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item">
                @if($room->building)
                    <a href="{{ route('building.index', $room->building) }}"> {{ $room->building->b_label }}</a>
                @else
                    -
                @endif
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('room.index') }}">{{__('Räume')}} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >
                {{__('Raum')}} {{  $room->r_label  }}
            </li>
        </ol>
    </nav>
@endsection

@section('modals')

    <div class="modal"
         id="modalAddStellPlatzType"
         tabindex="-1"
         aria-labelledby="modalAddStellPlatzTypeLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createStellPlatzType') }}"
                      method="POST"
                      class="needs-validation"
                      id="frmCreateCompartmentType"
                      name="frmCreateCompartmentType"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddStellPlatzTypeLabel"
                        >{{ __('Neuen Stellplatztyp erstellen')}}</h5>
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
                               id="frmOriginCreateStellPlatzType"
                               value="room"
                        >
                        <input type="hidden"
                               name="room_id"
                               id="room_id"
                               value="{{ $room->id }}"
                        >
                        @csrf
                        <x-rtextfield id="spt_label"
                                      label="{{__('Kürzel')}}"
                        />
                        <x-textfield id="spt_name"
                                     label="{{__('Beschreibung')}}"
                        />
                        <x-textarea id="spt_description"
                                    label="{{__('Beschreibung des Typs')}}"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button type="submit"
                                class="btn btn-primary"
                        >{{__('Stellplatztyp speichern')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal"
         id="modalAddRaumTyp"
         tabindex="-1"
         aria-labelledby="modalAddRaumTypLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createRoomType') }}"
                      method="POST"
                      class="needs-validation"
                      id="frmCreateRoomType"
                      name="frmCreateRoomType"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddRaumTypLabel"
                        >{{ __('Neuen Raumtyp erstellen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <x-rtextfield id="rt_label"
                                      label="{{__('Kürzel')}}"
                        />
                        <x-textfield id="rt_name"
                                     label="{{__('Beschreibung')}}"
                        />
                        <x-textarea id="rt_description"
                                    label="{{__('Beschreibung des Typs')}}"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button type="submit"
                                class="btn btn-primary"
                        >{{__('Raumtyp speichern')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-modal-add-note
        objectname="{{ $room->r_label }}"
        uid="{{ $room->storage_id }}"
    />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4 d-none d-md-block">
            <div class="col d-flex justify-content-between">
                <h1 class="h3">{{__('Übersicht Raum')}}: {{ $room->r_label }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab"
                    id="myTab"
                    role="tablist"
                >
                    <li class="nav-item "
                        role="presentation"
                    >
                        <a class="nav-link active"
                           id="roomStammDaten-tab"
                           data-toggle="tab"
                           href="#roomStammDaten"
                           role="tab"
                           aria-controls="roomStammDaten"
                           aria-selected="true"
                        >{{__('Stammdaten')}}</a>
                    </li>

                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="roomStellPlatze-tab"
                           data-toggle="tab"
                           href="#roomStellPlatze"
                           role="tab"
                           aria-controls="roomStellPlatze"
                           aria-selected="false"
                        >{{__('Stellplätze')}} <span class="badge {{ ($room->stellplatzs()->count()>0)? ' badge-info ' : '' }} ">{{ $room->stellplatzs()->count() }}</span></a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="locNotes-tab"
                           data-toggle="tab"
                           href="#notes"
                           role="tab"
                           aria-controls="locNotes"
                           aria-selected="false"
                        >{{__('Notizen')}}</a>
                    </li>
                    {{--                    <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="roomEquip-tab" data-toggle="tab" href="#roomEquip" role="tab" aria-controls="roomEquip" aria-selected="false">Geräte</a>
                                        </li>--}}
                </ul>
                <div class="tab-content"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active p-2 "
                         id="roomStammDaten"
                         role="tabpanel"
                         aria-labelledby="roomStammDaten-tab"
                    >
                        <form action="{{ route('room.update',$room) }}"
                              method="post"
                        >
                            @method('PUT')
                            @csrf
                            <input type="hidden"
                                   name="id"
                                   id="id"
                                   value="{{ $room->id }}"
                            >

                            <div class="row">
                                <div class="col-md-6">
                                    <x-selectfield id="building_id"
                                                   label="{{__('Raum befindet sich im Gebäude')}}"
                                    >
                                        @if(! $room->building)
                                            <option value="void">{{ __('keine Zuordnung') }}</option>
                                        @endif
                                        @foreach (App\Building::all() as $bul)
                                            <option value="{{ $bul->id }}" {{ ($bul->id === $room->building_id) ? ' selected ' : '' }}>{{ $bul->b_label }}</option>
                                        @endforeach
                                    </x-selectfield>
                                </div>
                                <div class="col-md-6">
                                    <x-selectModalgroup
                                        id="room_type_id"
                                        label="{{__('Raumtyp')}}"
                                        modalid="modalAddRaumTyp"
                                    >
                                        @foreach (\App\RoomType::all() as $roomType)
                                            <option value="{{ $roomType->id }}"
                                                    @if($room->room_type_id == $roomType->id) selected @endif>
                                                {{ $roomType->rt_label }}
                                            </option>
                                        @endforeach
                                    </x-selectModalgroup>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <x-rtextfield id="r_label"
                                                  label="{{__('Kurzbezeichnung')}}"
                                                  value="{{ $room->r_label }}"
                                    />
                                    <x-textfield id="r_name"
                                                 label="{{__('Bezeichnung')}}"
                                                 value="{{ $room->r_name }}"
                                    />
                                    <x-textarea id="r_description"
                                                label="{{__('Beschreibung')}}"
                                                value="{{ $room->r_description }}"
                                    />
                                </div>
                            </div>
                            <x-btnMain block="1">{{__('Stammdaten speichern')}} <i class="fas fa-download"></i></x-btnMain>
                        </form>
                    </div>
                    <div class="tab-pane fade"
                         id="roomStellPlatze"
                         role="tabpanel"
                         aria-labelledby="roomStellPlatze-tab"
                    >
                        <div class="row">
                            <div class="col">
                                <form class="row gy-2 gx-3  my-3"
                                      action="{{ route('stellplatz.store') }}#roomStellPlatze"
                                      method="post"
                                      name="frmAddNewStellPlatz"
                                      id="frmAddNewStellPlatz"
                                >
                                    <input type="hidden"
                                           name="storage_id"
                                           id="storage_id"
                                           value="{{ \Illuminate\Support\Str::uuid() }}"
                                    >
                                    @csrf
                                    <input type="hidden"
                                           name="room_id"
                                           id="room_id_{{ $room->id }}"
                                           value="{{ $room->id }}"
                                    >
                                    <input type="hidden"
                                           name="frmOrigin"
                                           id="frmOriginAddNewStellPlatz"
                                           value="room"
                                    >
                                    <div class="col-auto">
                                        <x-rtextfield id="sp_label"
                                                      hideLabel="1"
                                                      placeholder="{{__('Stellplatz Nummer')}}"
                                        />
                                    </div>
                                    <div class="col-auto">
                                        <x-textfield id="sp_name"
                                                     placeholder="{{ __('Stellplatz Name') }}"
                                                     hideLabel="1"
                                                     max="100"
                                        />
                                    </div>
                                    <div class="col-auto">
                                        <x-selectModalgroup id="stellplatz_typ_id" hideLabel="1"
                                                            label="{{__('Stellplatztyp')}}"
                                            modalid="modalAddStellPlatzType"
                                        >
                                    @foreach (\App\StellplatzTyp::all() as $roomType)
                                        <option value="{{ $roomType->id }}"
                                                title="{{ $roomType->spt_name  }}"
                                        >{{ $roomType->spt_label  }}</option>
                                    @endforeach
                                        </x-selectModalgroup>
                                    </div>
                                    <div class="col-auto">
                                        <button {{--@if (!env('app.makeobjekte') ) disabled @endif --}} type="submit"
                                                class="btn btn-primary"
                                        >{{__('Neuen Stellplatz anlegen')}} <i class="fas fa-download ml-2"></i>
                                        </button>
                                    </div>
                                </form>
                                @if ($room->stellplatzs()->count()>0)
                                    <table class="table table-responsive-md table-striped"
                                           id="tabStellplatzListe"
                                    >
                                        <thead>
                                        <tr>
                                            <th>{{__('Nummer')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Typ')}}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($room->stellplatzs as $spl)
                                            <tr>
                                                <td>{{ $spl->sp_label }}</td>
                                                <td>{{ $spl->sp_name }}</td>
                                                <td>{{ \App\StellplatzTyp::find($spl->stellplatz_typ_id)->spt_label }}</td>
                                                <td class="text-right">
                                                    <x-menu_context
                                                        :object="$spl"
                                                        routeOpen="{{ route('stellplatz.show', $spl) }}"
                                                        routeCopy="{{ route('copyStellplatz',$spl) }}"
                                                        routeDestory="{{ route('stellplatz.destroy',$spl) }}"
                                                        tabName="roomStellPlatze"
                                                        objectVal="{{$spl->sp_label}}"
                                                        objectName="sp_label"
                                                    />
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--<div class="tab-pane fade" id="roomEquip" role="tabpanel" aria-labelledby="roomEquip-tab">
                        <div class="row">
                            <div class="col">
                                <h2 class="h6">Folgende Geräte sind dem Standort zugeteilt</h2>
                            </div>
                        </div>
                    </div>--}}
                    <x-tab-note uid="{{ $room->storage_id }}"/>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->has('spt_label'))
        <script>
            $('#modalAddStellPlatzType').modal('show');
        </script>
    @endif
@endsection


