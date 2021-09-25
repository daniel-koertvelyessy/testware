@if(Auth::user())
    <ul class="navbar-nav">
        <li class="nav-item {{ Request::routeIs('firma')  ? ' active ' : '' }} dropdown dropleft">
            <a class="nav-link "
               href="#"
               id="navbarUserAccount"
               role="button"
               data-toggle="dropdown"
               aria-expanded="false"
            >
                @if (Auth::user()->unreadNotifications()->count()>0)
                    <i class="fas fa-envelope text-info"
                       title="{{ Auth::user()->unreadNotifications()->count() }} {{ __(' neue Nachrichten') }}"
                    ></i>
                @else
                    {!! Auth::user()->isSysAdmin() ? '<i class="fas fa-user-shield" title="SysAdmin-User"></i>' : '<i class="fas fa-user"></i>' !!}

                @endif
                {{ Auth::user()->username ?? Auth::user()->name }}
            </a>
            <ul class="dropdown-menu"
                aria-labelledby="navbarUserAccount"
            >
                <li>
                    <a class="dropdown-item"
                       href="/support"
                    >
                        <i class="fas fa-phone-square fa-fw mr-2"></i>
                        {{__('Hilfe anfordern')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="/"
                    >
                        <i class="fas fa-desktop fa-fw mr-2"></i>
                        {{__('Portal')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="#" data-toggle="modal" data-target="#userMsgModal"
                    >
                        <i class="fas fa-inbox fa-fw mr-2"></i>
                        <span><span class="badge badge-light ">{{ Auth::user()->unreadNotifications()->count() }}</span> {{__('Nachrichten')}}</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="#"
                       id="btnLockScreen"
                    >
                        <i class="fas fa-user-lock fa-fw mr-2"></i>
                        {{__('Bildschirm sperren')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="{{ route('user.show',Auth::user()) }}"
                       id="btnMyAccount"
                    >
                        <i class="fas fa-user fa-fw mr-2"></i>
                        {{__('Mein Konto')}}
                    </a>
                </li>
                <li>
                    <a
                        class="dropdown-item"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fas fa-sign-out-alt fa-fw mr-2"></i>
                        {{__('Abmelden')}}
                    </a>
                </li>
            </ul>


        </li>
    </ul>
    <form id="logout-form"
          action="{{ route('logout') }}"
          method="POST"
          class="d-none"
    >
        @csrf
    </form>

@else
    <ul class="navbar-nav">
        <li class="nav-item dropdown dropleft">
            <a class="nav-link "
               href="#"
               id="navbarUserAccount"
               role="button"
               data-toggle="dropdown"
               aria-expanded="false"
            >
                {{__('Sprache')}}
            </a>
            <ul class="dropdown-menu"
                aria-labelledby="navbarUserAccount"
            >
                @foreach(App\User::LOCALES as $locale)
                <li>
                    <a class="dropdown-item"
                       href="?locale={{ App\User::LANGS[$locale] }}"
                    >{{ $locale }}</a>
                </li>
                @endforeach
            </ul>
        </li>
    </ul>
@endif
