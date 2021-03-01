@extends('layout.layout-admin')

@section('pagetitle')
{{__('Stellplatzverwaltung')}} &triangleright; {{__('Start')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('breadcrumbs')

@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

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

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Stellpätze')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-striped">
                    <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">@sortablelink('rooms.r_label', __('Raum'))</th>
                        <th>@sortablelink('sp_label', __('Nummer'))</th>
                        <th>@sortablelink('sp_name', __('Name'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('StellplatzTyp.spt_name', __('Typ'))</th>
                        <th class="d-none d-md-table-cell">{{__('Geräte') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($compartments as $compartment)
                        <tr>
                            <td class="d-none d-md-table-cell">
                                <a href="/room/{{$compartment->Room->id}}">{{ $compartment->Room->r_label  }}</a>
                            </td>
                            <td>
                                <a href="{{$compartment->path()}}">{{ $compartment->sp_label }} </a>
                            </td>
                            <td>{{ $compartment->sp_name }}</td>
                            <td class="d-none d-md-table-cell">{{ $compartment->StellplatzTyp->spt_name }}</td>
                            <td class="d-none d-md-table-cell">{{ $compartment->countTotalEquipmentInCompartment() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($compartments->count()>0)
                    <div class="d-flex justify-content-center">
                        {!! $compartments->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('autocomplete')

@endsection
