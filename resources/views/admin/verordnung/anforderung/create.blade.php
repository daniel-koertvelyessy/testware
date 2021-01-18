@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Neue Anforderung anlegen')}}
@endsection

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection

@section('modals')

    <div class="modal fade" id="modalAddNewAnforderungType" tabindex="-1" aria-labelledby="modalAddNewAnforderungTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Neuen Anforderungstyp anlegen')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addNewAnforderungType') }}"
                          method="post" id="frmAddNewAnforderungsType"
                    >
                        @csrf
                        <x-rtextfield id="at_label"
                                      label="Kürzel"
                        />
                        <x-textfield id="at_name"
                                     label="Name"
                        />
                        <x-textarea id="at_description"
                                    label="Beschreibung"
                        />

                        <x-btnMain>Anforderungstyp anlegen <span class="fas fa-download"></span></x-btnMain>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Neue Anforderung anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('anforderung.store') }}" method="POST">
                    @csrf
                    <x-selectfield id="verordnung_id" label="Gehört zu Verordnung">
                        @foreach (App\Verordnung::all() as $ad)
                            <option value="{{ $ad->id }}">{{ $ad->vo_label }}</option>
                        @endforeach
                    </x-selectfield>

                    <div class="row">
                        <div class="col-md-4">
                            <x-selectModalgroup id="anforderung_type_id" label="Anforderung Typ"
                                                modalid="modalAddNewAnforderungType">
                                @foreach(App\AnforderungType::all() as $anforderungType)
                                    <option value="{{ $anforderungType->id }}">{{ $anforderungType->at_name }}</option>
                                @endforeach
                            </x-selectModalgroup>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="an_control_interval" label="Prüfinterval" value="{{ old('an_control_interval')??'1' }}" />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="control_interval_id" label="Zeitraum">
                                @foreach (App\ControlInterval::all() as $controlInterval)
                                    <option value="{{ $controlInterval->id }}"
                                            @if (old('control_interval_id') && old('control_interval_id')=== $controlInterval->id)
                                            selected
                                            @elseif (!old('control_interval_id') && 8 === $controlInterval->id)
                                            selected
                                        @endif
                                    >
                                        {{ $controlInterval->ci_label }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>

                    </div>



                    <x-rtextfield id="an_label" label="Name - Kürzel" value="{{ old('an_label')??'' }}" />

                    <x-textfield id="an_name" label="Name" value="{{ old('an_name')??'' }}" />

                    <x-textarea id="an_description" label="Beschreibung" value="{{ old('an_description')??'' }}"  />

                    <x-btnMain>Anforderung anlegen <i class="fas fa-download"></i></x-btnMain>

                </form>
            </div>
        </div>

    </div>

@endsection
