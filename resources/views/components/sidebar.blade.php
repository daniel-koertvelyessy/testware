<aside class="sidebar p-3"
       id="sideNav"
       style="display: flex; flex-direction: column;"
>

    <span class="d-flex align-items-center justify-content-start mt-0">

        <div class="custom-control custom-switch">
          <input type="checkbox"
                 class="custom-control-input"
                 id="switchFixSidebar"
          >
          <label class="custom-control-label"
                 for="switchFixSidebar"
          ></label>
        </div>

        <span class="d-md-inline d-none ">{{__('Menü fixieren')}}</span>
    </span>

    <p class="h3 d-md-inline d-none"
       style="color:#c7d301;"
    >{{__('testWare')}}</p>

    <a href="{{ route('testware.index') }}"
       class=" my-2 d-flex align-items-center justify-content-start"
    >
        <span class="fas fa-desktop mr-2 mr-md-4"></span>
        <span class="d-md-inline d-none ">{{__('Dashboard')}}</span>
    </a>

    <a href="{{ route('equipMain') }}"
       class=" my-2 d-flex align-items-center justify-content-start"
    >
        <span class="fas fa-boxes mr-2 mr-md-4"></span>
        <span class="d-md-inline d-none ">{{__('Geräte')}}</span>
    </a>

    <a href="{{ route('control.index') }}"
       class=" my-2 d-flex align-items-center justify-content-start"
    >
        <span class="fas fa-stethoscope mr-2 mr-md-4"></span>
        <span class="d-md-inline d-none ">{{__('Prüfungen')}}</span>
    </a>

    <a href="{{ route('event.index') }}"
       class=" my-2 d-flex align-items-center justify-content-start"
    >
        <span class="fas fa-inbox mr-2 mr-md-4"></span>
        <span class="d-md-inline d-none ">{{__('Ereignisse')}}</span>
    </a>

    <a href="{{ route('report.index') }}"
       class=" my-2 d-flex align-items-center justify-content-start"
    >
        <span class="fas fa-clipboard mr-2 mr-md-4"></span>
        <span class="d-md-inline d-none ">{{__('Berichte')}}</span>
    </a>

{{--    @can('isAdmin', Auth()->user())--}}
    <div class="dropdown-divider"></div>

    <a href="#sideNavProdukt"
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavProdukt"
    >
        <span>
            <i class="fas fa-boxes mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('Produkte')}}</span>
        </span>
         <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
         id="sideNavProdukt"
    >
        <ul class="nav flex-column">
            <li class="nav-item  bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('produktMain') }}"
                > {{__('Start')}}
                </a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('produkt.index') }}"
                > {{__('Übersicht')}}
                </a>
            </li>

        </ul>
    </div>

    <a href="#sideNavVorschrfiten"
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavVorschrfiten"
    >
        <span>
            <i class="fas fa-scroll mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('Vorschriften')}}</span>
        </span>

        <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
         id="sideNavVorschrfiten"
    >
        <ul class="nav flex-column">
            <li class="nav-item  bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('verordnung.main') }}"
                > {{__('Start')}}
                </a>
            </li>
            <li class="nav-item  bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('verordnung.index') }}"
                > {{__('Verordnungen')}}
                </a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('anforderung.index') }}"
                > {{__('Anforderungen')}}
                </a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('anforderungcontrolitem.index') }}"
                > {{__('Vorgänge')}}
                </a>
            </li>
        </ul>
    </div>

    <a href="#sideNavOrganisation"
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavOrganisation"
    >
        <span>
            <i class="fas fa-users mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('Organisation')}}</span>
        </span>

        <span class="fas fa-ellipsis-v"></span>
    </a>
{{--    {{ (  Request::routeIs('organisationMain') or Request::routeIs('firma.*') or Request::routeIs('contact.*') or Request::routeIs('adresse.*') or Request::routeIs('profile.*' )? ' show ' : '' }}--}}
    <div class="collapse"
         id="sideNavOrganisation"
    >
        <ul class="nav flex-column">
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('organisationMain') }}"
                > {{__('Start')}}
                </a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('firma.index') }}"
                >{{__('Firmen')}}</a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('contact.index') }}"
                >{{__('Kontakte')}}</a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('adresse.index') }}"
                >{{__('Adressen')}} </a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('profile.index') }}"
                >{{__('Mitarbeiter')}} </a>
            </li>
        </ul>
    </div>

    <a href="#sideNavLocations"
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavLocations"
    >
        <span>
            <i class="fa fa-industry mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('memStandorte')}}</span>
        </span>

        <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
         id="sideNavLocations"
    >
        <ul class="nav flex-column">
            <li class="nav-item  bg-white border-left ml-3">
                <a class="nav-link "
                   href="{{ route('storageMain') }}"
                > {{__('Start')}}
                </a>
            </li>
            @can('isAdmin', Auth::user())
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('lexplorer') }}"
                >{{__('Explorer')}}</a>
            </li>
            @endcan
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('location.index') }}"
                >{{__('Standorte')}}</a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('building.index') }}"
                >{{__('Gebäude')}}</a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('room.index') }}"
                >{{__('Räume')}}</a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('stellplatz.index') }}"
                >{{__('Stellplätze')}}</a>
            </li>

        </ul>
    </div>

    <a href="#sideNavSystem"
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavSystem"
    >
        <span>
            <i class="fas fa-user-cog mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('System')}}</span>
        </span>
        <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
         id="sideNavSystem"
    >
        <ul class="nav flex-column">
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('admin.index') }}"
                > {{__('Übersicht')}} </a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('user.index') }}"
                >{{__('Benutzer')}}</a>
            </li>
            <li class="nav-item bg-white border-left ml-3">
                <a class="nav-link"
                   href="{{ route('systems') }}"
                >{{__('Einstellungen')}} </a>
            </li>
        </ul>
    </div>

{{--    @endcan--}}

</aside>
