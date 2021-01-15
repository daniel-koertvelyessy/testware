@extends('layout.layout-admin')

@section('pagetitle')
{{__('Bericht')}} &triangleright; {{__('Systemeinstellungen')}} | {{__('Start')}}
@endsection

@section('mainSection')
    {{__('Berichte')}}
@endsection

@section('menu')
    @include('menus._menu_report')
@endsection

@section('breadcrumbs')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Bericht bearbeiten')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>

@endsection
