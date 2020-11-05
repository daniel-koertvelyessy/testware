@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neuen Mitarbeiter anlegen')}} &triangleright; {{__('Organisation')}}
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
                <h1 class="h3">{{__('Neuen Mitarbeiter anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('profile.store') }}"
                      method="post"
                >
                    @csrf
                    <x-frm_newprofile />
                    <x-btnMain>{{__('Mitarbeiter anlegen')}} <span class="fas fa-download"></span></x-btnMain>
                </form>
            </div>
        </div>
    </div>

@endsection
