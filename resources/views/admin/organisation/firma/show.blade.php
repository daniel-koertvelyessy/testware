@extends('layout.layout-admin')

@section('pagetitle')
    Firma {{ $firma->fa_name_kurz }} &triangleright; Organnisation @ bitpack GmbH
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
                <h1>Firma bearbeiten</h1>
            </div>
        </div>
        <form action="{{ route('firma.update',['firma'=>$firma]) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="id"
                   value="{{ $firma->id??(old('id')??'') }}"
            >
            <div class="row">
                <div class="col">
                    <x-rtextfield id="fa_name_kurz" label="Kürzel" value="{{ $firma->fa_name_kurz }}"/>
                </div>
                <div class="col">
                    <x-textfield id="fa_vat" label="U-St-ID" value="{{ $firma->fa_vat }}" max="30"/>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-textfield id="fa_name_lang" label="Name" value="{{ $firma->fa_name_lang }}"/>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-selectfield id="adresse_id" label="Adresse">
                        @foreach(App\Adresse::all() as $adresse)
                            <option value="{{ $adresse->id }}"
                                    @if($adresse->id === $firma->adresse_id) selected @endif >
                                {{ $adresse->ad_name_lang }}
                            </option>
                        @endforeach
                    </x-selectfield>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-textfield id="fa_kreditor_nr" label="Liefranten Nummer" value="{{ $firma->fa_kreditor_nr }}"/>
                </div>
                <div class="col-md-6">
                    <x-textfield id="fa_debitor_nr" label="Kundennummer bei Firma" value="{{ $firma->fa_debitor_nr }}"/>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-textarea id="fa_name_text" label="Becshreibung" value="{{ $firma->fa_name_text }}"/>
                </div>
            </div>

            <x-btnMain>Firma speichern <span class="fas fa-download"></span></x-btnMain>
        </form>
    </div>

@endsection

