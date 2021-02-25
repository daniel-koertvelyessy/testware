
<li class="nav-item {{ Request::routeIs('admin.index') ? ' active ' : '' }}">
    <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-clipboard-list"></i> {{__('Systemstatus')}} </a>
</li>
<li class="nav-item dropdown {{ Request::routeIs('user.*') ? ' active ' : '' }}">
    <a class="nav-link dropdown-toggle " href="#" id="navTargetAppMenuLocations" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-users"></i> {{__('Benutzer')}}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuLocations">
        <li><a class="dropdown-item" href="{{ route('user.index') }}">{{__('Übersicht')}}</a></li>
        <li><a class="dropdown-item" href="{{ route('user.create') }}">{{__('Neu anlegen')}}</a></li>
        <li><hr class="dropdown-divider"></li>
        @foreach( App\User::all() as $locItem)
            <li><a class="dropdown-item @if ( $locItem->id === Auth::user()->id)  active @endif" href="/user/{{  $locItem->id  }}">{{  $locItem->username  }}</a></li>
        @endforeach()
    </ul>
</li>
<li class="nav-item {{ Request::routeIs('systems') ? ' active ' : '' }}">
    <a class="nav-link" href="{{ route('systems') }}"><i class="fas fa-tools"></i> {{__('Einstellungen')}} </a>
</li>

