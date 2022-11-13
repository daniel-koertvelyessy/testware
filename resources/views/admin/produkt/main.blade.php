@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Start')}} &triangleright; {{__('Produkte')}}@endsection

@section('mainSection')
    <span class="d-md-block d-none">{{__('Produktverwaltung')}}</span>
    <span class="d-md-none">{{ __('Produkte') }}</span>
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('modals')

    <div class="modal fade"
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

@endsection

@section('content')

    <div class="container">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h4">{{__('Produktverwaltung')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}:</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <nav class="justify-content-around flex-md-column flex-sm-row mb-3">
                    <a href="{{ route('produkt.index') }}"
                       class="tile-small btn-outline-primary rounded mb-lg-3 mb-2"
                       data-role="tile"
                    >
                        <span class="icon"><i class="fas fa-boxes"></i></span>
                        <span class="branding-bar text-center">{{__('Übersicht')}}</span>
                    </a>

                    <a href="{{ route('produkt.create') }}"
                       class="tile-small btn-outline-primary rounded mb-lg-3 mb-2"
                       data-role="tile"
                    >
                        <span class="icon"><i class="fas fa-box"></i></span>
                        <span class="branding-bar text-center">{{__('Neu')}}</span>
                    </a>

                </nav>
            </div>
            <div class="col-md-10">
                <h3 class="h5">{{__('Kürzlich erstellte Produkte')}}</h3>
                <table class="table table-striped"
                       id="tabProduktListe"
                >
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($produkts as $produkt)
                        <tr>
                            <td>
                                <a href="{{ route('produkt.show',$produkt) }}">{{ $produkt->prod_name }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $produkt->prod_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Produkte angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @can('isAdmin', Auth::user())
            <div class="d-flex align-items-center justify-content-between my-3">
                <h3 class="h4">{{__('Neues Produkt aus Kategorie erstellen')}}</h3>
                <button class="btn btn-sm btn-outline-primary"
                        data-toggle="modal"
                        data-target="#modalAddNewProductCategory"
                >{{ __('neue Kategorie') }}
                    <i class="fas fa-angle-double-right ml-1"></i>
                </button>
            </div>

            <div class="row">
                <div class="col">
                    @php $produktKategories = App\ProduktKategorie::all(); @endphp
                    <nav class="tiles-grid">
                        @foreach ($produktKategories as $produktKategorie)
                            <a href="{{ route('produkt.create',['pk'=> $produktKategorie->id]) }}"
                               class="tile-small btn-outline-primary rounded mr-lg-3 mr-sm-2"
                               data-role="tile"
                            >
                                <span class="icon"><i class="fas fa-box"></i></span>
                                <span class="branding-bar text-center">{{$produktKategorie->pk_label}}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        @endcan
    </div>

@endsection
