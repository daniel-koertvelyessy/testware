@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neu anlegen')}} &triangleright; {{__('Produkt')}}
@endsection

@section('mainSection')
    {{__('Neues Produkt anlegen')}}
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('produkt.index') }}">{{__('Produkte')}}</a>
            </li>
            @if ($pk)
                <li class="breadcrumb-item align-items-center">
                    <span class="text-muted">
                        {{ __('Kategorie') }} <span class="fas fa-angle-right mx-1"></span>
                    </span>
                    <a href="/produkt/kategorie/{{ $pk }}">{{ App\ProduktKategorie::find($pk)->pk_label }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{__('Neu anlegen')}}</li>
        </ol>
    </nav>
@endsection

@section('modals')
    <div class="modal fade"
         id="modalAddProduktKategorie"
         tabindex="-1"
         aria-labelledby="modalAddProduktKategorieLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Neue Produkt Kategorie anlegen')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createProdKat') }}"
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

                        <x-btnMain>{{__('Neue Kategorie anlegen')}} <span class="fas fa-download ml-2"></span></x-btnMain>

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
                <h1 class="h4">{{__('Neues Produkt anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('produkt.store') }}"
                      method="post"
                      class="needs-validation"
                >
                    @csrf
                    <x-frm_AddProdukt :pk="$pk"/>
                    <button class="btn btn-primary">{{__('Produkt anlegen')}} <i class="fas fa-download ml-2"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
