<ul class="navbar-nav mr-auto">
    <li class="nav-item {{ Request::routeIs('testware.index') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('testware.index') }}"><i class="fas fa-desktop"></i> Dashboard </a>
    </li>

    <li class="nav-item {{ Request::routeIs('equipMain') || Request::routeIs('equipment.*') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('equipMain') }}"><i class="fas fa-box"></i> Geräte</a>
    </li>


    <li class="nav-item {{ Request::routeIs('control.index') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('control.index') }}"><i class="fas fa-stethoscope"></i> Prüfungen</a>
    </li>

</ul>


