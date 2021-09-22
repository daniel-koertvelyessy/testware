<aside class="sidebar p-3"
       id="sideNav"
       style="display: flex; flex-direction: column;"
>

    <p class="h3 d-md-inline d-none"
       style="color:#c7d301;"
    >{{__('testWare')}}</p>

    <div class="align-items-center d-flex flex-column flex-md-row justify-content-center justify-content-md-start my-md-2 my-3">
        <a href="{{ route('testware.index') }}">
            <span class="fas fa-fw fa-desktop mr-md-4"></span> <span class="d-md-inline d-none ">{{__('Dashboard')}}</span>
        </a>
        <span class="small d-md-none">{{__('Dashboard')}}</span>
    </div>

    <div class="align-items-center d-flex flex-column flex-md-row justify-content-center justify-content-md-start my-md-2 my-3">
        <a href="{{ route('equipMain') }}">
            <span class="fas fa-fw fa-boxes mr-md-4"></span> <span class="d-md-inline d-none ">{{__('Geräte')}}</span>
        </a>
        <span class="small d-md-none">{{__('Geräte')}}</span>
    </div>

    <div class="align-items-center d-flex flex-column flex-md-row justify-content-center justify-content-md-start my-md-2 my-3">
        <a href="{{ route('control.index') }}">
            <span class="fas fa-fw fa-stethoscope mr-md-4"></span> <span class="d-md-inline d-none ">{{__('Prüfungen')}}</span>
        </a>
        <span class="small d-md-none">{{__('Prüfungen')}}</span>
    </div>

    <div class="align-items-center d-flex flex-column flex-md-row justify-content-center justify-content-md-start my-md-2 my-3">
        <a href="{{ route('event.index') }}">
            <span class="fas fa-fw fa-inbox mr-md-4"></span> <span class="d-md-inline d-none ">{{__('Ereignisse')}}</span>
        </a>
        <span class="small d-md-none">{{__('Ereignisse')}}</span>
    </div>

    <div class="align-items-center d-flex flex-column flex-md-row justify-content-center justify-content-md-start my-md-2 my-3">
        <a href="{{ route('report.index') }}">
            <span class="fas fa-fw fa-clipboard mr-md-4"></span> <span class="d-md-inline d-none ">{{__('Berichte')}}</span>
        </a>
        <span class="small d-md-none">{{__('Berichte')}}</span>
    </div>

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
            <i class="fas fa-fw fa-boxes mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('Produkte')}}</span>
        </span> <span class="fas fa-ellipsis-v"></span>
    </a>

    <div class="collapse"
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
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavVorschrfiten"
    >
        <span>
            <i class="fas fa-fw fa-scroll mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('Vorschriften')}}</span>
        </span>

        <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
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
                > {{__('Prüfschritte')}}
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
            <i class="fas fa-fw fa-users mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('Organisation')}}</span>
        </span>

        <span class="fas fa-ellipsis-v"></span>
    </a>
    {{--    {{ (  Request::routeIs('organisationMain') or Request::routeIs('firma.*') or Request::routeIs('contact.*') or Request::routeIs('adresse.*') or Request::routeIs('profile.*' )? ' show ' : '' }}--}}
    <div class="collapse"
         id="sideNavOrganisation"
    >
        <ul class="nav flex-column">
            <li class="nav-item border-left ml-3">
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
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavLocations"
    >
        <span>
            <i class="fas fa-fw fa-industry mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('memStandorte')}}</span>
        </span>

        <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
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
       class="d-flex align-items-center justify-content-between my-2 my-md-2 mb-md-2"
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavSystem"
    >
        <span>
            <i class="fas fa-fw fa-user-cog mr-2 mr-md-4"></i>
            <span class="d-md-inline d-none">{{__('System')}}</span>
        </span> <span class="fas fa-ellipsis-v"></span>
    </a>
    <div class="collapse"
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
    <span class="d-flex align-items-center justify-content-start mt-3">

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

    {{--    @endcan--}}

</aside>
