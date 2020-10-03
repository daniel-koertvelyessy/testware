<ul class="navbar-nav mr-auto">

    <li class="nav-item {{ Request::routeIs('organisationMain')  ? ' active ' : '' }}">
        <a class="nav-link " href="{{ route('organisationMain') }}">
            <i class="fas fa-desktop"></i> Start
        </a>
    </li>

    <li class="nav-item {{ Request::routeIs('firma.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-industry"></i> Firmen</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            <li><a class="dropdown-item" href="{{ route('firma.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item" href="{{ route('firma.create') }}">Neu anlegen</a></li>
            <li class="dropdown-divider"></li>
            @foreach (\App\Firma::all() as $firma)
                <li><a class="dropdown-item" href="{{ route('firma.show',['firma' => $firma]) }}">{{ $firma->fa_name_kurz }}</a></li>
            @endforeach

        </ul>
    </li>

    <li class="nav-item {{ Request::routeIs('adresse.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdresen" role="button" data-toggle="dropdown" aria-expanded="false"><i class="far fa-address-card"></i> Adressen</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdresen">
            <li><a class="dropdown-item" href="{{ route('adresse.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item" href="{{ route('adresse.create') }}">Neu anlegen</a></li>
            <li class="dropdown-divider"></li>
            @foreach (\App\Adresse::all() as $adresse)
                <li><a class="dropdown-item" href="{{ route('adresse.show',['adresse' => $adresse]) }}">{{ $adresse->ad_name_kurz }}</a></li>
            @endforeach

        </ul>
    </li>

    <li class="nav-item {{ Request::routeIs('profile.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-friends"></i> Mitarbeiter</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Übersicht</a></li>
            <li><a class="dropdown-item" href="{{ route('profile.create') }}">Neu anlegen</a></li>
            <li class="dropdown-divider"></li>
            @foreach (\App\Profile::all() as $profile)
                <li><a class="dropdown-item" href="{{ route('profile.show',['profile' => $profile]) }}">{{ $profile->ma_name }}</a></li>
            @endforeach

        </ul>
    </li>

</ul>


