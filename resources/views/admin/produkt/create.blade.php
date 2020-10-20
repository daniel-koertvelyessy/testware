@extends('layout.layout-admin')

@section('pagetitle')
    Neu anlegen &triangleright; Produkt @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('breadcrumbs')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Portal</a></li>
                <li class="breadcrumb-item"><a href="/produkt">Produkte</a></li>
                @if ($pk)
                <li class="breadcrumb-item"><a href="/produkt/kategorie/{{ $pk }}">{{ App\ProduktKategorie::find($pk)->pk_name_kurz }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">Neu anlegen</li>
            </ol>
        </nav>
@endsection

@section('modals')
    <div class="modal fade" id="modalAddProduktKategorie" tabindex="-1" aria-labelledby="modalAddProduktKategorieLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Neue Produkt Kategorie anlegen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createProdKat') }}"
                          method="POST" class="needs-validation"
                          id="frmAddNewProduktKategorie" name="frmAddNewProduktKategorie"
                    >
                        @csrf
                        <x-rtextfield id="pk_name_kurz" label="Name - Kürzel" />

                        <x-textfield id="pk_name_lang" label="Name" />

                        <x-textarea id="pk_name_text" label="Beschreibung" />

                        <x-btnMain>Neue Kategorie anlegen <span class="fas fa-download"></span></x-btnMain>

                </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h4">Neues @if ($pk) {{ App\ProduktKategorie::find($pk)->pk_name_kurz}} @endif Produkt anlegen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('produkt.store') }}" method="post" class="needs-validation">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="prod_name_lang" label="Bezeichnung"/>
                        </div>
                        <div class="col-md-6">
                            <label for="produkt_kategorie_id">Produkt Kategorie</label>
                            <div class="input-group">
                                <select name="produkt_kategorie_id"
                                        id="produkt_kategorie_id"
                                        class="custom-select"
                                >
                                    <option value="0">keine Zuordnung</option>
                                    @foreach (App\ProduktKategorie::all() as $produktKategorie)
                                        <option value="{{ $produktKategorie->id }}" {{ ($pk==$produktKategorie->id)? ' selected ': '' }}>{{ $produktKategorie->pk_name_kurz }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                        class="btn btn-outline-primary ml-2"
                                        data-toggle="modal" data-target="#modalAddProduktKategorie"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <x-rtextfield id="prod_name_kurz" label="Kurzbezeichnung / Spezifikation" max="20"/>
                        </div>
                        <div class="col-md-4">
                            <x-selectfield name="produkt_state_id" id="produkt_state_id" label="Produkt Status">
                                @foreach (App\ProduktState::all() as $produktState)
                                    <option value="{{ $produktState->id }}">{{ $produktState->ps_name_kurz }}</option>
                                @endforeach
                            </x-selectfield>

                        </div>
                        <div class="col-md-2 d-flex align-self-center">
                            <div class="form-check">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="prod_active" name="prod_active" checked value="1">
                                    <label class="custom-control-label" for="prod_active">Produkt aktiv</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-self-center">
                            <div class="form-check">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="control_product" name="control_product" value="1">
                                    <label class="custom-control-label" for="control_product">{{__('Ist Prüfmittel')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textfield id="prod_nummer" label="Artikel Nummer"/>

                            @foreach (App\ProduktKategorieParam::where('produkt_kategorie_id',$pk)->get() as $pkpItem)
                                <div class="form-group">
                                    <input type="hidden"
                                           name="pp_label[]"
                                           id="pp_label{{ $pkpItem->id }}"
                                           value="{{ $pkpItem->pkp_label }}"
                                    >
                                    <input type="hidden"
                                           name="pp_name[]"
                                           id="pp_name_{{ $pkpItem->id }}"
                                           value="{{ $pkpItem->pkp_name }}"
                                    >

                                    <label for="{{ $pkpItem->pkp_label }}">{{ $pkpItem->pkp_name }}</label>
                                    <input type="text" class="form-control" maxlength="150"
                                           name="pp_value[]"
                                           id="{{ $pkpItem->pkp_label }}"
                                           value="{{ old($pkpItem->pkp_label)??'' }}"
                                    >
                                    @if ($errors->has($pkpItem->pkp_label))
                                        <span class="text-danger small">{{ $errors->first($pkpItem->pkp_label) }}</span>
                                    @else
                                        <span class="small text-primary">max 100 Zeichen</span>
                                    @endif
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label for="prod_name_text">Beschreibung</label>
                                <textarea name="prod_name_text" id="prod_name_text" class="form-control" rows="3">{{ old('prod_name_text') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button @if (!config('app.makeobjekte') ) disabled @endif  class="btn btn-primary btn-block">Produkt anlegen</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#produkt_kategorie_id').change(function () {
            location.href = "{{ route('produkt.create') }}?pk=" + $('#produkt_kategorie_id :selected').val();
        })
    </script>
@endsection


