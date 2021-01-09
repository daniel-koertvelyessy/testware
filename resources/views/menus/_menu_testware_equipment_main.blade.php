<ul class="navbar-nav mr-auto">
    <li class="nav-item {{ Request::routeIs('testware.index') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('testware.index') }}"><i class="fas fa-desktop"></i> Dashboard
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('equipment.create') ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-box"></i> Geräte</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            <li>
                <a href="{{ route('equipment.index') }}" class="dropdown-item"><span class="fas fa-boxes"></span> Übersicht</a>
            </li>
            <div class="dropdown-divider"></div>
            <li>
                <span class="dropdown-item disabled" tabindex="-1" aria-disabled="true" >
                    <span class="text-primary small">Neu anlegen</span>
                </span>
            </li>
            @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                <li><a class="dropdown-item" href="{{ route('equipment.create',['pk' => $produktKategorie->id]) }}">{{ $produktKategorie->pk_label }}</a></li>
            @endforeach

        </ul>
    </li>
    <li class="nav-item {{ Request::routeIs('testing.index') ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-stethoscope"></i> Prüfungen</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            <li>
                <a href="#" class="dropdown-item"><span class="fas fa-boxes"></span> Übesicht</a>
            </li>

            <li>
                <a href="#" class="dropdown-item"><span class="fas fa-search"></span> Ausführen</a>
            </li>
        </ul>
    </li>

</ul>


