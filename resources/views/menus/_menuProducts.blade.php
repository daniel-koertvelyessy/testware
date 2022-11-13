<li class="nav-item {{ Request::routeIs('produktMain')  ? ' active ' : '' }}">
    <a class="nav-link "
       href="{{ route('produktMain') }}"
    >
        <i class="fas fa-desktop"></i> {{__('Start')}}
    </a>
</li>
<li class="nav-item {{ Request::routeIs('produkt.index') ? ' active ' : ' ' }}">
    <a class="nav-link "
       href="{{ route('produkt.index') }}"
    ><i class="fas fa-boxes"></i> {{__('Übersicht')}}
    </a>
</li>
<li class="nav-item {{ Request::routeIs('getKategorieProducts') ? ' active ' : '' }} dropdown">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="navbarDropdownAddProduktCategory"
       role="button"
       data-toggle="dropdown"
       aria-expanded="false"
    ><i class="fas fa-list-ol"></i> {{__('Kategorien')}}</a>
    <ul class="dropdown-menu"
        aria-labelledby="navbarDropdownAddProduktCategory"
    >
        @forelse (\App\ProduktKategorie::select(['id','pk_label']) as $produktKategorie)
            <li>
                <a class="dropdown-item"
                   href="/produkt/kategorie/{{ $produktKategorie->id }}"
                >{{ $produktKategorie->pk_label }}</a>
            </li>
        @empty
            <li>
                <a href="{{ route('systems') }}"
                   target="_blank"
                   class="dropdown-item"
                >Katrgorien verwalten</a>
            </li>
        @endforelse
    </ul>
</li>
@can('isAdmin', Auth::user())
    <li class="nav-item {{ Request::routeIs('produkt.create') ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownAddProdukt"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-plus"></i> {{__('Neues Produkt')}}</a>
        <ul class="dropdown-menu"
            aria-labelledby="navbarDropdownAddProdukt"
        >
            <li>
                <a class="dropdown-item"
                   href="{{ route('produkt.create') }}"
                >{{ __('ohne Kategorie') }}</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <h6 class="dropdown-header">{{ __('Aus Katrgorie') }}</h6>
            @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                <li>
                    <a class="dropdown-item"
                       href="{{ route('produkt.create',['pk' => $produktKategorie->id]) }}"
                    >{{ $produktKategorie->pk_label }}</a>
                </li>
            @endforeach
        </ul>
    </li>
@endcan



