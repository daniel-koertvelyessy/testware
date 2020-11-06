@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Meldung')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <div class="modal"
         id="modalDeclineEvent"
         tabindex="-1"
         aria-labelledby="modalDeclineEventLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('equipmentevent.destroy',$equipmentevent) }}"
                      method="post"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalDeclineEventLabel"
                        >Meldung ablehnen</h5>
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
                        @method('delete')

                        @if ($equipmentevent->equipment_event_user>0)
                            <x-textarea required
                                        id="event_decline_text"
                                        label="Begründung"
                            />
                            <input type="hidden"
                                   name="event_decline_user"
                                   id="event_decline_user"
                                   value="{{ $equipmentevent->equipment_event_user }}"
                            >
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger mb-2">
                            ablehnen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal"
         id="modalAcceptEvent"
         tabindex="-1"
         aria-labelledby="modalAcceptEventLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('equipmentevent.accept',$equipmentevent) }}"
                      method="post"
                >
                    @method('put')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAcceptEventLabel"
                        >Meldung annehmen</h5>
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
                               name="equipment_event_id"
                               id="equipment_event_id_modal"
                               value="{{ $equipmentevent->id }}"
                        >

                        <input type="hidden"
                               name="equipment_id_text_modal"
                               id="equipment_id"
                               value="{{ $equipmentevent->equipment_id }}"
                        >
                        <x-textarea required
                                    id="equipment_event_item_text_modal"
                                    name="equipment_event_item_text"
                                    label="Begründung"
                        />
                        <x-selectfield id="equipment_state_id_modal"
                                       name="equipment_state_id"
                                       label="Neuer Gerätestatus"
                        >
                            @foreach(\App\EquipmentState::all() as $equipmentState)
                                <option value="{{ $equipmentState->id }}"
                                        class="text-{{ $equipmentState->estat_color }}"
                                >
                                    {{ $equipmentState->estat_name_lang }}
                                </option>
                            @endforeach
                        </x-selectfield>
                        <div class="row">
                            <div class="col-md-6 align-items-center d-flex">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="setInformUser_modal"
                                           name="setInformUser"
                                           value="1"
                                    >
                                    <label class="custom-control-label"
                                           for="setInformUser_modal"
                                    >Benutzer informieren</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <x-selectfield id="user_id_modal"
                                               name="user_id"
                                               label="Benutzer wählen"
                                >
                                    @foreach(App\User::all() as $user)
                                        <option value="{{ $user->id }}"
                                                @if ($equipmentevent->equipment_event_user === $user->id)
                                                selected
                                            @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </x-selectfield>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary mb-2">
                            speichern
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">
                    {{ __('Vorgang Details') }}
                </h1>
            </div>
        </div>
        @if ($equipmentevent->eventitems->count()>0)

            <div class="row">
                <div class="col-md-8">
                    <h2 class="h5 mt-3">Neue Meldung </h2>
                    <form action="{{ route('equipmenteventitem.store') }}"
                          method="post"
                          id="frmAddEquipmentEventItem"
                    >
                        @csrf
                        <x-textarea id="equipment_event_item_text"
                                    label="Meldungstext"
                        />
                        <input type="hidden"
                               id="equipment_event_id"
                               value="{{ $equipmentevent->id }}"
                        >
                        <input type="hidden"
                               id="user_id"
                               value="{{ Auth::user()->id }}"
                        >

                        <button class="btn btn-sm btn-outline-primary ">
                            Neue Meldung speichern
                        </button>
                    </form>
                    <div class="dropdown-divider my-3"></div>
                    @foreach($equipmentevent->eventitems as $equipmenteventitem)
                        @if ($equipmenteventitem->user_id === Auth::user()->id )
                            <div class="card px-3 py-1 mb-3">
                                <form action="{{ route('equipmenteventitem.update',$equipmenteventitem) }}"
                                      method="post"
                                      id="frmUpdateEquipmentEventItem{{ $equipmenteventitem->id }}"
                                >
                                    @csrf
                                    @method('put')
                                    <div class="d-flex justify-content-between">
                                        <x-notifyer>Erstellt: {{ $equipmenteventitem->created_at->DiffForHumans() }}</x-notifyer>
                                        <x-notifyer>Aktualisiert: {{ $equipmenteventitem->updated_at->DiffForHumans() }}</x-notifyer>
                                    </div>
                                    <x-textarea id="equipment_event_item_text_update_{{ $equipmenteventitem->id }}"
                                                name="equipment_event_item_text"
                                                label="Meldungstext"
                                                value="{{ $equipmenteventitem->equipment_event_item_text }}"
                                    />
                                    <input type="hidden"
                                           name="equipment_event_id"
                                           id="equipment_event_id_update_{{ $equipmenteventitem->id }}"
                                           value="{{ $equipmenteventitem->equipment_event_id }}"
                                    >
                                    <input type="hidden"
                                           name="user_id"
                                           id="user_id_update_{{ $equipmenteventitem->id }}"
                                           value="{{ $equipmenteventitem->user_id }}"
                                    >

                                    <button class="btn btn-sm btn-outline-primary ">
                                        speichern
                                    </button>
                                </form>

                            </div>

                        @else

                            <div class="card px-3 py-1 mb-3">
                                <div class="d-flex justify-content-between">
                                    <x-notifyer>Erstellt: {{ $eventitem->created_at->DiffForHumans() }}</x-notifyer>
                                    <x-notifyer>von:
                                        <a href="mailto:{{ App\User::find($eventitem->user_id)->email }}">{{ App\User::find($eventitem->user_id)->name }}</a>
                                    </x-notifyer>
                                    <x-notifyer>Aktualisiert: {{ $eventitem->updated_at->DiffForHumans() }}</x-notifyer>
                                </div>
                                <p class="mt-2">{{ $eventitem->equipment_event_item_text }}</p>
                            </div>
                        @endif

                    @endforeach

                </div>
                <div class="col-md-4">
                    <div class="card p-2">
                    <h2 class="h5">Details zum Vorgang </h2>
                    <dl class="row">
                        <dt class="col-lg-4">Erstellt</dt>
                        <dd class="col-lg-8">{{ $equipmentevent->created_at->DiffForHumans() }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-lg-4">von Benutzer</dt>
                        <dd class="col-lg-8">
                            @if ($equipmentevent->equipment_event_user>0)
                                {{ \App\User::find($equipmentevent->equipment_event_user)->name }}
                            @endif
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-lg-4">Gerät</dt>
                        <dd class="col-lg-8">
                            <p>  {{ App\Produkt::find($equipmentevent->equipment->produkt_id)->prod_name_lang }}
                            </p>
                            Inventar-# {{ $equipmentevent->equipment->eq_inventar_nr }}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-lg-4">Meldung</dt>
                        <dd class="col-lg-8">{{ $equipmentevent->equipment_event_text }}</dd>
                    </dl>
                    </div>
                    <h2 class="h5 mt-3">Vorgang abschließen </h2>
                    <form action="{{ route('equipmentevent.destroy',$equipmentevent) }}"
                          method="post"
                          id="frmDeleteEquipmentEvent"
                    >
                        @csrf
                        @method('delete')
                        <input type="hidden"
                               name="equipment_event_id"
                               id="equipment_event_id_delete_{{ $equipmentevent->id }}"
                               value="{{ $equipmentevent->id }}"
                        >

                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_delete_{{ $equipmentevent->id }}"
                               value="{{ $equipmentevent->equipment_id }}"
                        >
                        <x-textarea required
                                    id="equipment_event_item_text_delete_{{ $equipmentevent->id }}"
                                    name="equipment_event_item_text"
                                    label="Begründung"
                        />
                        <x-selectfield id="equipment_state_id_delete_{{ $equipmentevent->id }}"
                                       name="equipment_state_id"
                                       label="Neuer Gerätestatus"
                        >
                            @foreach(\App\EquipmentState::all() as $equipmentState)
                                <option value="{{ $equipmentState->id }}"
                                        class="text-{{ $equipmentState->estat_color }}"
                                >
                                    {{ $equipmentState->estat_name_lang }}
                                </option>
                            @endforeach
                        </x-selectfield>

                        <button class="btn btn-sm btn-primary ">
                            Vorgang abschließen
                        </button>
                    </form>
                </div>
            </div>

        @else

            <div class="row">
                <div class="col">
                    <h2 class="h5 mt-3">Details zur Meldung </h2>
                    <dl class="row">
                        <dt class="col-sm-3">Erstellt</dt>
                        <dd class="col-sm-9">{{ $equipmentevent->created_at->DiffForHumans() }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">von Benutzer</dt>
                        <dd class="col-sm-9">
                            @if ($equipmentevent->equipment_event_user>0)
                                {{ \App\User::find($equipmentevent->equipment_event_user)->name }}
                            @endif
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">Gerät</dt>
                        <dd class="col-sm-9">
                            <p>  {{ App\Produkt::find($equipmentevent->equipment->produkt_id)->prod_name_lang }}
                            </p>
                            Inventar-# {{ $equipmentevent->equipment->eq_inventar_nr }}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">Meldung</dt>
                        <dd class="col-sm-9">{{ $equipmentevent->equipment_event_text }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-start">
                    <button type="button"
                            class="btn btn-danger mr-2"
                            data-toggle="modal"
                            data-target="#modalDeclineEvent"
                    >
                        Meldung ablehnen <i class="fas fa-times ml-2"></i>
                    </button>

                    <button type="button"
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#modalAcceptEvent"
                    >
                        Meldung annehmen <i class="fas fa-check-circle ml-2"></i>
                    </button>

                </div>
            </div>

        @endif
    </div>




@endsection
