<ul class="navbar-nav mr-auto">
    <li class="nav-item {{ Request::routeIs('produkt.index') ? ' active ' : ' ' }}">
        <a class="nav-link " href="{{ route('produkt.index') }}"><i class="fas fa-boxes"></i> Übersicht
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('getKategorieProducts') ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-list-ol"></i> Kategorien</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                <li><a class="dropdown-item" href="/produkt/kategorie/{{ $produktKategorie->id }}">{{ $produktKategorie->pk_name_kurz }}</a></li>
            @endforeach
        </ul>
    </li>
    <li class="nav-item {{ Request::routeIs('produkt.create') ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAddProdukt" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-plus"></i> Neu</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAddProdukt">
            @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                <li><a class="dropdown-item" href="{{ route('produkt.create',['pk' => $produktKategorie->id]) }}">{{ $produktKategorie->pk_name_kurz }}</a></li>
            @endforeach

        </ul>
    </li>
    <li class="nav-item {{ Request::routeIs('importProdukt')  ? ' active ' : '' }}">
        <a class="nav-link " href="{{ route('importProdukt') }}"><i class="fas fa-file-import"></i> Import</a>
    </li>
    <li class="nav-item {{ Request::routeIs('exportProdukt')   ? ' active ' : '' }}">
        <a class="nav-link " href="{{ route('exportProdukt') }}"><i class="fas fa-file-export"></i> Export</a>
    </li>
</ul>


