@extends('layout.layout-admin')

@section('pagetitle','Verordnungen')

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
                <h1 class="h3">Verordnung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('verordnung.update',$verordnung) }}" method="POST" id="frmEditVerordnungen" name="frmEditVerordnungen">
                    @csrf
                    @method('PUT')
                    <input type="hidden"
                           name="id"
                           value="{{ $verordnung->id }}"
                    >
                    <x-rtextfield id="updt_vo_name_kurz" name="vo_name_kurz" label="Name - Kürzel" value="{{ $verordnung->vo_name_kurz }}" />

                    <x-textfield id="updt_vo_name_lang" name="vo_name_lang" label="Name" value="{{ $verordnung->vo_name_lang }}" />

                    <x-textfield id="updt_vo_nummer" name="vo_nummer" label="Nummer/Zeichen" value="{{ $verordnung->vo_nummer }}" />

                    <x-textfield id="updt_vo_stand" name="vo_stand" label="Stand" value="{{ $verordnung->vo_stand }}" />

                    <x-textarea id="updt_vo_name_text" name="vo_name_text" label="Beschreibung" value="{{ $verordnung->vo_name_text }}" />

                    <x-btnMain>Verordnung aktualisieren</x-btnMain>

                </form>
            </div>
        </div>

    </div>

@endsection
