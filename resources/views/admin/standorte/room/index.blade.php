@extends('layout.layout-admin')

@section('pagetitle')
{{__('Übersicht Räume')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{__('Räume')}}</li>
        </ol>
    </nav>

@endsection

@section('actionMenuItems')

    {{--
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuRooms" role="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bars"></i> {{__('Aktionen')}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuRooms">
                    <li><a class="dropdown-item" href="/location">Übersicht</a></li>
                    <li><a class="dropdown-item" href="/location/create">Neu anlegen</a></li>
                </ul>
            </li>
    --}}

@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Räume')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-striped">
                    <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">@sortablelink('location.l_label', __('Standort'))</th>
                        <th>@sortablelink('building.b_label', __('Gebäude'))</th>
                        <th>@sortablelink('r_name', __('Raum (Name)'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('r_label', __('Nummer'))</th>
                        <th>@sortablelink('RoomType.rt_label', __('Typ'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($roomList as $room)
                        <tr>
                            <td class="d-none d-md-table-cell">
                                @if($room->building)
                                    <a href="/location/{{ $room->building->location->id??''  }}">
                                        {{ $room->building->location->l_label??''  }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($room->building)
                                    <a href="/building/{{ $room->building->id  }}">{{ $room->building->b_label  }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{$room->path()}}">
                                    {{ $room->r_name }}
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $room->r_label }}</td>
                            <td>{{ $room->RoomType->rt_label }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($roomList->count()>1)
                    <div class="d-flex justify-content-center">
                        {!! $roomList->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection


