<li class="nav-item {{ Request::routeIs('report.index')  ? ' active ' : '' }}">
    <a class="nav-link" href="{{ route('report.index') }}">
        <i class="fas fa-clipboard-list"></i>
        {{__('Übersicht')}}
    </a>
</li>
<li class="nav-item {{ Request::routeIs('report.template')  ? ' active ' : '' }}">
    <a class="nav-link" href="{{ route('report.tempate') }}"><i class="fas fa-file-code"></i> {{__('Vorlagen')}} </a>
</li>
