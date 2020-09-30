<div class="collapse navbar-collapse" id="basicExampleNav">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ Request::path() === '/' ? ' active  ' : '' }}">
            <a class="nav-link " href="/"><i class="fas fa-desktop"></i> Portal</a>
        </li>
        <li class="nav-item {{ Request::path() === 'docs' ? ' active ' : '' }}">
            <a class="nav-link " href="/docs/"><i class="fas fa-book"></i> Dokumentation</a>
        </li>
        <li class="nav-item {{ Request::path() === 'support' ? ' active ' : '' }}">
            <a class="nav-link" href="/support"><i class="fas fa-phone-square"></i> Hilfe anfordern</a>
        </li>
        <li class="nav-item {{ Request::path() === 'registerphone' ? ' active ' : '' }}">
            <a class="nav-link" href="/registerphone"><i class="fas fa-qrcode"></i> App aktivieren</a>
        </li>
    </ul>
    <form class="form-inline" action="#" method="get">
        <div class="md-form my-0">
            <input class="form-control form-control-sm mr-sm-2" type="text" id="kb" name="kb" placeholder="Suche" aria-label="Search">
        </div>
    </form>
</div>
