@auth
    <ul class="navbar-nav">
        <li class="nav-item {{ Request::routeIs('firma')  ? ' active ' : '' }} dropdown dropleft">
            <a class="nav-link " href="#" id="navbarUserAccount" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i> {{ Auth::user()->username ?? Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarUserAccount">
                <li>
                    <a class="dropdown-item d-flex justify-content-md-between align-items-center" href="/support">
                        {{__('Hilfe anfordern')}} <i class="fas fa-phone-square ml-2"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex  justify-content-md-between align-items-center" href="/">
                        {{__('Portal')}} <i class="fas fa-desktop ml-2"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex justify-content-md-between align-items-center" href="#">
                        <span><span class="badge badge-light ">0</span> {{__('Nachrichten')}}</span> <i class="fas fa-inbox ml-2"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex justify-content-md-between align-items-center" href="#" id="btnLockScreen">
                        {{__('Bildschrim sperren')}} <i class="fas fa-user-lock ml-2"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex justify-content-md-between align-items-center" href="{{ route('user.show',Auth::user()) }}" id="btnLockScreen">
                        {{__('Mein Konto')}} <i class="fas fa-user ml-2"></i>
                    </a>
                </li>
                <li>
                    <a
                        class="dropdown-item d-flex justify-content-md-between align-items-center"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    > {{__('Abmelden')}} <i class="fas fa-sign-out-alt ml-2"></i></a>
                </li>
            </ul>


        </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@endauth
