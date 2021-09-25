{{--<div class="modal fade"
     id="modalAddNewProductCategory"
     tabindex="-1"
     aria-labelledby="modalAddNewProductCategoryLabel"
     aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modalAddNewProductCategoryLabel"
                >{{ __('Neue Produktkategorie anlegen') }}</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('createProdKat') }}#Produkte"
                      method="POST"
                      class="needs-validation"
                      id="frmAddNewProduktKategorie"
                      name="frmAddNewProduktKategorie"
                >
                    @csrf
                    <x-rtextfield id="pk_label"
                                  label="{{__('Kürzel')}}"
                    />

                    <x-textfield id="pk_name"
                                 label="{{__('Name')}}"
                    />

                    <x-textarea id="pk_description"
                                label="{{__('Beschreibung')}}"
                    />

                    <x-btnMain>{{__('Neue Kategorie anlegen')}}
                        <span class="fas fa-download ml-md-2"></span>
                    </x-btnMain>

                </form>
            </div>
        </div>
    </div>
</div>
<ul class="navbar-nav mr-auto">
--}}
    <li class="nav-item {{ Request::routeIs('produktMain')  ? ' active ' : '' }}">
        <a class="nav-link "
           href="{{ route('produktMain') }}"
        >
            <i class="fas fa-desktop"></i> {{__('Start')}}
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('produkt.index') ? ' active ' : ' ' }}">
        <a class="nav-link "
           href="{{ route('produkt.index') }}"
        ><i class="fas fa-boxes"></i> {{__('Übersicht')}}
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('getKategorieProducts') ? ' active ' : '' }} dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownAddProduktCategory"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-list-ol"></i> {{__('Kategorien')}}</a>
        <ul class="dropdown-menu"
            aria-labelledby="navbarDropdownAddProduktCategory"
        >
            <li>
                <a class="dropdown-item"
                   href="#"
                   data-toggle="modal"
                   data-target="#modalAddNewProductCategory"
                >{{ __('neue Kategorie') }}</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                <li>
                    <a class="dropdown-item"
                       href="/produkt/kategorie/{{ $produktKategorie->id }}"
                    >{{ $produktKategorie->pk_label }}</a>
                </li>
            @endforeach
        </ul>
    </li>
    @can('isAdmin', Auth::user())
        <li class="nav-item {{ Request::routeIs('produkt.create') ? ' active ' : '' }} dropdown">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="navbarDropdownAddProdukt"
               role="button"
               data-toggle="dropdown"
               aria-expanded="false"
            ><i class="fas fa-plus"></i> {{__('Neues Produkt')}}</a>
            <ul class="dropdown-menu"
                aria-labelledby="navbarDropdownAddProdukt"
            >
                <li>
                    <a class="dropdown-item"
                       href="{{ route('produkt.create') }}"
                    >{{ __('ohne Kategorie') }}</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <h6 class="dropdown-header">{{ __('Aus Katrgorie') }}</h6>
                @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('produkt.create',['pk' => $produktKategorie->id]) }}"
                        >{{ $produktKategorie->pk_label }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endcan
    {{--    <li class="nav-item {{ Request::routeIs('importProdukt')  ? ' active ' : '' }}">--}}
    {{--        <a class="nav-link " href="{{ route('importProdukt') }}"><i class="fas fa-file-import"></i> Import</a>--}}
    {{--    </li>--}}
    {{--    <li class="nav-item {{ Request::routeIs('exportProdukt')   ? ' active ' : '' }}">--}}
    {{--        <a class="nav-link " href="{{ route('exportProdukt') }}"><i class="fas fa-file-export"></i> Export</a>--}}
    {{--    </li>
</ul>--}}


