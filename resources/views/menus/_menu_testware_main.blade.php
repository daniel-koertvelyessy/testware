<ul class="navbar-nav mr-auto">

    <li class="nav-item {{ Request::routeIs('testware.*') ? ' active ' : ' ' }}">
        <a class="nav-link "
           href="{{ route('dashboard') }}"
        ><i class="fas fa-desktop"></i> {{__('Dashboard')}} </a>
    </li>

    <li class="nav-item dropdown {{ Request::routeIs('equipMain') || Request::routeIs('equipment.*') ? ' active ' : ' ' }}">
        <a class="nav-link dropdown-toggle "
           href="#"
           id="navbarEquipmentDropdown"
           role="button"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false"
        >
            <i class="fas fa-box"></i> {{__('Geräte')}}
        </a>
        <div class="dropdown-menu"
             aria-labelledby="navbarEquipmentDropdown"
        >
            <a class="dropdown-item"
               href="{{ route('equipMain') }}"
            >{{__('Alle Geräte')}}</a>
            <a class="dropdown-item"
               href="{{ route('equipment.controlequipment') }}"
            >{{__('Prüfgeräte')}}</a>
            <a class="dropdown-item"
               href="{{ route('equipment.maker') }}"
            >{{__('Neu anlegen')}}</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">{{__('Neueste Geräte')}}</h6>
            @foreach (\App\Equipment::take(5)->latest()->get() as $equipMen)
                <a class="dropdown-item"
                   href="{{ route('equipment.show',$equipMen) }}"
                >{{ $equipMen->eq_inventar_nr }}</a>
            @endforeach
        </div>
    </li>

    <li class="nav-item {{ Request::routeIs('control.*') ? ' active ' : ' ' }}">
        <a class="nav-link "
           href="{{ route('control.index') }}"
        ><i class="fas fa-stethoscope"></i> {{__('Prüfungen')}}</a>
    </li>

    <li class="nav-item dropdown {{ Request::routeIs('event.*')  ? ' active ' : ' ' }}">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarEquipmentEventDropdown"
           role="button"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false"
        >
            <i class="fas fa-inbox"></i> {{__('Ereignisse')}} <span class="badge badge-light">{{ App\EquipmentEvent::where('read','<>',NULL)->count() }}</span>
        </a>
        <div class="dropdown-menu"
             aria-labelledby="navbarEquipmentEventDropdown"
        >
            <a class="dropdown-item"
               href="{{ route('event.index') }}"
            >{{__('Übersicht')}}</a>
            <a class="dropdown-item"
               href="{{ route('event.create') }}"
            >{{__('Neu')}}</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">{{__('Letze Ereignisse')}}</h6>
            @foreach (\App\EquipmentEvent::select(['id','created_at','read'])->take(5)->latest()->get() as $equipMen)
                <a class="dropdown-item"
                   href="{{ route('event.show',$equipMen) }}"
                >
                    <i class="far {{ $equipMen->read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                    {{ $equipMen->created_at->diffForHumans() }}
                </a>
            @endforeach
        </div>
    </li>
</ul>


