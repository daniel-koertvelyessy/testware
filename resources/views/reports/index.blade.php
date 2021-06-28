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
        <div class="row d-none d-md-block">
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
                                <x-menu_context
                                    :object="$report"
                                    routeOpen="{{ route('report.edit',$report) }}"
                                    routeCopy="#"
                                    routeDestory="{{ route('report.destroy',$report) }}"
                                    objectName="report"
                                    objectVal="{{ $report->id }}"
                                />
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
                @if(count($reports) >0)
                    <div class="d-flex justify-content-center">
                        {!! $reports->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
                <a href="{{ route('report.create') }}"
                   class="btn btn-outline-primary my-3"
                >{{ __('Neuen Bericht erstellen') }}</a>
            </div>
        </div>
    </div>

@endsection
