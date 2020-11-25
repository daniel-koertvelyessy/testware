@if (!isset($locations))
    @php
    $locations= App\Location::take(5)->latest()->get();
    $buildings =  App\Building::take(5)->latest()->get();
    $rooms =  App\Room::take(5)->latest()->get();
    @endphp
@endif

<li class="nav-item {{ Request::routeIs('standorteMain')  ? ' active ' : '' }}">
    <a class="nav-link " href="{{ route('standorteMain') }}">
        <i class="fas fa-desktop"></i> Start
    </a>
</li>

<li class="nav-item {{ Request::routeIs('lexplorer')  ? ' active ' : '' }}">
    <a class="nav-link " href="{{ route('lexplorer') }}">
        <i class="fas fa-project-diagram"></i> Explorer
    </a>
</li>

<li class="nav-item dropdown {{ Request::routeIs('location.*') ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle " href="#" id="navTargetAppMenuLocations" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-industry"></i> Standorte </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuLocations">
            <li><a class="dropdown-item" href="{{ route('location.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}} " href="{{ route('location.create') }}">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>
            @if(count($locations)>0)
                <h6 class="dropdown-header">Zuletzt angelegt</h6>
            @foreach( $locations as $locItem)
                <li><a class="dropdown-item @if ( isset($location) && $locItem->id === $location->id) active @endif" href="{{ route('location.show',$locItem)  }}">{{  $locItem->l_name_kurz  }}</a></li>
            @endforeach()
            @endif
        </ul>
    </li>
    <li class="nav-item dropdown {{ Request::routeIs('building.*')  ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuBuildings" role="button" data-toggle="dropdown" aria-expanded="false"><i class="far fa-building"></i> Gebäude </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuBuildings">
            <li><a class="dropdown-item" href="{{ route('building.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}} " href="{{ route('building.create') }}">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>

            @if(count($buildings)>0)
                <h6 class="dropdown-header">Zuletzt angelegt</h6>
            @foreach( $buildings as $gebItem)
                <li><a class="dropdown-item @if (isset($building) && $gebItem->id === $building->id) active @endif" href="{{ route('building.show',$gebItem) }}">{{  $gebItem->b_name_kurz  }}</a></li>
            @endforeach()
            @endif
        </ul>
    </li>
    <li class="nav-item dropdown {{ Request::routeIs('room.*')  ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuRooms" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-door-open"></i> Räume </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuRooms">
            <li><a class="dropdown-item" href="{{ route('room.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}}" href="{{ route('room.create') }}">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>
             @if(count($rooms)>0)
                <h6 class="dropdown-header">Zuletzt angelegt</h6>
            @foreach( $rooms as $roomItem)
                 <li><a class="dropdown-item @if (isset($Room) && $roomItem->id === $building->id) active @endif" href="{{ route('room.show',$roomItem) }}">{{  $roomItem->r_name_kurz  }}</a></li>
             @endforeach()
             @endif
        </ul>
    </li>
{{--<li class="nav-item {{ Request::routeIs('standortDataPort')  ? ' active ' : '' }}">--}}
{{--    <a class="nav-link " href="{{ route('standortDataPort') }}">--}}
{{--        <i class="fas fa-file-import"></i> Export / Import--}}
{{--    </a>--}}
{{--</li>--}}
