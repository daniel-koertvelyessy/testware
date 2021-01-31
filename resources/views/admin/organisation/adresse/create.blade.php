@extends('layout.layout-admin')

@section('pagetitle')
{{__('Adressen')}} &triangleright; {{__('Organisation')}}
@endsection

@section('mainSection')
    {{__('Organisation')}}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{__('Adresse anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('adresse.store') }}"
                      method="post"
                >
                    @csrf
                    <x-frm_AddAdresse/>
                    <x-btnMain>{{__('Adresse speichern')}} <span class="fas fa-download ml-2"></span></x-btnMain>
                </form>
            </div>
        </div>
    </div>

@endsection
