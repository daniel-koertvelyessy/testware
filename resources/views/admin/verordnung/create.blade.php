@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neue Verordnung anlegen')}}  &triangleright; {{__('Vorschriften')}}
@endsection

@section('mainSection')
    {{__('Verordnung anlegen')}}
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

                    <x-rtextfield id="updt_vo_label" name="vo_label" label="{{__('Kürzel')}}:"  />

                    <x-textfield id="updt_vo_name" name="vo_name" label="{{__('Name')}}:"  />

                    <x-textfield id="updt_vo_nummer" name="vo_nummer" label="{{__('Nummer/Zeichen')}}:"  />

                    <x-textfield id="updt_vo_stand" name="vo_stand" label="{{__('Stand')}}:"  />

                    <x-textarea id="updt_vo_description" name="vo_description" label="{{__('Beschreibung')}}:"  />

                    <x-btnMain>{{__('Verordnung anlegen')}}<i class="fas fa-download ml-2"></i></x-btnMain>

                </form>
            </div>
        </div>

    </div>

@endsection
