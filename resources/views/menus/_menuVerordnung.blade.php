


<li class="nav-item {{ Request::is('verordnung.main') ? ' active ' : '' }}">
    <a class="nav-link" href="{{ route('verordnung.main') }}"><i class="fas fa-chalkboard"></i> {{__('Start')}} </a>
</li>
<li class="nav-item dropdown {{ !Request::is('verordnung.main') && Request::routeIs('verordnung.*') ? ' active ' : ''}}">
    <a class="nav-link dropdown-toggle " href="#" id="navTargetAppVerordnungen" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-book"></i> {{__('Verordnungen')}}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navTargetAppVerordnungen">
        <li><a class="dropdown-item" href="{{ route('verordnung.index') }}">{{__('Übersicht')}}</a></li>
        <li><a class="dropdown-item" href="{{ route('verordnung.create') }}">{{__('Neu anlegen')}}</a></li>
        <li><hr class="dropdown-divider"></li>
        @foreach( App\Verordnung::take(5)->latest()->get() as $verordnungItem)
            <li><a class="dropdown-item" href="{{ route('verordnung.show',$verordnungItem) }}">{{  $verordnungItem->vo_name_kurz  }}</a></li>
        @endforeach()
    </ul>
</li>

<li class="nav-item dropdown {{ Request::routeIs('anforderung.*') ? ' active ' : ''}}">
    <a class="nav-link dropdown-toggle " href="#" id="navTargetAppAnforderung" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="far fa-list-alt"></i> {{__('Anforderungen')}}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navTargetAppAnforderung">
        <li><a class="dropdown-item" href="{{ route('anforderung.index') }}">{{__('Übersicht')}}</a></li>
        <li><a class="dropdown-item" href="{{ route('anforderung.create') }}">{{__('Neu anlegen')}}</a></li>
        <li><hr class="dropdown-divider"></li>
        @foreach( App\Anforderung::take(5)->latest()->get() as $anforderungItem)
            <li><a class="dropdown-item" href="{{ route('anforderung.show',$anforderungItem) }}">{{  $anforderungItem->an_name_kurz  }}</a></li>
        @endforeach()
    </ul>
</li>

<li class="nav-item dropdown {{ Request::routeIs('anforderungcontrolitem.*') ? ' active ' : ''}}">
    <a class="nav-link dropdown-toggle " href="#" id="navTargetAppACI" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-tasks"></i> {{__('Vorgänge')}}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navTargetAppACI">
        <li><a class="dropdown-item" href="{{ route('anforderungcontrolitem.index') }}">{{__('Übersicht')}}</a></li>
        <li><a class="dropdown-item" href="{{ route('anforderungcontrolitem.create') }}">{{__('Neu anlegen')}}</a></li>
        <li><hr class="dropdown-divider"></li>
        @foreach( App\AnforderungControlItem::take(5)->latest()->get() as $anforderungItem)
            <li><a class="dropdown-item" href="{{ route('anforderungcontrolitem.show',$anforderungItem) }}">{{  $anforderungItem->aci_name_lang  }}</a></li>
        @endforeach()
    </ul>
</li>
