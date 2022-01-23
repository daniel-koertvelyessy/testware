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
                <form action="{{ route('event.destroy',$event) }}"
                      method="post"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalDeclineEventLabel"
                        >{{__('Meldung ablehnen')}}</h5>
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
                               value="{{ $event->id }}"
                        >

                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_modal"
                               value="{{ $event->equipment_id }}"
                        >
                        @csrf
                        @method('delete')
                        @if ($event->equipment_event_user>0)
                            <x-textarea required
                                        id="event_decline_text"
                                        label="{{__('Begründung')}}"
                            />
                            <input type="hidden"
                                   name="event_decline_user"
                                   id="event_decline_user"
                                   value="{{ $event->equipment_event_user }}"
                            >
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger mb-2">
                            {{__('ablehnen')}}
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
                <form action="{{ route('event.accept',$event) }}"
                      method="post"
                >
                    @method('put')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAcceptEventLabel"
                        >{{__('Meldung annehmen')}}</h5>
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
                               value="{{ $event->id }}"
                        >

                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_modal"
                               value="{{ $event->equipment_id }}"
                        >
                        <x-textarea required
                                    id="equipment_event_item_text_modal"
                                    name="equipment_event_item_text"
                                    label="{{__('Begründung')}}"
                        />
                        <x-selectfield id="equipment_state_id_modal"
                                       name="equipment_state_id"
                                       label="{{__('Neuer Gerätestatus')}}"
                        >
                            @foreach(\App\EquipmentState::all() as $equipmentState)
                                <option value="{{ $equipmentState->id }}"
                                        class="text-{{ $equipmentState->estat_color }}"
                                >
                                    {{ $equipmentState->estat_name }}
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
                                    >{{__('Ereignis leitet Benutzer')}}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <x-selectfield id="user_id_modal"
                                               name="user_id"
                                               label="{{__('Benutzer wählen')}}"
                                >
                                    @foreach(App\User::all() as $user)
                                        <option value="{{ $user->id }}"
                                                @if ($event->equipment_event_user === $user->id)
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
                            {{__('speichern')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal"
         id="modalCloseEvent"
         tabindex="-1"
         aria-labelledby="modalCloseEventLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('event.close',$event) }}"
                      method="post"
                      id="frmDeleteEquipmentEvent"
                      enctype="multipart/form-data"
                >
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalCloseEventLabel"
                        >{{__('Ereignis abschließen')}}</h5>
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
                               id="equipment_event_id_close"
                               value="{{ $event->id }}"
                        >

                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_close"
                               value="{{ $event->equipment_id }}"
                        >
                        <x-textarea required
                                    id="equipment_event_item_text_close"
                                    name="equipment_event_item_text"
                                    label="{{__('Begründung')}}"
                        />
                        <x-selectfield id="equipment_state_id_close"
                                       name="equipment_state_id"
                                       label="{{__('Neuer Gerätestatus')}}"
                                       class="equipment_state_id"
                        >
                            @foreach(\App\EquipmentState::all() as $equipmentState)
                                <option value="{{ $equipmentState->id }}"
                                        class="text-{{ $equipmentState->estat_color }}"
                                >
                                    {{ $equipmentState->estat_name }}
                                </option>
                            @endforeach
                        </x-selectfield>

                        <p class="lead">Funtionstest nach Reparatur</p>
                        <x-selectfield id="document_type_id"
                                       label="{{__('Dokument Typ')}}"
                        >
                            @foreach (App\DocumentType::all() as $ad)
                                <option value="{{ $ad->id }}"
                                        @if ($ad->id === 2)
                                            selected
                                        @endif
                                >{{ $ad->doctyp_label }}</option>
                            @endforeach
                        </x-selectfield>

                        <x-textfield id="eqdoc_label"
                                     required
                                     label="{{__('Bezeichnung')}}"
                        />

                        <x-textarea id="eqdoc_description"
                                    label="{{__('Datei Informationen')}}"
                        />
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file"
                                       id="equipDokumentFile"
                                       name="equipDokumentFile"
                                       data-browse="Datei"
                                       class="custom-file-input"
                                       accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                       required
                                >
                                <label class="custom-file-label"
                                       for="equipDokumentFile"
                                >{{__('Datei wählen')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary ">
                            {{__('Vorgang abschließen')}}
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
                    {{ __('Ereignisdetails') }}
                </h1>
            </div>
        </div>
        @if ($event->eventitems->count()>0)
            <div class="row">
                <div class="col-md-8">
                    <h2 class="h5 mt-3">{{__('Neue Meldung')}} </h2>
                    <form action="{{ route('eventitem.store') }}"
                          method="post"
                          id="frmAddEquipmentEventItem"
                    >
                        @csrf
                        <x-textarea id="equipment_event_item_text"
                                    label="{{__('Meldungstext')}}"
                        />
                        <input type="hidden"
                               id="equipment_event_id"
                               name="equipment_event_id"
                               value="{{ $event->id }}"
                        >
                        <input type="hidden"
                               id="user_id"
                               name="user_id"
                               value="{{ Auth::user()->id }}"
                        >

                        <button class="btn btn-sm btn-outline-primary ">
                            {{__('Neue Meldung speichern')}}
                        </button>
                    </form>
                    <div class="dropdown-divider my-3"></div>
                    @foreach($event->eventitems as $eventitem)
                        @if ($eventitem->user_id === Auth::user()->id )
                            <div class="card px-3 py-1 mb-3">
                                <form action="{{ route('eventitem.update',$eventitem) }}"
                                      method="post"
                                      id="frmUpdateEquipmentEventItem{{ $eventitem->id }}"
                                >
                                    @csrf
                                    @method('put')
                                    <div class="d-flex justify-content-between">
                                        <x-notifyer>{{__('Erstellt')}}: {{ $eventitem->created_at->DiffForHumans() }}</x-notifyer>
                                        <x-notifyer>{{__('Aktualisiert')}}: {{ $eventitem->updated_at->DiffForHumans() }}</x-notifyer>
                                    </div>
                                    <x-textarea id="equipment_event_item_text_update_{{ $eventitem->id }}"
                                                name="equipment_event_item_text"
                                                label="{{__('Meldungstext')}}"
                                                value="{!! ($eventitem->equipment_event_item_text) !!}"
                                    />
                                    <input type="hidden"
                                           name="equipment_event_id"
                                           id="equipment_event_id_update_{{ $eventitem->id }}"
                                           value="{{ $eventitem->equipment_event_id }}"
                                    >
                                    <input type="hidden"
                                           name="user_id"
                                           id="user_id_update_{{ $eventitem->id }}"
                                           value="{{ $eventitem->user_id }}"
                                    >

                                    <button class="btn btn-sm btn-outline-primary ">
                                        {{__('speichern')}}
                                    </button>
                                </form>

                            </div>

                        @else

                            <div class="card px-3 py-1 mb-3">
                                <div class="d-flex justify-content-between">
                                    <x-notifyer>{{__('Erstellt')}}: {{ $eventitem->created_at->DiffForHumans() }}</x-notifyer>
                                    <x-notifyer>{{__('von')}}:
                                        <a href="mailto:{{ App\User::find($eventitem->user_id)->email }}">{{ App\User::find($eventitem->user_id)->name }}</a>
                                    </x-notifyer>
                                    <x-notifyer>{{__('Aktualisiert')}}: {{ $eventitem->updated_at->DiffForHumans() }}</x-notifyer>
                                </div>
                                <p class="mt-2">{{ $eventitem->equipment_event_item_text }}</p>
                            </div>
                        @endif

                    @endforeach

                </div>
                <div class="col-md-4">
                    <div class="card p-2">
                        <h2 class="h5">{{__('Details zum Vorgang')}} </h2>
                        <dl class="row">
                            <dt class="col-lg-4">{{__('Erstellt')}}</dt>
                            <dd class="col-lg-8">{{ $event->created_at->DiffForHumans() }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-lg-4">{{__('von Benutzer')}}</dt>
                            <dd class="col-lg-8">
                                @if ($event->equipment_event_user>0)
                                    {{ \App\User::find($event->equipment_event_user)->name }}
                                @endif
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-lg-4">{{__('Gerät')}}</dt>
                            <dd class="col-lg-8">
                                <p>  {{ App\Produkt::find($event->equipment->produkt_id)->prod_name }}
                                </p>
                                {{__('Inventar')}}-# {{ $event->equipment->eq_inventar_nr }}
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-lg-4">{{__('Meldung')}}</dt>
                            <dd class="col-lg-8">{{ $event->equipment_event_text }}</dd>
                        </dl>
                    </div>
                    <button type="button"
                            class="btn btn-primary btn-block mt-3"
                            data-toggle="modal"
                            data-target="#modalCloseEvent"
                    >
                        {{__('Vorgang abschließen')}}
                    </button>
                </div>
            </div>

        @else

            <div class="row">
                <div class="col">
                    <h2 class="h5 mt-3">{{__('Details zur Meldung')}} </h2>
                    <dl class="row">
                        <dt class="col-sm-3">{{__('Erstellt')}}</dt>
                        <dd class="col-sm-9">{{ $event->created_at->DiffForHumans() }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">{{__('von Benutzer')}}</dt>
                        <dd class="col-sm-9">
                            @if ($event->equipment_event_user>0)
                                {{ \App\User::find($event->equipment_event_user)->name }}
                            @endif
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">{{__('Gerät')}}</dt>
                        <dd class="col-sm-9">
                            <p>  {{ App\Produkt::find($event->equipment->produkt_id)->prod_name }}
                            </p>
                            {{__('Inventar-#')}} {{ $event->equipment->eq_inventar_nr }}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">{{__('Meldung')}}</dt>
                        <dd class="col-sm-9">{{ $event->equipment_event_text }}</dd>
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
                        {{__('Meldung ablehnen')}} <i class="fas fa-times ml-2"></i>
                    </button>

                    <button type="button"
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#modalAcceptEvent"
                    >
                        {{__('Meldung annehmen')}} <i class="fas fa-check-circle ml-2"></i>
                    </button>

                </div>
            </div>

        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $('#equipment_state_id_close').change(function () {
            const stateid = $('#equipment_state_id_close :selected').val();
           if(stateid==='3' || stateid==='4'){
               $('#eqdoc_label').attr('required',false);
               $('#equipDokumentFile').attr('required',false);
           } else {
               $('#eqdoc_label').attr('required',true);
               $('#equipDokumentFile').attr('required',true);
           }
        });
    </script>
@endsection
