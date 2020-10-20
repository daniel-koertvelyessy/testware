<ul class="navbar-nav mr-auto">
    <li class="nav-item {{ Request::routeIs('testware.*') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('testware.index') }}"><i class="fas fa-desktop"></i> {{__('Dashboard')}} </a>
    </li>

    <li class="nav-item {{ Request::routeIs('equipMain') || Request::routeIs('equipment.*') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('equipMain') }}"><i class="fas fa-box"></i> {{__('Geräte')}}</a>
    </li>


    <li class="nav-item {{ Request::routeIs('control.*') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('control.index') }}"><i class="fas fa-stethoscope"></i> {{__('Prüfungen')}}</a>
    </li>

</ul>


