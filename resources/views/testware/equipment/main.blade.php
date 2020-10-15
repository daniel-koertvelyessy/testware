@extends('layout.layout-admin')

@section('pagetitle')
{{__('Start')}} &triangleright; {{__('Geräte')}} @ bitpack.io GmbH
@endsection

@section('mainSection')
{{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{__('Geräte-Verwaltung')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}</p>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">

                        <a href="{{ route('equipment.index') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-boxes"></i></span>
                            <span class="branding-bar text-center">{{__('Übersicht')}}</span>
                        </a>

                        <a href="{{ route('equipMaker') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-box"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>

                    </nav>
                </section>

            </div>
        </div>
    </div>

@endsection
