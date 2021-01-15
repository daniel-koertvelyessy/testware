@extends('layout.layout-admin')

@section('pagetitle')
{{__('Berichte')}} &triangleright; {{__('Systemeinstellungen')}} | {{__('Start')}}
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
                <h1 class="h3">{{__('Übersicht Berichte')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Bezeichnung</th>
                        <th>Typ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a class="dropdown-item"
                                   href="{{ route('printPdfReport',$equipment->id) }}"
                                   target="_blank"
                                >
                                    <i class="ml-2 fas fa-qrcode mr-2 fa-fw"></i>
                                    {{__('QR-Code Drucken')}}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>
                                <x-notifyer>{{ __('Keine Berichte gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
