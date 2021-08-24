<aside class="sidebar p-3"
       id="sideNav"
       style="display: flex; flex-direction: column;"
>

    <span class="d-flex align-items-center justify-content-between mt-0">
        <span>{{__('Menü fixieren')}}</span>
        <div class="custom-control custom-switch">
          <input type="checkbox"
                 class="custom-control-input"
                 id="switchFixSidebar"
          >
          <label class="custom-control-label"
                 for="switchFixSidebar"
          ></label>
        </div>
    </span>

    <p class="h3"
       style="color:#c7d301;"
    >{{__('testWare')}}</p>

    <a href="{{ route('testware.index') }}"
       class=" my-2 d-flex align-items-center justify-content-between"
    >
        <span>{{__('Dashboard')}}</span> <span class="fas fa-desktop"></span>
    </a>

    <a href="{{ route('equipMain') }}"
       class=" my-2 d-flex align-items-center justify-content-between"
    >
        <span>{{__('Geräte')}}</span> <span class="fas fa-boxes"></span>
    </a>

    <a href="{{ route('control.index') }}"
       class=" my-2 d-flex align-items-center justify-content-between"
    >
        <span>{{__('Prüfungen')}}</span> <span class="fas fa-stethoscope"></span>
    </a>

    <a href="{{ route('event.index') }}"
       class=" my-2 d-flex align-items-center justify-content-between"
    >
        <span>{{__('Ereignisse')}}</span> <span class="fas fa-inbox"></span>
    </a>

    <a href="{{ route('report.index') }}"
       class=" my-2 d-flex align-items-center justify-content-between"
    >
        <span>{{__('Berichte')}}</span> <span class="fas fa-clipboard"></span>
    </a>

{{--    @can('isAdmin', Auth()->user())--}}
    <div class="dropdown-divider"></div>

    <a href="#sideNavProdukt"
       class="d-flex align-items-center justify-content-between my-2 my-md-1"
       data-toggle="collapse"
       role="button"
       aria-expanded="{{ (Request::routeIs('produktMain') or Request::routeIs('produkt.*'))  ? 'true' : 'false' }}"
       aria-controls="sideNavProdukt"
    >
        <span class="">{{__('Produkte')}}</span> <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse {{ (Request::routeIs('produktMain') or Request::routeIs('produkt.*'))  ? ' show ' : '' }}"
         id="sideNavProdukt"
    >
        <ul class="nav flex-column">
            <li class="nav-item  border-left ml-3">
                <a class="nav-link "
                   href="{{ route('produktMain') }}"
                > {{__('Start')}}
                </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link "
                   href="{{ route('produkt.index') }}"
                > {{__('Übersicht')}}
                </a>
            </li>

        </ul>
    </div>

    <a href="#sideNavVorschrfiten"
       class="d-flex align-items-center justify-content-between my-2 my-md-1"
       data-toggle="collapse"
       role="button"
       aria-expanded="{{ Request::routeIs('verordnung.*') ? ' true ' : '' }}"
       aria-controls="sideNavVorschrfiten"
    ><span class="">{{__('Vorschriften')}}</span> <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse {{ (Request::routeIs('verordnung.*') or Request::routeIs('anforderung.*') or Request::routeIs
    ('anforderungcontrolitem.*'))? ' show ' : '' }}"
         id="sideNavVorschrfiten"
    >
        <ul class="nav flex-column">
            <li class="nav-item  border-left ml-3">
                <a class="nav-link "
                   href="{{ route('verordnung.main') }}"
                > {{__('Start')}}
                </a>
            </li>
            <li class="nav-item  border-left ml-3">
                <a class="nav-link "
                   href="{{ route('verordnung.index') }}"
                > {{__('Verordnungen')}}
                </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link "
                   href="{{ route('anforderung.index') }}"
                > {{__('Anforderungen')}}
                </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link "
                   href="{{ route('anforderungcontrolitem.index') }}"
                > {{__('Vorgänge')}}
                </a>
            </li>
        </ul>
    </div>

    <a href="#sideNavOrganisation"
       class="d-flex align-items-center justify-content-between my-2 my-md-1"
       data-toggle="collapse"
       role="button"
       aria-expanded="{{ (
                            Request::routeIs('organisationMain') or
                            Request::routeIs('firma.*') or
                            Request::routeIs('contact.*') or
                            Request::routeIs('adresse.*') or
                            Request::routeIs('profile.*')

                            )? ' true ' : 'false' }}"
       aria-controls="sideNavOrganisation"
    >
        <span class="">{{__('Organisation')}}</span> <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse {{ (
                            Request::routeIs('organisationMain') or
                            Request::routeIs('firma.*') or
                            Request::routeIs('contact.*') or
                            Request::routeIs('adresse.*') or
                            Request::routeIs('profile.*')

                            )? ' show ' : '' }}"
         id="sideNavOrganisation"
    >
        <ul class="nav flex-column">
            <li class="nav-item  border-left ml-3">
                <a class="nav-link "
                   href="{{ route('organisationMain') }}"
                > {{__('Start')}}
                </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('firma.index') }}"
                >{{__('Firmen')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('contact.index') }}"
                >{{__('Kontakte')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('adresse.index') }}"
                >{{__('Adressen')}} </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('profile.index') }}"
                >{{__('Mitarbeiter')}} </a>
            </li>
        </ul>
    </div>

    <a href="#sideNavLocations"
       class="d-flex align-items-center justify-content-between my-2 my-md-1"
       data-toggle="collapse"
       role="button"
       aria-expanded="{{ (
    Request::routeIs('storageMain')
    or Request::routeIs('lexplorer')
    or Request::routeIs('location.*')
    or Request::routeIs('building.*')
    or Request::routeIs('room.*')
    or Request::routeIs('stellplatz.*')
    )  ? 'true' : 'false' }}"
       aria-controls="sideNavLocations"
    >
        <span class="">{{__('memStandorte')}}</span> <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse {{ (
    Request::routeIs('storageMain')
    or Request::routeIs('lexplorer')
    or Request::routeIs('location.*')
    or Request::routeIs('building.*')
    or Request::routeIs('room.*')
    or Request::routeIs('stellplatz.*')
    )  ? ' show ' : '' }}"
         id="sideNavLocations"
    >
        <ul class="nav flex-column">
            <li class="nav-item  border-left ml-3">
                <a class="nav-link "
                   href="{{ route('storageMain') }}"
                > {{__('Start')}}
                </a>
            </li>
            @can('isAdmin', Auth::user())
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('lexplorer') }}"
                >{{__('Explorer')}}</a>
            </li>
            @endcan
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('location.index') }}"
                >{{__('Standorte')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('building.index') }}"
                >{{__('Gebäude')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('room.index') }}"
                >{{__('Räume')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('stellplatz.index') }}"
                >{{__('Stellplätze')}}</a>
            </li>

        </ul>
    </div>

    <a href="#sideNavSystem"
       class="d-flex align-items-center justify-content-between my-2 my-md-1"
       data-toggle="collapse"
       role="button"
       aria-expanded="{{ (
    Request::routeIs('systems')
    or Request::routeIs('admin.*')
    or Request::routeIs('user.*')
    )  ? ' true ' : ' false ' }}"
       aria-controls="sideNavSystem"
    >
        <span class="">{{__('System')}}</span> <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse {{ (
    Request::routeIs('systems')
    or Request::routeIs('admin.*')
    or Request::routeIs('user.*')
    )  ? ' show ' : '' }}"
         id="sideNavSystem"
    >
        <ul class="nav flex-column">
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('admin.index') }}"
                > {{__('Übersicht')}} </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('user.index') }}"
                >{{__('Benutzer')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('systems') }}"
                >{{__('Einstellungen')}} </a>
            </li>
        </ul>
    </div>

{{--    @endcan--}}

</aside>
