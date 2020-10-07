

<li class="nav-item {{ Request::routeIs('standorteMain')  ? ' active ' : '' }}">
    <a class="nav-link " href="{{ route('standorteMain') }}">
        <i class="fas fa-desktop"></i> Start
    </a>
</li>

<li class="nav-item dropdown {{ Request::routeIs('location.*') ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle " href="#" id="navTargetAppMenuLocations" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-industry"></i> Standorte </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuLocations">
            <li><a class="dropdown-item" href="{{ route('location.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}} " href="{{ route('location.create') }}">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>
            @php $locations = App\Location::all(); @endphp
            @if(count($locations)>0)
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
            @php $buldings = App\Building::all(); @endphp
            @if(count($buldings)>0)
            @foreach( $buldings as $gebItem)
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
            @php $rooms = App\Room::all(); @endphp
             @if(count($rooms)>0)
            @foreach( $rooms as $roomItem)
                 <li><a class="dropdown-item @if (isset($Room) && $roomItem->id === $building->id) active @endif" href="{{ route('room.show',$roomItem) }}">{{  $roomItem->r_name_kurz  }}</a></li>
             @endforeach()
             @endif
        </ul>
    </li>
