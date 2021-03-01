@php
    $locations= App\Location::take(5)->latest()->get();
    $buildings =  App\Building::take(5)->latest()->get();
    $rooms =  App\Room::take(5)->latest()->get();
    $compartments =  App\Stellplatz::take(5)->latest()->get()
@endphp
<li class="nav-item {{ Request::routeIs('storageMain')  ? ' active ' : '' }}">
    <a class="nav-link "
       href="{{ route('storageMain') }}"
    >
        <i class="fas fa-desktop"></i> Start
    </a>
</li>

<li class="nav-item {{ Request::routeIs('lexplorer')  ? ' active ' : '' }}">
    <a class="nav-link "
       href="{{ route('lexplorer') }}"
    >
        <i class="fas fa-project-diagram"></i> Explorer
    </a>
</li>

<li class="nav-item dropdown {{ Request::routeIs('location.*') ? ' active ' : '' }}">
    <a class="nav-link dropdown-toggle "
       href="#"
       id="navTargetAppMenuLocations"
       role="button"
       data-toggle="dropdown"
       aria-expanded="false"
    ><i class="fas fa-industry"></i> {{__('Standorte')}} </a>
    <ul class="dropdown-menu"
        aria-labelledby="navTargetAppMenuLocations"
    >
        <li>
            <a class="dropdown-item "
               href="{{ route('location.index') }}"
            >
                <i class="fas fa-list mr-2 fa-fw"></i>
                {{__('Übersicht')}}
            </a>
        </li>
        <li>
            <a class="dropdown-item "
               href="{{ route('location.create') }}"
            >
                <i class="far fa-file mr-2 fa-fw"></i>
                {{__('Neu anlegen')}}
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        @if(count($locations)>0)
            <li>
                <a class="dropdown-item "
                   href="{{ route('exportjson.locations') }}"
                >
                    <i class="fas fa-file-export mr-2 fa-fw"></i>
                    {{__('Standorte')}} {{ __('exportieren') }}
                </a>
            </li>
            <h6 class="dropdown-header">Zuletzt angelegt</h6>
            @foreach( $locations as $locItem)
                <li>
                    <a class="dropdown-item @if ( isset($location) && $locItem->id === $location->id) active @endif"
                       href="{{ route('location.show',$locItem)  }}"
                    >{{  $locItem->l_label  }}</a>
                </li>
            @endforeach()

        @endif
    </ul>
</li>
<li class="nav-item dropdown {{ Request::routeIs('building.*')  ? ' active ' : '' }}">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="navTargetAppMenuBuildings"
       role="button"
       data-toggle="dropdown"
       aria-expanded="false"
    ><i class="far fa-building"></i> {{__('Gebäude')}} </a>
    <ul class="dropdown-menu"
        aria-labelledby="navTargetAppMenuBuildings"
    >
        <li>
            <a class="dropdown-item"
               href="{{ route('building.index') }}"
            >{{__('Übersicht')}}</a>
        </li>
        <li>
            <a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}} "
               href="{{ route('building.create') }}"
            >{{__('Neu anlegen')}}</a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        @if(count($buildings)>0)
            <li>
                <a class="dropdown-item "
                   href="{{ route('exportjson.buildings') }}"
                >
                    <i class="fas fa-file-export mr-2 fa-fw"></i>
                    {{__('Gebäude')}} {{ __('exportieren') }}
                </a>
            </li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach( $buildings as $gebItem)
                <li>
                    <a class="dropdown-item @if (isset($building) && $gebItem->id === $building->id) active @endif"
                       href="{{ route('building.show',$gebItem) }}"
                    >{{  $gebItem->b_label  }}</a>
                </li>
            @endforeach()
        @endif
    </ul>
</li>
<li class="nav-item dropdown {{ Request::routeIs('room.*')  ? ' active ' : '' }}">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="navTargetAppMenuRooms"
       role="button"
       data-toggle="dropdown"
       aria-expanded="false"
    ><i class="fas fa-door-open"></i> {{__('Räume')}} </a>
    <ul class="dropdown-menu"
        aria-labelledby="navTargetAppMenuRooms"
    >
        <li>
            <a class="dropdown-item"
               href="{{ route('room.index') }}"
            >{{__('Übersicht')}}</a>
        </li>
        <li>
            <a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}}"
               href="{{ route('room.create') }}"
            >{{__('Neu anlegen')}}</a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        @if(count($rooms)>0)
            <li>
                <a class="dropdown-item "
                   href="{{ route('exportjson.rooms') }}"
                >
                    <i class="fas fa-file-export mr-2 fa-fw"></i>
                    {{__('Räume')}} {{ __('exportieren') }}
                </a>
            </li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach( $rooms as $roomItem)
                <li>
                    <a class="dropdown-item @if (isset($Room) && $roomItem->id === $building->id) active @endif"
                       href="{{ route('room.show',$roomItem) }}"
                    >{{  $roomItem->r_label  }}</a>
                </li>
            @endforeach()
        @endif
    </ul>
</li>
<li class="nav-item dropdown {{ Request::routeIs('stellplatz.*')  ? ' active ' : '' }}">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="navTargetAppMenuCompartments"
       role="button"
       data-toggle="dropdown"
       aria-expanded="false"
    ><i class="fas fa-inbox"></i> {{__('Stellplätze')}} </a>
    <ul class="dropdown-menu"
        aria-labelledby="navTargetAppMenuCompartments"
    >
        <li>
            <a class="dropdown-item"
               href="{{ route('stellplatz.index') }}"
            >{{__('Übersicht')}}</a>
        </li>
        <li>
            <a class="dropdown-item {{--@if (!env('app.makeobjekte') ) disabled @endif --}}"
               href="{{ route('stellplatz.create') }}"
            >{{__('Neu anlegen')}}</a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        @if(count($compartments)>0)
            <li>
                <a class="dropdown-item "
                   href="{{ route('exportjson.compartments') }}"
                >
                    <i class="fas fa-file-export mr-2 fa-fw"></i>
                    {{__('Stellplätze')}} {{ __('exportieren') }}
                </a>
            </li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach( $compartments as $compartment)
                <li>
                    <a class="dropdown-item @if (isset($stellplatz) && $compartment->id === $stellplatz->id) active @endif"
                       href="{{ route('stellplatz.show',$compartment) }}"
                    >{{  $compartment->sp_label  }}</a>
                </li>
            @endforeach()
        @endif
    </ul>
</li>

{{--<li class="nav-item {{ Request::routeIs('storageDataPort')  ? ' active ' : '' }}">--}}
{{--    <a class="nav-link " href="{{ route('storageDataPort') }}">--}}
{{--        <i class="fas fa-file-import"></i> Export / Import--}}
{{--    </a>--}}
{{--</li>--}}
