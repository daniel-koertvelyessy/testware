@extends('layout.layout-admin')

@section('pagetitle')
    Adressen &triangleright; Organnisation @ bitpack GmbH
@endsection

@section('mainSection')
    Organisation
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Adresse bearbeiten</h1>
            </div>
        </div>
        <form action="{{ route('adresse.update',['adresse'=>$adresse]) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="id"
                   value="{{ $adresse->id??(old('id')??'') }}"
            >
            <div class="row">
                <div class="col-md-4">
                    <x-rtextfield id="ad_label" label="Kürzel" value="{{ $adresse->ad_label??(old('ad_label')??'') }}"/>
                </div>
                <div class="col-md-4">
                    <x-textfield id="ad_name" label="Bezeichner" value="{{ $adresse->ad_name??(old('ad_name')??'') }}"/>
                </div>
                <div class="col-md-4">
                    <x-selectfield id="address_type_id" label="Adress-Typ">
                        @foreach(App\AddressType::all() as $adresseType)
                            <option value="{{ $adresseType->id }}"
                                    @if(isset($adresse) && $adresseType->id === $adresse->address_type_id) selected @endif >
                                {{ $adresseType->adt_name }}
                            </option>
                        @endforeach
                    </x-selectfield>
                </div>
            </div>
            <div class="row">
                <section class="col-md-8">
                    <h3 class="h5">Firmierung</h3>
                    <x-textfield id="ad_name_firma" label="Firma" value="{!! $adresse->ad_name_firma !!}"/>
                    <div class="row">
                        <div class="col-md-8">
                            <x-rtextfield max="100" id="ad_anschrift_strasse" label="Straße" value="{!! $adresse->ad_anschrift_strasse !!}"/>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ad_anschrift_hausnummer" label="Nr" value="{!! $adresse->ad_anschrift_hausnummer !!}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <x-rtextfield max="100" id="ad_anschrift_ort" label="Ort" value="{!! $adresse->ad_anschrift_ort !!}"/>
                        </div>
                        <div class="col-md-4">
                            <x-rtextfield max="100" id="ad_anschrift_plz" label="PLZ" value="{!! $adresse->ad_anschrift_plz !!}"/>
                        </div>
                    </div>
                    <x-selectfield id="land_id" label="Land">
                        @foreach (App\Land::all() as $land)
                            <option value="{{ $land->id }}"
                                    @if($land->id === $adresse->land_id) selected @endif >
                                {{ $land->land_lang }}
                            </option>
                        @endforeach
                    </x-selectfield>

                </section>
                <section class="col-md-4">
                    <h3 class="h5">Optional Angaben</h3>
                    <x-textfield id="ad_name_firma_2" label="Firma 2" value="{!! $adresse->ad_name_firma_2 !!}"/>
                    <x-textfield id="ad_name_firma_co" label="Firma c/o" value="{!! $adresse->ad_name_firma_co !!}"/>
                    <x-textfield id="ad_name_firma_abladestelle" label="Abladestelle" value="{!! $adresse->ad_name_firma_abladestelle !!}"/>
                    <x-textfield id="ad_name_firma_wareneingang" label="Wareneingang" value="{!! $adresse->ad_name_firma_wareneingang !!}"/>
                    <x-textfield id="ad_anschrift_eingang" label="Eingang" value="{!! $adresse->ad_anschrift_eingang !!}"/>
                </section>
            </div>
            <x-btnMain>Adresse speichern <span class="fas fa-download"></span></x-btnMain>
        </form>
    </div>

@endsection

