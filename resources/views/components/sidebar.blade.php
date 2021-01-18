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

    <div class="dropdown-divider"></div>

    <a href="#sideNavProdukt"
       class="lead  "
       data-toggle="collapse"
       role="button"
       aria-expanded="true"
       aria-controls="sideNavProdukt"
    >{{__('Produkte')}}</a>
    <div class="collapse show"
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
       class="lead  "
       data-toggle="collapse"
       role="button"
       aria-expanded="true"
       aria-controls="sideNavVorschrfiten"
    >{{__('Vorschriften')}}</a>
    <div class="collapse show"
         id="sideNavVorschrfiten"
    >
        <ul class="nav flex-column">
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
       class="lead  "
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavOrganisation"
    >{{__('Organisation')}}</a>
    <div class="collapse"
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
       class="lead  "
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavLocations"
    >{{__('memStandorte')}}</a>
    <div class="collapse"
         id="sideNavLocations"
    >
        <ul class="nav flex-column">
            <li class="nav-item border-left ml-3">
                <a class="nav-link"
                   href="{{ route('lexplorer') }}"
                >{{__('Explorer')}}</a>
            </li>
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
        </ul>
    </div>

    <a href="#sideNavSystem"
       class="lead  "
       data-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sideNavSystem"
    >{{__('System')}}</a>
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


</aside>
