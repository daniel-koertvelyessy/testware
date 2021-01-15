@extends('layout.layout-admin')

@section('pagetitle')
    Berichte &triangleright; Systemeinstellungen | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Berichte
@endsection

@section('menu')
@include('menus._menu_report')
@endsection

@section('breadcrumbs')
    {{--    <nav aria-label="breadcrumb">--}}
    {{--        <ol class="breadcrumb">--}}
    {{--            <li class="breadcrumb-item"><a href="/">Portal</a></li>--}}
    {{--            <li class="breadcrumb-item active" aria-current="page">Berichte</li>--}}
    {{--        </ol>--}}
    {{--    </nav>--}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Übersicht Berichte</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>

@endsection
