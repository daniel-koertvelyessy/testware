@extends('layout.layout-admin')

@section('pagetitle')
    Produkt {{ $produkt->prod_nummer }} bearbeiten &triangleright; Produkte @ bitpack GmbH
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
            <li class="breadcrumb-item">
                <a href="/">Portal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('produkt.index') }}">Produkte</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/produkt/kategorie/{{ $produkt->ProduktKategorie->id }}">{{ $produkt->ProduktKategorie->pk_name_kurz }}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{ $produkt->prod_nummer }}</li>
        </ol>
    </nav>
@endsection

@section('actionMenuItems')
    <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navTargetAppAktionItems"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-bars"></i> {{__('Produkt')}} </a>
        <ul class="dropdown-menu"
            aria-labelledby="navTargetAppAktionItems"
        >
            <a class="dropdown-item"
               href="#"
               data-toggle="modal"
               data-target="#modalAddParameter"
            ><i class="fas fa-table"></i> {{__('Datenfeld hinzufügen')}}</a>
            <a class="dropdown-item"
               href="#"
               data-toggle="modal"
               data-target="#modalDeleteProdukt"
            ><i class="far fa-trash-alt"></i> {{__('Produkt löschen')}}</a>
        </ul>
    </li>
@endsection

@section('modals')

    <div class="modal"
         id="modalAddDokumentType"
         tabindex="-1"
         aria-labelledby="modalAddDokumentTypeLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createDokumentType') }}"
                      method="POST"
                      class="needs-validation"
                      id="frmAddNewDokumentenTyp"
                      name="frmAddNewDokumentenTyp"
                >
                    @csrf
                    <input type="hidden"
                           name="origin"
                           id="origin"
                           value="materials"
                    >
                    <input type="hidden"
                           name="material_id"
                           id="material_id"
                           value="{{ $produkt->id }}"
                    >
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Neuen Dokumententyp anlegen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <x-textfield id="doctyp_name_kurz"
                                             label="{{__('Kürzel')}}"
                                             required
                                />
                                <x-textfield id="doctyp_name_lang"
                                             label="{{__('Bezeichnung')}}"
                                />
                                <x-textarea id="doctyp_name_text"
                                            label="{{__('Beschreibung')}}"
                                />
                                <div class="form-group">
                                    <p class="lead">{{__('Dokument ist Pflichtteil einer Verordnung')}}</p>
                                    <div class="pl-3">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="doctyp_mandatory"
                                                   id="doctyp_mandatory_ja"
                                                   value="1"
                                            >
                                            <label class="form-check-label"
                                                   for="doctyp_mandatory_ja"
                                            > {{__('ist Teil einer Verordnung')}}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="doctyp_mandatory"
                                                   id="doctyp_mandatory_nein"
                                                   value="0"
                                                   checked
                                            >
                                            <label class="form-check-label"
                                                   for="doctyp_mandatory_nein"
                                            > {{__(' kein Pflichtteil')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Speichern')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal"
         id="modalAddParameter"
         tabindex="-1"
         aria-labelledby="modalAddParameter"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
            <div class="modal-content">
                <form action="{{ route('addProduktParams') }}"
                      method="POST"
                      class="needs-validation"
                      id="frmAddProdParam"
                      name="frmAddProdParam"
                >
                    @csrf
                    <input type="hidden"
                           name="produkt_id"
                           id="produkt_id_param"
                           value="{{ $produkt->id }}"
                    >
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Neues Feld für Stammdaten anlegen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <x-textfield id="pp_label"
                                             label="{{__('Label')}}"
                                />
                                <x-textfield id="pp_name"
                                             label="{{__('Name')}}"
                                />
                                <x-textfield id="pp_value"
                                             label="{{__('Wert')}}"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Speichern')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal"
         id="modalDeleteProdukt"
         tabindex="-1"
         aria-labelledby="modalDeleteProdukt"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
            <div class="modal-content">
                <form action="{{ route('produkt.destroy',['produkt'=>$produkt->id]) }}"
                      method="POST"
                      class="needs-validation"
                      id="frmDeleteProdukt"
                      name="frmDeleteProdukt"
                >
                    @csrf
                    @method('DELETE')
                    <input type="hidden"
                           name="produkt_id"
                           id="produkt_id_toDelete"
                           value="{{ $produkt->id }}"
                    >
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white">
                            <span class="far fa-trash-alt"></span> {{__('Produkt löschen')}}
                        </h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="lead">
                                    {{__('Das Produkt wird allen Datenfeldern gelöscht. Alle Verknüpfungen zu diesem Produkt gehen verloren oder sind nicht mehr erreichbar.')}}
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-outline-danger">{{__('Produkt löschen')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">Produkt <span class="badge badge-primary">{{ $produkt->prod_nummer }}</span> bearbeiten</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab"
                    id="myTab"
                    role="tablist"
                >
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link active"
                           id="prodStammdaten-tab"
                           data-toggle="tab"
                           href="#prodStammdaten"
                           role="tab"
                           aria-controls="prodStammdaten"
                           aria-selected="true"
                        >{{__('Stammdaten')}}</a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="prodAnfordrungen-tab"
                           data-toggle="tab"
                           href="#prodAnfordrungen"
                           role="tab"
                           aria-controls="prodAnfordrungen"
                           aria-selected="false"
                        >{{__('Anforderungen')}} <span class="badge badge-primary">{{ $produkt->ProduktAnforderung->count() }}</span></a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="prodFirmen-tab"
                           data-toggle="tab"
                           href="#prodFirmen"
                           role="tab"
                           aria-controls="prodFirmen"
                           aria-selected="false"
                        >{{__('Firmen')}} <span class="badge badge-primary">{{  $produkt->firma->count() }}</span></a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="prodDoku-tab"
                           data-toggle="tab"
                           href="#prodDoku"
                           role="tab"
                           aria-controls="prodDoku"
                           aria-selected="false"
                        >{{__('Dokumente')}} <span class="badge badge-primary">{{ $produkt->ProduktDoc->count() }}</span></a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="prodEquip-tab"
                           data-toggle="tab"
                           href="#prodEquip"
                           role="tab"
                           aria-controls="prodEquip"
                           aria-selected="false"
                        >{{__('Geräte')}} <span class="badge badge-primary">{{ $produkt->Equipment->count() }}</span></a>
                    </li>
                </ul>
                <div class="tab-content p-2"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active"
                         id="prodStammdaten"
                         role="tabpanel"
                         aria-labelledby="prodStammdaten-tab"
                    >
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('produkt.update',['produkt'=>$produkt->id]) }}"
                                      method="post"
                                      class="needs-validation"
                                >
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden"
                                           name="id"
                                           id="id"
                                           value="{{ $produkt->id }}"
                                    >
                                    <div class="row">
                                        <div class="col-md-9">
                                            <x-textfield id="prod_name_lang"
                                                         label="{{__('Bezeichnung')}}"
                                                         value="{!! $produkt->prod_name_lang !!}"
                                            />
                                        </div>
                                        <div class="col md-3">
                                            <x-selectfield id="produkt_kategorie_id"
                                                           label="{{__('Kategorie')}}"
                                            >
                                                @foreach (App\ProduktKategorie::all() as $produktKategorie)
                                                    <option value="{{ $produktKategorie->id }}"
                                                            @if($produktKategorie->id === $produkt->produkt_kategorie_id)
                                                            selected
                                                        @endif
                                                    >
                                                        {{ $produktKategorie->pk_name_kurz }}
                                                    </option>
                                                @endforeach
                                            </x-selectfield>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <x-rtextfield id="prod_name_kurz"
                                                          label="{{__('Kurzbezeichnung / Spezifikation')}}"
                                                          value="{!! $produkt->prod_name_kurz !!}"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <x-selectfield id="produkt_state_id"
                                                           label="{{__('Produkt Status')}}"
                                            >
                                                @foreach (App\ProduktState::all() as $produktState)
                                                    <option value="{{ $produktState->id }}" {{ ($produkt->produkt_state_id===$produktState->id)? ' selected ' : ''  }}>{{ $produktState->ps_name_kurz }}</option>
                                                @endforeach
                                            </x-selectfield>
                                        </div>
                                        <div class="col-md-2 d-flex align-self-center">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           name="prod_active"
                                                           id="prod_active"
                                                           value="1"
                                                        {{ ($produkt->prod_active===1)? ' checked ' : ''  }}
                                                    >
                                                    <label class="custom-control-label"
                                                           for="prod_active"
                                                    >{{__('Produkt aktiv')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-self-center">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           id="control_product"
                                                           name="control_product"
                                                           value="1"
                                                        {{ ($produkt->ControlProdukt)? ' checked ' : ''  }}
                                                    >
                                                    <label class="custom-control-label"
                                                           for="control_product"
                                                    >{{__('Ist Prüfmittel')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col"
                                             aria-label="Felderliste"
                                        >
                                            @forelse ($produkt->ProduktParam as $param)
                                                <x-textfield id="{{ $param->pp_label }}"
                                                             label="{{ $param->pp_name }}"
                                                             value="{!! $param->pp_value !!}"
                                                             max="150"
                                                />
                                                <input type="hidden"
                                                       name="pp_id[]"
                                                       id="pp_id_{{ $param->id }}"
                                                       value="{{ $param->id }}"
                                                >
                                            @empty
                                                @forelse ($produkt->ProduktKategorie->ProduktKategorieParam as $pkParam)
                                                    <input type="hidden"
                                                           name="pp_id[]"
                                                           id="pp_id_{{ $pkParam->id }}"
                                                           value="{{ $pkParam->id }}"
                                                    >
                                                    <x-textfield id="{{ $pkParam->pkp_label }}"
                                                                 name="pp_label[]"
                                                                 label="{{ $pkParam->pkp_name }}"
                                                                 value="{!! $pkParam->pkp_value !!}"
                                                                 max="150"
                                                    />
                                                @empty
                                                    <x-notifyer>{{__('Es wurden bislang keine Datenfelder angelegt')}}.</x-notifyer>
                                                @endforelse
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <x-textfield id="prod_nummer"
                                                         label="Nummer"
                                                         value="{!! $produkt->prod_nummer !!}"
                                            />
                                            <x-textarea id="prod_name_text"
                                                        label="Beschreibung"
                                                        value="{!! $produkt->prod_name_text !!}"
                                            />
                                        </div>
                                    </div>
                                    <x-btnMain>{{__('Produkt speichern')}} <span class="fas fa-download ml-3"></span></x-btnMain>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="prodAnfordrungen"
                         role="tabpanel"
                         aria-labelledby="prodAnfordrungen-tab"
                    >
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <h2 class="h5">{{__('Anforderung auswählen')}}</h2>
                                <form action="{{ route('addProduktAnforderung') }}#prodAnfordrungen"
                                      method="post"
                                >
                                    @csrf
                                    <input type="hidden"
                                           name="produkt_id"
                                           id="produkt_id_anforderung"
                                           value="{{ $produkt->id }}"
                                    >
                                    <x-selectfield id="anforderung_id"
                                                   label="Anforderung wählen"
                                    >
                                        <option value="">{{__('bitte wählen')}}</option>
                                        @foreach (App\Anforderung::all() as $anforderung)
                                            <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_kurz }}</option>
                                        @endforeach
                                    </x-selectfield>
                                    <button class="btn btn-primary btn-block mt-1">{{__('Anforderung zuordnen')}}</button>
                                    <div class="card p-2 my-2"
                                         id="produktAnforderungText"
                                    >
                                        <x-notifyer>{{__('Details zu Anforderung')}}</x-notifyer>
                                    </div>
                                </form>
                                @error('anforderung_id')
                                <div class="alert alert-dismissible fade show alert-info mt-5"
                                     role="alert"
                                >
                                    {{__('Bitte eine Anforderung auswählen!')}}
                                    <button type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <h2 class="h5">{{__('Anforderungen')}}</h2>
                                @php
                                    $Anforderung = App\Anforderung::all();
                                @endphp
                                @forelse ($produkt->ProduktAnforderung as $produktAnforderung)
                                    @if ($produktAnforderung->anforderung_id!=0)
                                        <div class="card p-2 mb-2">
                                            <dl class="row lead">
                                                <dt class="col-sm-4">{{__('Verordnung')}}</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_name_kurz }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">{{__('Anforderung')}}</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">{{__('Bezeichnung')}}</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_lang }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">{{__('Intervall')}}</dt>
                                                <dd class="col-sm-8">
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_name }}
                                                </dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">{{__('Beschreibung')}}</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_text }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">
                                                    {{ ($produktAnforderung->Anforderung->AnforderungControlItem->count()>1) ? 'Vorgänge' : 'Vorgang' }}
                                                </dt>
                                                <dd class="col-sm-8">
                                                    <ul class="list-group">

                                                        @foreach ($produktAnforderung->Anforderung->AnforderungControlItem as $aci)
                                                            <li class="list-group-item">{{ $aci->aci_name_lang }}</li>
                                                        @endforeach
                                                    </ul>
                                                </dd>
                                            </dl>
                                            <nav class="border-top mt-2 pt-2 d-flex justify-content-end">
                                                <form action="{{ route('deleteProduktAnfordrung') }}#prodAnfordrungen"
                                                      method="post"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden"
                                                           name="an_name_kurz"
                                                           id="an_name_kurz_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}"
                                                    >
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $produktAnforderung->id }}"
                                                    >
                                                    <input type="hidden"
                                                           name="produkt_id"
                                                           id="produkt_id_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $produkt->id }}"
                                                    >
                                                    <input type="hidden"
                                                           name="anforderung_id"
                                                           id="anforderung_id_delete_anforderung_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $produktAnforderung->anforderung_id }}"
                                                    >
                                                    <button class="btn btn-sm btn-outline-primary">{{__('löschen')}}</button>
                                                </form>
                                            </nav>
                                        </div>
                                    @endif
                                @empty
                                    <x-notifyer>{{__('Bislang sind keine Anforderungen verknüpft!')}}</x-notifyer>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="prodFirmen"
                         role="tabpanel"
                         aria-labelledby="prodFirmen-tab"
                    >
                        <div class="row">
                            <div class="col-md-8">
                                <form action="{{ route('addProduktFirma') }}#prodFirmen"
                                      id="frmAddProduktFirma"
                                      method="post"
                                      autocomplete="off"
                                >
                                    @csrf
                                    <input type="hidden"
                                           name="produkt_id"
                                           id="produkt_id_toFirma"
                                           value="{{ $produkt->id }}"
                                    >
                                    <div class="input-group mb-2">
                                        <input type="text"
                                               name="searchFirma"
                                               id="searchFirma"
                                               aria-label="Suche nach Firma"
                                               autocomplete="off"
                                               class="form-control getFirma"
                                               placeholder="Firma suchen ..."
                                        >
                                        <button class="btn btn-outline-primary ml-1"
                                                type="button"
                                                data-toggle="collapse"
                                                data-target="#sectionFirmaDetails"
                                                aria-expanded="false"
                                                aria-controls="sectionFirmaDetails"
                                        >
                                            <span id="btnMakeNewFirma">{{__('Neu')}}</span> <span class="fas fa-angle-down"></span>
                                        </button>
                                        <button class="btn btn-primary ml-1">{{__('Zuordnen')}} <span class="fas fa-angle-right"></span></button>
                                    </div>
                                    <div class="collapse @if (count($errors)>0) show @endif "
                                         id="sectionFirmaDetails"
                                    >
                                        <div class="card p-3 mb-2">
                                            <div class="d-flex justify-content-md-between">
                                                <h3 class="h5">{{__('Firmen-Daten')}}</h3>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           id="ckAddNewFirma"
                                                           name="ckAddNewFirma"
                                                           value="1"
                                                    >
                                                    <label class="custom-control-label"
                                                           for="ckAddNewFirma"
                                                    >{{__('Firma neu anlegen')}}</label>
                                                </div>
                                            </div>
                                            <input type="hidden"
                                                   name="adress_id"
                                                   id="adress_id"
                                            >
                                            <input type="hidden"
                                                   name="id"
                                                   id="firma_id"
                                            >
                                            <input type="hidden"
                                                   name="firma_id"
                                                   id="firma_id_tabfp"
                                            >
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <x-textfield id="fa_name_kurz"
                                                                 label="{{__('Kürzel')}}"
                                                                 class="getFirma checkLabel"
                                                                 required
                                                    />
                                                    <span class="small text-primary getFirmaRes"></span>
                                                </div>
                                                <div class="col-md-8">
                                                    <x-textfield id="fa_name_lang"
                                                                 label="{{__('Name')}}"
                                                                 class="getFirma"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <x-textfield id="fa_kreditor_nr"
                                                                 label="{{__('Kreditor Nr.')}}"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <x-textfield id="fa_debitor_nr"
                                                                 label="{{__('Debitor Nr.')}}"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <x-textfield id="fa_vat"
                                                                 label="{{__('USt-Id.')}}"
                                                                 max="30"
                                                    />
                                                </div>
                                            </div>
                                        </div> <!-- Firma Details -->
                                        <div class="card p-3 mb-2">
                                            <div class="d-flex justify-content-md-between">
                                                <h3 class="h5">{{__('Adress-Daten')}}</h3>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           id="ckAddNewAddress"
                                                           name="ckAddNewAddress"
                                                           value="1"
                                                    >
                                                    <label class="custom-control-label"
                                                           for="ckAddNewAddress"
                                                    >{{__('Adresse neu anlegen')}}</label>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-5">
                                                    <x-textfield id="ad_name_kurz"
                                                                 label="{{ __('Kürzel') }}"
                                                                 class="getAddress checkLabel"
                                                    />
                                                </div>
                                                <div class="col-md-7">
                                                    <x-selectfield id="address_type_id"
                                                                   label="{{__('Adresse Typ')}}"
                                                    >
                                                        @foreach (App\AddressType::all() as $addressType)
                                                            <option value="{{ $addressType->id }}">{{ $addressType->adt_name }}</option>
                                                        @endforeach
                                                    </x-selectfield>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-9">
                                                    <x-textfield id="ad_anschrift_strasse"
                                                                 label="{{__('Straße')}}"
                                                                 required
                                                    />
                                                </div>
                                                <div class="col-md-3">
                                                    <x-textfield id="ad_anschrift_hausnummer"
                                                                 label="{{__('Nr')}}"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-2">
                                                    <x-selectfield id="land_id"
                                                                   label="{{__('Land')}}"
                                                    >
                                                        @foreach (App\Land::all() as $country)
                                                            <option value="{{ $country->id }}">{{ $country->land_iso }}</option>
                                                        @endforeach
                                                    </x-selectfield>
                                                </div>
                                                <div class="col-md-7">
                                                    <x-textfield id="ad_anschrift_ort"
                                                                 label="{{__('Ort')}}"
                                                                 required
                                                    />
                                                </div>
                                                <div class="col-md-3">
                                                    <x-textfield id="ad_anschrift_plz"
                                                                 label="{{__('PLZ')}}"
                                                                 required
                                                    />
                                                </div>
                                            </div>

                                        </div><!-- Adress Details -->
                                        <div class="card p-3 mb-2">
                                            <div class="d-flex justify-content-md-between">
                                                <h3 class="h5">Kontakt-Daten</h3>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           id="ckAddNewContact"
                                                           name="ckAddNewContact"
                                                           value="1"
                                                    >
                                                    <label class="custom-control-label"
                                                           for="ckAddNewContact"
                                                    >Kontakt neu anlegen
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-5">
                                                    <label for="con_name_kurz">Kürzel</label>
                                                    <input type="text"
                                                           name="con_name_kurz"
                                                           id="con_name_kurz"
                                                           aria-label="Suche"
                                                           autocomplete="off"
                                                           class="form-control getAddress @error('con_name_kurz') is-invalid @enderror"
                                                           value="{{ old('con_name_kurz') ?? '' }}"
                                                           required
                                                    >
                                                    @error('con_name_kurz')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('con_name_kurz') d-none @enderror ">
                                                        erforderliches Feld, max 20 Zeichen
                                                    </span>
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="anrede_id">Anrede</label>
                                                    <select name="anrede_id"
                                                            id="anrede_id"
                                                            aria-label="Suche"
                                                            autocomplete="off"
                                                            class="custom-select @error('anrede_id') is-invalid @enderror"
                                                    >
                                                        @foreach (App\Anrede::all() as $anrede)
                                                            <option value="{{ $anrede->id }}">{{ $anrede->an_kurz }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-5">
                                                    <label for="con_vorname">Vorname</label>
                                                    <input type="text"
                                                           name="con_vorname"
                                                           id="con_vorname"
                                                           aria-label="Suche"
                                                           autocomplete="off"
                                                           class="form-control @error('con_vorname') is-invalid @enderror"
                                                           value="{{ old('con_vorname') ?? '' }}"
                                                    >
                                                    @error('con_vorname')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('con_vorname') d-none @enderror ">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="con_name">Nachname</label>
                                                    <input type="text"
                                                           name="con_name"
                                                           id="con_name"
                                                           aria-label="Suche"
                                                           autocomplete="off"
                                                           class="form-control @error('con_name') is-invalid @enderror"
                                                           value="{{ old('con_name') ?? '' }}"
                                                    >
                                                    @error('con_name')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('con_name') d-none @enderror ">max 100 Zeichen</span>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-5">
                                                    <label for="con_telefon">Telefon</label>
                                                    <input type="text"
                                                           name="con_telefon"
                                                           id="con_telefon"
                                                           aria-label="Suche"
                                                           autocomplete="off"
                                                           class="form-control @error('con_telefon') is-invalid @enderror"
                                                           value="{{ old('con_telefon') ?? '' }}"
                                                    >
                                                    @error('con_telefon')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('con_telefon') d-none @enderror ">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <x-emailfield id="con_email"
                                                                  name="con_email"
                                                                  label="E-Mail Adresse"
                                                    />
                                                </div>
                                            </div>

                                        </div><!-- Kontakt Details -->
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="list-group">

                                    @foreach ($produkt->firma as $firma)
                                        <x-addresslabel
                                            firma="{!!  $firma->fa_name_lang !!}"
                                            address="{{ $firma->Adresse->ad_anschrift_strasse }} - {{ $firma->Adresse->ad_anschrift_ort }}"
                                            firmaid="{{ $firma->id }}"
                                            produktid="{{ $produkt->id }}"
                                        ></x-addresslabel>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="prodDoku"
                         role="tabpanel"
                         aria-labelledby="prodDoku-tab"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('produktDoku.store') }}#prodDoku"
                                      method="POST"
                                      enctype="multipart/form-data"
                                >
                                    @csrf
                                    <h2 class="h5">Dokument an Produkt anhängen</h2>
                                    <input type="hidden"
                                           name="produkt_id"
                                           id="produkt_id_doku"
                                           value="{{ $produkt->id }}"
                                    >
                                    <div class="form-group">
                                        <label for="document_type_id">Dokument Typ</label>
                                        <div class="input-group">
                                            <select name="document_type_id"
                                                    id="document_type_id"
                                                    class="custom-select"
                                            >
                                                @foreach (App\DocumentType::all() as $ad)
                                                    <option value="{{ $ad->id }}">{{ $ad->doctyp_name_kurz }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button"
                                                    class="btn-outline-primary btn ml-2"
                                                    data-toggle="modal"
                                                    data-target="#modalAddDokumentType"
                                            >
                                                <span class="fas fa-plus"></span> neuen Typ anlegen
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="proddoc_name_kurz">Bezeichnung</label>
                                        <input type="text"
                                               name="proddoc_name_kurz"
                                               id="proddoc_name_kurz"
                                               class="form-control @error('proddoc_name_kurz') is-invalid @enderror "
                                               value="{{ old('proddoc_name_kurz') ?? '' }}"
                                               required
                                        >
                                        @error('proddoc_name_kurz')
                                        <span class="text-danger small">Error {{ $message }}</span>
                                        @enderror
                                        <span class="small text-primary @error('proddoc_name_kurz') d-none @enderror">max 20 Zeichen, erforderlichen Feld</span>

                                    </div>
                                    <div class="form-group">
                                        <label for="proddoc_name_text">Datei Informationen</label>
                                        <textarea name="proddoc_name_text"
                                                  id="proddoc_name_text"
                                                  class="form-control"
                                        >{{ old('proddoc_name_text') ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                   id="prodDokumentFile"
                                                   name="prodDokumentFile"
                                                   data-browse="Datei"
                                                   class="custom-file-input"
                                                   accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                                   required
                                            >
                                            <label class="custom-file-label"
                                                   for="prodDokumentFile"
                                            >Datei wählen
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block"><i class="fas fa-paperclip"></i> Neues Dokument an Produkt anhängen</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                @if ($produkt->ProduktDoc->count()>0)
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <th>Datei</th>
                                        <th>Typ</th>
                                        <th class="d-none d-lg-table-cell"
                                            style="text-align: right;"
                                        >Größe kB
                                        </th>
                                        <th class="d-none d-lg-table-cell">Hochgeladen</th>
                                        <th></th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach ($produkt->ProduktDoc as $produktDoc)
                                            <tr>
                                                <td>
                                                    <span title="{{ $produktDoc->proddoc_name_lang }}">
                                                    {{ str_limit($produktDoc->proddoc_name_lang,25) }}
                                                    </span>
                                                </td>
                                                <td>{{ $produktDoc->DocumentType->doctyp_name_kurz }}</td>
                                                <td class="d-none d-lg-table-cell"
                                                    style="text-align: right;"
                                                >{{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}</td>
                                                <td class="d-none d-lg-table-cell">{{ $produktDoc->created_at->DiffForHumans() }}</td>
                                                <td>
                                                    <x-deletebutton
                                                        prefix="produktDoc"
                                                        action="{{ route('produktDoku.destroy',$produktDoc->id) }}"
                                                        id="{{ $produktDoc->id }}"
                                                    />


                                                    {{--   <form action="{{ route('produktDoku.destroy',$produktDoc->id) }}#prodDoku" method="post" id="deleteProdDoku_{{ $produktDoc->id }}">
                                                           @csrf
                                                           @method('delete')
                                                           <input type="hidden"
                                                                  name="id"
                                                                  id="delete_produktdoc_id_{{ $produktDoc->id }}"
                                                                  value="{{ $produktDoc->id }}"
                                                           >

                                                       </form>
                                                       <button
                                                           class="btn btn-sm btn-outline-secondary"
                                                           onclick="event.preventDefault(); document.getElementById('deleteProdDoku_{{ $produktDoc->id }}').submit();">
                                                           <span class="far fa-trash-alt"></span>
                                                       </button>--}}
                                                </td>
                                                <td>
                                                    <form action="{{ route('downloadProduktDokuFile') }}#prodDoku"
                                                          method="get"
                                                          id="downloadProdDoku_{{ $produktDoc->id }}"
                                                    >
                                                        @csrf
                                                        <input type="hidden"
                                                               name="id"
                                                               id="download_produktdoc_id_{{ $produktDoc->id }}"
                                                               value="{{ $produktDoc->id }}"
                                                        >
                                                    </form>
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();"
                                                    >
                                                        <span class="fas fa-download"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="small text-muted">{{__('Keine Dateien zum Produkt gefunden!')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="prodEquip"
                         role="tabpanel"
                         aria-labelledby="prodEquip-tab"
                    >
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped"
                                       id="tabProduktEquipmentListe"
                                >
                                    <thead>
                                    <tr>
                                        <th>{{__('Inventarnummer')}}</th>
                                        <th>{{__('Seriennummer')}}</th>
                                        <th>{{__('Inbetriebname')}}</th>
                                        <th>{{__('Status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($produkt->Equipment as $equipment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('equipment.show',$equipment) }}">{{ $equipment->eq_inventar_nr }}</a>
                                            </td>
                                            <td>
                                                {{ $equipment->eq_serien_nr }}
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($equipment->eq_ibm)->DiffForHumans() }}
                                            </td>
                                            <td class="d-flex align-items-center justify-content-between">
                                                {{ $equipment->EquipmentState->estat_name_kurz }}
                                                {!! $equipment->showStatus() !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <x-notifyer>Keine Geräte mit diesem Produkt gefunden</x-notifyer>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @error('doctyp_name_kurz')
    <script>
        $('#modalAddDokumentType').modal('show');
    </script>
    @enderror

    @error('pp_label')
    <script>
        $('#modalAddParameter').modal('show');
    </script>
    @enderror

    @if ($produkt->Equipment->count()>0)


        <link rel="stylesheet"
              type="text/css"
              href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"
        >
        <script type="text/javascript"
                charset="utf8"
                src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"
        ></script>
        <script type="text/javascript"
                charset="utf8"
                src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"
        ></script>
        <script>
            const dom = ($('#tabProduktEquipmentListe > tbody > tr').length > 14) ? 't<"bottom"flp><"clear">' : 't';
            $('#tabProduktEquipmentListe').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                // "columnDefs": [
                //     {"orderable": false, "targets": 5}
                // ],
                "dom": dom
            });
        </script>
    @endif
    <script>
        $('.tooltips').tooltip();

        $('#btnGetAnforderungsListe').click(() => {
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungByVerordnungListe') }}",
                data: {id: $('#setAnforderung :selected').val()},
                success: function (res) {
                    $('#anforderung_id').html(res.html);
                }
            });
        });

        $('#proddoc_name_kurz').val(
           $('#document_type_id :selected').text() + ' ' + $('#prod_name_lang').val()
        );

        $('#document_type_id').change(()=>{
            $('#proddoc_name_kurz').val(
                $('#document_type_id :selected').text() + ' ' + $('#prod_name_lang').val()
            );
        });


        $('#anforderung_id').change(() => {

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungData') }}",
                data: {id: $('#anforderung_id :selected').val()},
                success: (res) => {
                    const text = (res.an_name_text === null) ? '-' : res.an_name_text;
                    $('#produktAnforderungText').html(`
                         <dl class="row">
                            <dt class="col-sm-4">Verordnung</dt>
                            <dd class="col-sm-8">${res.verordnung.vo_name_kurz}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Anfoderung</dt>
                            <dd class="col-sm-8">${res.an_name_kurz}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Bezeichnung</dt>
                            <dd class="col-sm-8">${res.an_name_lang}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Intervall</dt>
                            <dd class="col-sm-8">${res.an_control_interval}  ${res.control_interval.ci_name}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Beschreibung</dt>
                            <dd class="col-sm-8">${text}</dd>
                        </dl>
            `);
                }
            });
        });
    </script>
@endsection

@section('autocomplete')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(".getFirma").autocomplete({
            // position: { my : "right top", at: "right bottom" },
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('getFirmenAjaxListe') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {

                        let resp = $.map(data, function (obj) {
                            return {
                                label: `(${obj.fa_name_kurz}) ${obj.fa_name_lang} `,
                                id: obj.id
                            };
                        });
                        response(resp);
                    }
                });
            },
            select: function (event, ui) {
                $('#btnMakeNewFirma').text('bearbeiten');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('getFirmenDaten') }}",
                    data: {id: ui.item.id},
                    success: function (res) {

                        $('#adress_id').val(res.adresse.id);
                        $('#ad_name_kurz').val(res.adresse.ad_name_kurz);
                        $('#address_type_id').val(res.adresse.address_type_id);
                        $('#ad_anschrift_strasse').val(res.adresse.ad_anschrift_strasse);
                        $('#ad_anschrift_hausnummer').val(res.adresse.ad_anschrift_hausnummer);
                        $('#ad_anschrift_plz').val(res.adresse.ad_anschrift_plz);
                        $('#ad_anschrift_ort').val(res.adresse.ad_anschrift_ort);
                        $('#land_id').val(res.adresse.land_id);

                        $('#firma_id').val(res.firma.id);
                        $('#firma_id_tabfp').val(res.firma.id);
                        $('#fa_name_kurz').val(res.firma.fa_name_kurz);
                        $('#fa_name_lang').val(res.firma.fa_name_lang);
                        $('#fa_kreditor_nr').val(res.firma.fa_kreditor_nr);
                        $('#fa_debitor_nr').val(res.firma.fa_debitor_nr);
                        $('#fa_vat').val(res.firma.fa_vat);

                        $('#anrede_id').val(res.contact.anrede_id);
                        $('#con_name_kurz').val(res.contact.con_name_kurz);
                        $('#con_vorname').val(res.contact.con_vorname);
                        $('#con_name').val(res.contact.con_name);
                        $('#con_telefon').val(res.contact.con_telefon);
                        $('#con_email').val(res.contact.con_email);

                    }
                });

            }
        });
    </script>

@endsection
