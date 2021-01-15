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
                        <th class="d-none d-md-table-cell">Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Typ</th>
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
                            <td class="d-none d-md-table-cell">{{ $report->description }}</td>
                            <td class="d-none d-md-table-cell">{{ $report->types->name }}</td>
                            <td>
                                <span class="d-none d-md-block">
                                <a class="btn btn-sm btn-outline-dark"
                                   href="{{ route('report.show',$report) }}"
                                   target="_blank"
                                >
                                    <span class="fas fa-external-link-alt"></span>
                                </a>
                                <a class="btn btn-sm btn-outline-dark"
                                   href="{{ route('printReport',$report) }}"
                                   target="_blank"
                                   download
                                >
                                    <span class="fas fa-download"></span>
                                </a>
                                <a class="btn btn-sm btn-outline-dark"
                                   href="{{ route('report.edit',$report) }}"
                                >
                                    <span class="fas fa-edit"></span>
                                </a>
                                </span>
                                <span class="d-md-none">
                                <a class="btn btn-sm btn-outline-dark btn-block d-flex align-items-center justify-content-between"
                                   href="{{ route('report.show',$report) }}"
                                   target="_blank"
                                >
                                    {{ __('öffnen') }}
                                    <span class="fas fa-external-link-alt ml-1"></span>
                                </a>
                                <a class="btn btn-sm btn-outline-dark btn-block d-flex align-items-center justify-content-between"
                                   href="{{ route('printReport',$report) }}"
                                   target="_blank"
                                   download
                                >
                                    {{ __('download') }}
                                    <span class="fas fa-download ml-1"></span>
                                </a>
                                <a class="btn btn-sm btn-outline-dark btn-block d-flex align-items-center justify-content-between"
                                   href="{{ route('report.edit',$report) }}"
                                >
                                    {{ __('bearbeiten') }}
                                    <span class="fas fa-edit ml-1"></span>
                                </a>
                                </span>
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
