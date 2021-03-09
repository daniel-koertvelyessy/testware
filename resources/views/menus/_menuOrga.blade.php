@php
    $firmas   = App\Firma::take(5)->latest()->get();
    $adresses = App\Adresse::take(5)->latest()->get();
    $profiles = App\Profile::take(5)->latest()->get();
    $contacts = App\Contact::take(5)->latest()->get();
@endphp
<ul class="navbar-nav mr-auto">

    <li class="nav-item {{ Request::routeIs('organisationMain')  ? ' active ' : '' }}">
        <a class="nav-link "
           href="{{ route('organisationMain') }}"
        >
            <i class="fas fa-desktop"></i> {{__('Start')}}
        </a>
    </li>

    <li class="nav-item {{ Request::routeIs('firma.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownAddProdukt"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-industry"></i> {{__('Firmen')}}
        </a>
        <ul class="dropdown-menu"
            aria-labelledby="navbarDropdownAddProdukt"
        >
            <li>
                <a class="dropdown-item"
                   href="{{ route('firma.index') }}"
                >{{__('Übersicht')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                   href="{{ route('firma.create') }}"
                >{{__('Neu anlegen')}}
                </a>
            </li>
            <li class="dropdown-divider"></li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach ($firmas as $firma)
                <li>
                    <a class="dropdown-item"
                       href="{{ route('firma.show',['firma' => $firma]) }}"
                    >{{ $firma->fa_label }}</a>
                </li>
            @endforeach
        </ul>
    </li>

    <li class="nav-item {{ Request::routeIs('contact.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownContacts"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="far fa-id-badge"></i> {{__('Kontakte')}}
        </a>
        <ul class="dropdown-menu"
            aria-labelledby="navbarDropdownContacts"
        >
            <li>
                <a class="dropdown-item"
                   href="{{ route('contact.index') }}"
                >{{__('Übersicht')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                   href="{{ route('contact.create') }}"
                >{{__('Neu anlegen')}}
                </a>
            </li>
            <li class="dropdown-divider"></li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach ($contacts as $contact)
                <li>
                    <a class="dropdown-item"
                       href="{{ route('contact.show', compact('contact')) }}"
                    >{{ $contact->con_name }}</a>
                </li>
            @endforeach

        </ul>
    </li>

    <li class="nav-item {{ Request::routeIs('adresse.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownAddresses"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-map-marker-alt"></i> {{__('Adressen')}}
        </a>
        <ul class="dropdown-menu"
            aria-labelledby="navbarDropdownAddresses"
        >
            <li>
                <a class="dropdown-item"
                   href="{{ route('adresse.index') }}"
                >{{__('Übersicht')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                   href="{{ route('adresse.create') }}"
                >{{__('Neu anlegen')}}
                </a>
            </li>
            <li class="dropdown-divider"></li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach ($adresses as $adresse)
                <li>
                    <a class="dropdown-item"
                       href="{{ route('adresse.show',['adresse' => $adresse]) }}"
                    >{{ $adresse->ad_label }}</a>
                </li>
            @endforeach

        </ul>
    </li>

    <li class="nav-item {{ Request::routeIs('profile.*')  ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownAddProdukt"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="far fa-address-card"></i> {{__('Mitarbeiter')}}
        </a>
        <ul class="dropdown-menu"
            aria-labelledby="navbarDropdownAddProdukt"
        >
            <li>
                <a class="dropdown-item"
                   href="{{ route('profile.index') }}"
                >{{__('Übersicht')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                   href="{{ route('profile.create') }}"
                >{{__('Neu anlegen')}}
                </a>
            </li>
            <li class="dropdown-divider"></li>
            <h6 class="dropdown-header">{{__('Zuletzt angelegt')}}</h6>
            @foreach ($profiles as $profile)
                <li>
                    <a class="dropdown-item"
                       href="{{ route('profile.show',['profile' => $profile]) }}"
                    >{{ $profile->ma_name }}</a>
                </li>
            @endforeach

        </ul>
    </li>

</ul>


