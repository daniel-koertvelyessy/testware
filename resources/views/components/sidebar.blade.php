<input data-function="swipe" id="swipe" type="checkbox">
<label class="sideIcon" data-function="swipe" for="swipe"><i class="fas fa-bars"></i></label>
<aside class="sidebar p-3" id="sideNav" style="display: flex; flex-direction: column;">
    <p class="h3  text-white">{{__('Module')}}</p>

    <a href="#sideNavSystem" class="lead text-white " data-toggle="collapse"  role="button" aria-expanded="true" aria-controls="sideNavSystem">{{__('System')}}</a>
    <div class="collapse show" id="sideNavSystem">
        <ul class="nav flex-column">
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('admin.index') }}"> {{__('Übersicht')}} </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('user.index') }}">{{__('Benutzer')}}</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('systems') }}">{{__('Einstellungen')}} </a>
            </li>
        </ul>
    </div>

    <a href="#sideNavOrganisation" class="lead text-white " data-toggle="collapse"  role="button" aria-expanded="true" aria-controls="sideNavOrganisation">{{__('Organisation')}}</a>
    <div class="collapse show" id="sideNavOrganisation">
        <ul class="nav flex-column">
            <li class="nav-item  border-left ml-3">
                <a class="nav-link " href="{{ route('organisationMain') }}">
                    Start
                </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('firma.index') }}">{{__('Firmen')}}</a>
            </li>

            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('adresse.index') }}">{{__('Adressen')}} </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('profile.index') }}">{{__('Mitarbeiter')}} </a>
            </li>
        </ul>
    </div>

    <a href="#sideNavLocations" class="lead text-white " data-toggle="collapse"  role="button" aria-expanded="true" aria-controls="sideNavLocations">{{__('Standorte')}}</a>
    <div class="collapse show" id="sideNavLocations">
        <ul class="nav flex-column">
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('location.index') }}">Standorte</a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('building.index') }}">Gebäude</a>
               {{-- <ul class="nav flex-column">
                    <li class="nav-item border-left ml-5">
                        <a class="nav-link" href="">Übersicht</a>
                    </li>
                    <li class="nav-item border-left ml-5">
                        <a class="nav-link" href="">Neu anlegen</a>
                    </li>
                </ul>--}}
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link" href="{{ route('room.index') }}">Räume</a>
            </li>
        </ul>
    </div>


    <a href="#sideNavProdukt" class="lead text-white " data-toggle="collapse"  role="button" aria-expanded="true" aria-controls="sideNavProdukt">{{__('Produkte')}}</a>
    <div class="collapse show" id="sideNavProdukt">
        <ul class="nav flex-column">
            <li class="nav-item border-left ml-3">
            <li class="nav-item  border-left ml-3">
                <a class="nav-link " href="{{ route('produktMain') }}">
                     Start
                </a>
            </li>
            <li class="nav-item border-left ml-3">
                <a class="nav-link " href="{{ route('produkt.index') }}"> Übersicht
                </a>
            </li>

        </ul>
    </div>



</aside>
