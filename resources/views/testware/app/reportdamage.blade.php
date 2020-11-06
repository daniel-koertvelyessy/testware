@extends('layout.layout-app')

@section('pagetitle')
    {{__('Schaden melden!')}}
@endsection

@section('navigation')
    {{--    @include('menus._menuPortal')--}}
@endsection

@section('content')
<div class="container">
    <div class="row mt-md-5 mt-sm-1">
        <div class="col">
            <h1 class="h3">Schaden am Gerät melden</h1>
            <x-frm_makeEquipmentEvent/>
        </div>
    </div>
</div>
@endsection
