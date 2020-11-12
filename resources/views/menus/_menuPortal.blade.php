
    <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ Request::path() === '/' ? ' active  ' : '' }}">
            <a class="nav-link " href="/"><i class="fas fa-desktop"></i> {{__('Portal')}}</a>
        </li>
        <li class="nav-item {{ Request::path() === 'docs' ? ' active ' : '' }}">
            <a class="nav-link " href="/docs/"><i class="fas fa-book"></i> {{__('Dokumentation')}}</a>
        </li>
        <li class="nav-item {{ Request::path() === 'support' ? ' active ' : '' }}">
            <a class="nav-link" href="/support"><i class="fas fa-phone-square"></i> {{__('Hilfe anfordern')}}</a>
        </li>
        <li class="nav-item {{ Request::path() === 'registerphone' ? ' active ' : '' }}">
            <a class="nav-link" href="/registerphone"><i class="fas fa-qrcode"></i> {{__('App aktivieren')}}</a>
        </li>
    </ul>
{{--    <form class="form-inline" action="#" method="get">
        <div class="md-form my-0">
            <input class="form-control form-control-sm mr-sm-2" type="text" id="kb" name="kb" placeholder="{{__('Suche')}}" aria-label="{{__('Suche')}}">
        </div>
    </form>--}}

