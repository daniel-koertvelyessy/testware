@extends('layout.layout-admin')

@section('pagetitle')
    Firmen &triangleright; Organnisation @ bitpack GmbH
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
                <h1>Firma anlegen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('firma.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <x-rtextfield id="fa_label" label="Kürzel"/>
                        </div>
                        <div class="col">
                            <x-textfield id="fa_vat" label="U-St-ID" max="30"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textfield id="fa_name" label="Name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="adresse_id" label="Adresse">
                                @foreach(App\Adresse::all() as $adresse)
                                    <option value="{{ $adresse->id }}">
                                        {{ $adresse->ad_name }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="fa_kreditor_nr" label="Liefranten Nummer" />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="fa_debitor_nr" label="Kundennummer bei Firma" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="fa_name_text" label="Becshreibung" />
                        </div>
                    </div>

                    <x-btnMain>Firma speichern <span class="fas fa-download"></span></x-btnMain>

                </form>
            </div>
        </div>
    </div>

@endsection
