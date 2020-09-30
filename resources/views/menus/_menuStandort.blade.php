 <li class="nav-item dropdown {{ (strpos(Request::path(), 'location')!==false) ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle " href="#" id="navTargetAppMenuLocations" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-industry"></i> Standorte </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuLocations">
            <li><a class="dropdown-item" href="/location/">Übersicht</a></li>
            <li><a class="dropdown-item" href="/location/create">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>
            @if(count(App\Location::all())>0)
            @foreach( App\Location::all() as $locItem)
                <li><a class="dropdown-item @if ( isset($location) && $locItem->id === $location->id) active @endif" href="/location/{{  $locItem->id  }}">{{  $locItem->l_name_kurz  }}</a></li>
            @endforeach()
            @endif
        </ul>
    </li>
    <li class="nav-item dropdown {{ (strpos(Request::path(), 'building')!==false)  ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuBuildings" role="button" data-toggle="dropdown" aria-expanded="false"><i class="far fa-building"></i> Gebäude </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuBuildings">
            <li><a class="dropdown-item" href="/building/">Übersicht</a></li>
            <li><a class="dropdown-item" href="/building/create">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>
            @if(count(App\Building::all())>0)
            @foreach( App\Building::all() as $gebItem)
                <li><a class="dropdown-item @if (isset($building) && $gebItem->id === $building->id) active @endif" href="/building/{{  $gebItem->id  }}">{{  $gebItem->b_name_kurz  }}</a></li>
            @endforeach()
            @endif
        </ul>
    </li>
    <li class="nav-item dropdown {{ (strpos(Request::path(), 'room')!==false)  ? ' active ' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuRooms" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-door-open"></i> Räume </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuRooms">
            <li><a class="dropdown-item" href="/room/">Übersicht</a></li>
            <li><a class="dropdown-item" href="/room/create">Neu anlegen</a></li>
            <li><hr class="dropdown-divider"></li>
             @if(count(App\Room::all())>0)
            @foreach( App\Room::all() as $roomItem)
                 <li><a class="dropdown-item @if (isset($Room) && $roomItem->id === $building->id) active @endif" href="/room/{{  $roomItem->id  }}">{{  $roomItem->r_name_kurz  }}</a></li>
             @endforeach()
             @endif
        </ul>
    </li>
