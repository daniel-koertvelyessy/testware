<ul class="navbar-nav mr-auto">

    <li class="nav-item {{ Request::is('profile')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-industry"></i> Firmen</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item" href="{{ route('profile.create') }}">Neu anlegen</a></li>
            <li class="dropdown-divider"></li>
            @foreach (\App\Firma::all() as $firma)
                <li><a class="dropdown-item" href="{{ route('firma.show',['firma' => $firma->id]) }}">{{ $firma->fa_name_kurz }}</a></li>
            @endforeach

        </ul>
    </li>

    <li class="nav-item {{ Request::is('profile')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-friends"></i> Profile</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item" href="{{ route('profile.create') }}">Neu anlegen</a></li>
            <li class="dropdown-divider"></li>
            @foreach (\App\Profile::all() as $profile)
                <li><a class="dropdown-item" href="{{ route('profile.show',['profile' => $profile->id]) }}">{{ $profile->ma_name }}</a></li>
            @endforeach

        </ul>
    </li>


{{--    <li class="nav-item {{ Request::is('material/import')  ? ' active ' : '' }}">--}}
{{--        <a class="nav-link " href="/produkt/import"><i class="fas fa-file-import"></i> Import</a>--}}
{{--    </li>--}}
{{--    <li class="nav-item {{ Request::is('material/export')   ? ' active ' : '' }}">--}}
{{--        <a class="nav-link " href="/produkt/export"><i class="fas fa-file-export"></i> Export</a>--}}
{{--    </li>--}}
</ul>


