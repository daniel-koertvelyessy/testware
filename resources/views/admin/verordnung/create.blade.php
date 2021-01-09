@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Neue Verordnung anlegen')}}
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
                <h1 class="h3">{{__('Neue Verordnung anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('verordnung.store') }}" method="POST">
                    @csrf

                    <x-rtextfield id="updt_vo_label" name="vo_label" label="Name - Kürzel"  />

                    <x-textfield id="updt_vo_name" name="vo_name" label="Name"  />

                    <x-textfield id="updt_vo_nummer" name="vo_nummer" label="Nummer/Zeichen"  />

                    <x-textfield id="updt_vo_stand" name="vo_stand" label="Stand"  />

                    <x-textarea id="updt_vo_name_text" name="vo_name_text" label="Beschreibung"  />

                    <x-btnMain>Verordnung anlegen <i class="fas fa-download"></i></x-btnMain>

                </form>
            </div>
        </div>

    </div>

@endsection
