@extends('layout.layout-admin')

@section('pagetitle')
{{__('Gebäudeverwaltung')}} &triangleright; {{__('Start')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{__('Gebäude')}}</li>
        </ol>
    </nav>

@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Gebäude')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">@sortablelink('location.l_label', __('Standort'))</th>
                        <th>@sortablelink('b_label', __('Nummer'))</th>
                        <th>@sortablelink('b_name', __('Name'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('BuildingType.btname', __('Typ'))</th>
                        <th class="d-none d-md-table-cell">{{__('Räume') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($buildingList as $building)
                        <tr>
                            <td class="d-none d-md-table-cell">
                                <a href="/location/{{$building->location->id}}">{{ $building->location->l_label  }}</a>
                            </td>
                            <td>
                                <a href="{{$building->path()}}">{{ $building->b_label }} </a>
                            </td>
                            <td>{{ $building->b_name }}</td>
                            <td class="d-none d-md-table-cell">{{ $building->BuildingType->btname }}</td>
                            <td class="d-none d-md-table-cell">{{ $building->Rooms->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($buildingList->count()>0)
                    <div class="d-flex justify-content-center">
                        {!! $buildingList->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('autocomplete')

@stop


@section('actionMenuItems')
    {{--    <li class="nav-item dropdown">--}}
    {{--        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>--}}
    {{--        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">--}}
    {{--            <a class="dropdown-item" href="#">Drucke Übersicht</a>--}}
    {{--            <a class="dropdown-item" href="#">Standortbericht</a>--}}
    {{--            <a class="dropdown-item" href="#">Formularhilfe</a>--}}
    {{--        </ul>--}}
    {{--    </li>--}}
@endsection()

