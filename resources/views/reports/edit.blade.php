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
                            <td>
                                <a href="{{ route('printReport',$report) }}"
                                   target="_blank"
                                >
                                    <span class="fas fa-print"></span>
                                    {{ $report->name }}
                                </a>
                            </td>
                            <td>{{ $report->description }}</td>
                            <td>{{ $report->types->name }}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-dark"
                                   href="{{ route('printReport',$report) }}"
                                   target="_blank"
                                   download
                                >
                                    <span class="fas fa-download"></span>
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
