@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Vorgang')}}
@endsection

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Vorgang')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('updateAnforderungControlItem') }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden"
                           name="id"
                           id="aci_id"
                           value="{{ $anforderungcontrolitem->id }}"
                    >

                    <x-selectfield id="updt_anforderung_id" name="anforderung_id" label="Anforderung">
                        @foreach (App\Anforderung::all() as $anforderung)
                            <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_lang }}</option>
                        @endforeach
                    </x-selectfield>
                    <div class="row">
                        <div class="col-md-4">
                            <x-rtextfield id="aci_name_kurz" label="Kürzel" value="{{ $anforderungcontrolitem->aci_name_kurz }}"/>
                        </div>
                        <div class="col-md-8">
                            <x-rtextfield id="aci_name_lang" label="Name" max="150"  value="{{ $anforderungcontrolitem->aci_name_lang }}"/>
                        </div>
                    </div>

                    <x-textarea id="aci_task" label="Aufgabe"  value="{{ $anforderungcontrolitem->aci_task }}"/>

                    <div class="row">
                        <div class="col-md-4">
                            <x-textfield  id="aci_value_si" label="SI-Einheit [kg, °C, V usw]" max="10"  value="{{ $anforderungcontrolitem->aci_value_si }}"/>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="aci_vaule_soll" label="Sollwert"  value="{{ $anforderungcontrolitem->aci_vaule_soll }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio" id="updt_aci_internal" name="aci_exinternal" class="custom-control-input" value="internal" checked>
                                <label class="custom-control-label" for="updt_aci_internal">Interne Durchführung</label>
                            </div>
                            <x-selectfield name="aci_contact_id" id="updt_aci_contact_id" label="Mitarbeiter">
                                @foreach (App\User::with('profile')->get() as $user)
                                    <option value="{{ $user->id }}">{{ substr($user->profile->ma_vorname,0,1)}}. {{ $user->profile->ma_name }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio" id="updt_aci_external" name="aci_exinternal" class="custom-control-input" value="external">
                                <label class="custom-control-label" for="updt_aci_external">Externe Durchführung</label>
                            </div>
                            <x-selectfield id="updt_firma_id" label="Firma">
                                @foreach (App\Firma::all() as $firma)
                                    <option value="{{ $firma->id }}">{{ $firma->fa_name_lang }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>

                    <button class="btn btn-primary">{{__('Vorgang')}} speichern</button>
                </form>
            </div>
        </div>

    </div>

@endsection
