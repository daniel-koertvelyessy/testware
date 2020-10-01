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
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produkt.index') }}">Produkte</a></li>
            <li class="breadcrumb-item"><a href="/produkt/kategorie/{{ $produkt->ProduktKategorie->id }}">{{ $produkt->ProduktKategorie->pk_name_kurz }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produkt->prod_nummer }}</li>
        </ol>

    </nav>
@endsection

@section('actionMenuItems')
    <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Produkt </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalAddParameter"><i class="fas fa-table"></i> Daten-Feld hinzufügen</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDeleteProdukt"><i class="far fa-trash-alt"></i> Produkt löschen</a>
        </ul>
    </li>
@endsection

@section('modals')

    <div class="modal" id="modalAddDokumentType" tabindex="-1" aria-labelledby="modalAddDokumentTypeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createDokumentType') }}"
                      method="POST" class="needs-validation"
                      id="frmAddNewDokumentenTyp" name="frmAddNewDokumentenTyp">
                    @csrf
                    <input type="hidden" name="origin" id="origin" value="materials">
                    <input type="hidden" name="material_id" id="material_id" value="{{ $produkt->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Neuen Dokumententyp anlegen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="doctyp_name_kurz">Name - kurz</label>
                                    <input type="text"
                                           name="doctyp_name_kurz" id="doctyp_name_kurz"
                                           class="form-control @error('doctyp_name_kurz') is-invalid @enderror"
                                           value="{{ old('doctyp_name_kurz') ?? '' }}"
                                           required
                                    >
                                    @error('doctyp_name_kurz')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                    <span class="small text-primary">max 20 Zeichen, erforderliches Feld</span>
                                </div>
                                <div class="form-group">
                                    <label for="doctyp_name_lang">Name - lang</label>
                                    <input type="text" name="doctyp_name_lang" id="doctyp_name_lang"
                                           class="form-control @error('doctyp_name_lang') is-invalid @enderror"
                                           value="{{ old('doctyp_name_lang') ?? '' }}"
                                    >
                                    @error('doctyp_name_lang')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                    <span class="small text-primary">max 100 Zeichen</span>
                                </div>
                                <div class="form-group">
                                    <label for="doctyp_name_text">Beschreibung</label>
                                    <textarea id="doctyp_name_text" name="doctyp_name_text" class="form-control">{{ old('doctyp_name_text') ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <p class="lead">Dokument ist Pflichtteil einer Verordnung</p>
                                    <div class="pl-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="doctyp_mandatory" id="doctyp_mandatory_ja" value="1">
                                            <label class="form-check-label" for="doctyp_mandatory_ja">
                                                ist Teil einer Verordnung
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="doctyp_mandatory" id="doctyp_mandatory_nein" value="0" checked>
                                            <label class="form-check-label" for="doctyp_mandatory_nein">
                                                kein Pflichtteil
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch</button>
                        <button class="btn btn-primary">Speichern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modalAddParameter" tabindex="-1" aria-labelledby="modalAddParameter" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
            <div class="modal-content">
                <form action="{{ route('addProduktParams') }}"
                      method="POST" class="needs-validation"
                      id="frmAddProdParam" name="frmAddProdParam">
                    @csrf
                    <input type="hidden" name="produkt_id" id="produkt_id_param" value="{{ $produkt->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Neues Stammdaten-Feld anlegen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="pp_label">Label</label>
                                    <input type="text" name="pp_label" id="pp_label"
                                           class="form-control checkLabel @error('pp_label') is-invalid @enderror"
                                           value="{{ old('pp_label') ?? '' }}" required>
                                    @error('pp_label')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    <span class="small text-primary">max 20 Zeichen, ohne Leerzeichen, erforderliches Feld</span>

                                </div>
                                <div class="form-group">
                                    <label for="pp_name">Name</label>
                                    <input type="text" name="pp_name" id="pp_name"
                                           class="form-control @error('pp_name') is-invalid @enderror"
                                           value="{{ old('pp_name') ?? '' }}"
                                    >
                                    <span class="small text-primary">max 150 Zeichen</span>
                                    @error('pp_name'))
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="pp_value">Wert</label>
                                    <input type="text" name="pp_value" id="pp_value"
                                           class="form-control @error('pp_value') is-invalid @enderror"
                                           value="{{ old('pp_value') ?? '' }}"
                                    >

                                    @error('pp_value')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                    <span class="small text-primary">max 150 Zeichen</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch</button>
                        <button class="btn btn-primary">Speichern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modalDeleteProdukt" tabindex="-1" aria-labelledby="modalDeleteProdukt" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
            <div class="modal-content">
                <form action="{{ route('produkt.destroy',['produkt'=>$produkt->id]) }}"
                      method="POST" class="needs-validation"
                      id="frmDeleteProdukt" name="frmDeleteProdukt">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="produkt_id" id="produkt_id_toDelete" value="{{ $produkt->id }}">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white"><span class="far fa-trash-alt"></span> Produkt löschen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="lead">Das Produkt wird allen Datenfeldern gelöscht. Alle Verknüpfungen zu diesem Produkt gehen verloren oder sind nicht mehr erreichbar.</p>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Abbruch</button>
                        <button class="btn btn-outline-danger">Produkt löschen</button>
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
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="prodStammdaten-tab" data-toggle="tab" href="#prodStammdaten" role="tab" aria-controls="prodStammdaten" aria-selected="true">Stammdaten</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="prodAnfordrungen-tab" data-toggle="tab" href="#prodAnfordrungen" role="tab" aria-controls="prodAnfordrungen" aria-selected="false">Anforderungen <span class="badge badge-primary">{{ \App\ProduktAnforderung::where('produkt_id',$produkt->id)->count() }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="prodFirmen-tab" data-toggle="tab" href="#prodFirmen" role="tab" aria-controls="prodFirmen" aria-selected="false">Firmen <span class="badge badge-primary">{{ \App\FirmaProdukt::where('produkt_id',$produkt->id)->count() }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="prodDoku-tab" data-toggle="tab" href="#prodDoku" role="tab" aria-controls="prodDoku" aria-selected="false">Dokumente <span class="badge badge-primary">{{ \App\ProduktDoc::where('produkt_id',$produkt->id)->count() }}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2" id="prodStammdaten" role="tabpanel" aria-labelledby="prodStammdaten-tab">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('produkt.update',['produkt'=>$produkt->id]) }}" method="post" class="needs-validation">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="id" value="{{ $produkt->id }}">
                                    <div class="row">
                                        <div class="col">
                                            <x-textfield id="prod_name_lang" label="Bezeichnung" value="{{ $produkt->prod_name_lang }}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <x-rtextfield id="prod_name_kurz" label="Kurzbezeichnung / Spezifikation" value="{{ $produkt->prod_name_kurz }}"/>
                                        </div>
                                        <div class="col-md-4">
                                            <x-selectfield id="produkt_state_id" label="Material Status">
                                                @foreach (App\ProduktState::all() as $produktState)
                                                    <option value="{{ $produktState->id }}" {{ ($produkt->produkt_state_id===$produktState->id)? ' selected ' : ''  }}>{{ $produktState->ps_name_kurz }}</option>
                                                @endforeach
                                            </x-selectfield>
                                        </div>
                                        <div class="col-md-4 d-flex align-self-center">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="prod_active" id="prod_active" value="1" {{ ($produkt->prod_active===1)? ' checked ' : ''  }}>
                                                    <label class="custom-control-label" for="prod_active">Produkt aktiv</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" aria-label="Felderliste">
                                            @forelse (DB::table('produkt_params')->where('produkt_id',$produkt->id)->orderBy('pp_name', 'asc')->get() as $param)
                                                <x-textfield id="{{ $param->pp_label }}"
                                                             label="{{ $param->pp_name }}"
                                                             value="{{ $param->pp_value }}" max="150"
                                                />
                                                <input type="hidden" name="pp_id[]" id="pp_id_{{ $param->id }}" value="{{ $param->id }}">
                                            @empty
                                               {{-- @forelse (DB::table('produkt_kategorie_params')->where('produkt_kategorie_id',$produkt->ProduktKategorie->id)->orderBy('pkp_name', 'asc')->get() as $pkParam)
                                                    <input type="hidden" name="pp_id[]" id="pp_id_{{ $pkParam->id }}" value="{{ $pkParam->id }}">
                                                    <x-textfield id="{{ $pkParam->pkp_label }}" name="pp_label[]"
                                                                 label="{{ $pkParam->pkp_name }}"
                                                                 value="{{ $pkParam->pkp_value }}" max="150"/>
                                                @empty
                                                    <p class="text-muted text-center">Es wurden bislang keine Felder angelegt.</p>
                                                @endforelse--}}
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <x-textfield id="prod_nummer" label="Nummer" value="{{ $produkt->prod_nummer }}"/>
                                            <x-textarea id="prod_name_text" label="Beschreibung" value="{{ $produkt->prod_name_text }}"/>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block">Produkt speichern</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2" id="prodAnfordrungen" role="tabpanel" aria-labelledby="prodAnfordrungen-tab">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <h2 class="h5">Anforderung auswählen</h2>
                                <form action="{{ route('addProduktAnforderung') }}#prodAnfordrungen" method="post">
                                    @csrf
                                    <input type="hidden" name="produkt_id" id="produkt_id_anforderung" value="{{ $produkt->id }}">
                                    <x-selectfield id="anforderung_id" label="Anforderung wählen">
                                        @foreach (App\Anforderung::all() as $anforderung)
                                            <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_kurz }}</option>
                                        @endforeach
                                    </x-selectfield>
                                    <button class="btn btn-primary btn-block mt-1">Anforderung zuordnen</button>
                                    <div class="card p-2 my-2" id="produktAnforderungText">
                                        <x-notifyer>Details zu Anforderung</x-notifyer>
                                    </div>
                                </form>
                                @error('anforderung_id')
                                <div class="alert alert-dismissible fade show alert-info mt-5" role="alert">
                                    Bitte eine Anforderung auswählen!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <h2 class="h5">Anforderungen</h2>
                                @php
                                    $Anforderung = App\Anforderung::all();
                                @endphp
                                @forelse (\App\ProduktAnforderung::where('produkt_id',$produkt->id)->get() as $produktAnforderung)
                                    @if ($produktAnforderung->anforderung_id!=0)
                                        <div class="card p-2 mb-2">
                                            <dl class="row lead">
                                                <dt class="col-sm-4">Verordnung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_name_kurz }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Anforderung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Bezeichnung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_lang }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Intervall</dt>
                                                <dd class="col-sm-8">
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_name }}
                                                </dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Beschreibung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_text }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">
                                                    {{ (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->count()>1) ? 'Vorgänge' : 'Vorgang' }}
                                                </dt>
                                                <dd class="col-sm-8">
                                                    <ul class="list-group">

                                                    @foreach (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->get() as $aci)
                                                            <li class="list-group-item">{{ $aci->aci_name_lang }}</li>
                                                    @endforeach
                                                    </ul>
                                                </dd>
                                            </dl>
                                            <nav class="border-top mt-2 pt-2 d-flex justify-content-end">
                                                <form action="{{ route('deleteProduktAnfordrung') }}#prodAnfordrungen" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="an_name_kurz" id="an_name_kurz_delAnf_{{ $produktAnforderung->anforderung_id }}" value="{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}">
                                                    <input type="hidden" name="id" id="id_delAnf_{{ $produktAnforderung->anforderung_id }}" value="{{ $produktAnforderung->id }}">
                                                    <input type="hidden" name="produkt_id" id="produkt_id_delAnf_{{ $produktAnforderung->anforderung_id }}" value="{{ $produkt->id }}">
                                                    <button class="btn btn-sm btn-outline-primary deleteAnforderungFromProdukt" data-aid="{{ $produktAnforderung->id }}">löschen</button>
                                                </form>
                                            </nav>
                                        </div>
                                    @endif
                                @empty
                                    <x-notifyer>Bislang sind keine Anforderungen verknüpft!</x-notifyer>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2" id="prodFirmen" role="tabpanel" aria-labelledby="prodFirmen-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="{{ route('addProduktFirma') }}#prodFirmen" method="post">
                                    @csrf

                                    <input type="hidden"
                                           name="produkt_id"
                                           id="produkt_id_toFirma"
                                           value="{{ $produkt->id }}"
                                    >
                                    <div class="input-group mb-2">
                                        <input type="text" name="searchFirma" id="searchFirma"
                                               aria-label="Suche nach Firma" autocomplete="off"
                                               class="form-control getFirma"
                                               placeholder="Firma suchen ..."
                                        >
                                        <button class="btn btn-outline-primary ml-1" type="button"
                                                data-toggle="collapse" data-target="#sectionFirmaDetails"
                                                aria-expanded="false" aria-controls="sectionFirmaDetails"
                                        >
                                            <span id="btnMakeNewFirma">Neu</span> <span class="fas fa-angle-down"></span>
                                        </button>
                                        <button class="btn btn-primary ml-1">Zuordnen <span class="fas fa-angle-right"></span></button>
                                    </div>
                                    @if ($errors->any())
                                        <div class="card border-warning">
                                            {{ $errors }}
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="collapse @if ($errors->any()) show @endif " id="sectionFirmaDetails">
                                        <div class="card p-3 mb-2">
                                            <h3 class="h5">Firmen-Daten</h3>
                                            <input type="hidden" name="adress_id" id="adress_id">
                                            <input type="hidden" name="id" id="firma_id">
                                            <input type="hidden" name="firma_id" id="firma_id_tabfp">
                                            <label for="fa_name_kurz">Kürzel</label>
                                            <input type="text" name="fa_name_kurz" id="fa_name_kurz"
                                                   aria-label="Suche nach Firma" autocomplete="off"
                                                   class="form-control getFirma @error('fa_name_kurz') is-invalid @enderror"
                                                   value="{{ old('fa_name_kurz') ?? '' }}" required
                                            >
                                            @error('fa_name_kurz')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                            <span class="small text-primary getFirmaRes">Erforderliches Feld, max 20 Zeichen</span>
                                            <div class="form-group mt-3">
                                                <label for="fa_name_lang">Name</label>
                                                <input type="text" name="fa_name_lang" id="fa_name_lang"
                                                       aria-label="Firma Name" autocomplete="off"
                                                       class="form-control getFirma @error('fa_name_lang') is-invalid @enderror"
                                                       value="{{ old('fa_name_lang') ?? '' }}"
                                                >
                                                @error('fa_name_lang')
                                                <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                                <span class="small text-primary">max 100 Zeichen</span>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="fa_kreditor_nr">Kreditor Nr.</label>
                                                    <input type="text" name="fa_kreditor_nr" id="fa_kreditor_nr"
                                                           aria-label="Kreditor-Nummer der Firma" autocomplete="off"
                                                           class="form-control form-control-sm @error('fa_kreditor_nr') is-invalid @enderror"
                                                           value="{{ old('fa_kreditor_nr') ?? '' }}"
                                                    >
                                                    @error('fa_kreditor_nr')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="fa_debitor_nr">Debitor Nr.</label>
                                                    <input type="text" name="fa_debitor_nr" id="fa_debitor_nr"
                                                           aria-label="Unsere Kundennummer bei der Firma" autocomplete="off"
                                                           class="form-control form-control-sm @error('fa_debitor_nr') is-invalid @enderror"
                                                           value="{{ old('fa_debitor_nr') ?? '' }}"
                                                    >
                                                    @error('fa_debitor_nr')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="fa_vat">USt-Id</label>
                                                    <input type="text" name="fa_vat" id="fa_vat"
                                                           aria-label="Suche" autocomplete="off"
                                                           class="form-control form-control-sm @error('fa_vat') is-invalid @enderror"
                                                           value="{{ old('fa_vat') ?? '' }}"
                                                    >
                                                    @error('fa_vat')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary">max 30 Zeichen</span>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="ckAddNewFirma" name="ckAddNewFirma" value="1">
                                                <label class="custom-control-label" for="ckAddNewFirma">Firma neu anlegen</label>
                                            </div>
                                        </div> <!-- Firma Details -->
                                        <div class="card p-3 mb-2">
                                            <h3 class="h5">Adress-Daten</h3>
                                            <div class="row mt-3">
                                                <div class="col-md-5">
                                                    <label for="ad_name_kurz">Kürzel</label>
                                                    <input type="text" name="ad_name_kurz" id="ad_name_kurz"
                                                           aria-label="Suche" autocomplete="off"
                                                           class="form-control getAddress @error('ad_name_kurz') is-invalid @enderror"
                                                           value="{{ old('ad_name_kurz') ?? '' }}"
                                                           required
                                                    >
                                                    @error('ad_name_kurz')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary">erforderliches Feld, max 20 Zeichen</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="address_type_id">Adresse Typ</label>
                                                    <select name="address_type_id" id="address_type_id"
                                                            aria-label="Suche" autocomplete="off"
                                                            class="custom-select @error('address_type_id') is-invalid @enderror"
                                                    >
                                                        @foreach (App\AddressType::all() as $addressType)
                                                            <option value="{{ $addressType->id }}">{{ $addressType->adt_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('address_type_id')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-9">
                                                    <label for="ad_anschrift_strasse">Straße</label>
                                                    <input type="text" name="ad_anschrift_strasse" id="ad_anschrift_strasse"
                                                           aria-label="Suche" autocomplete="off"
                                                           class="form-control @error('ad_anschrift_strasse') is-invalid @enderror"
                                                           value="{{ old('ad_anschrift_strasse') ?? '' }}"
                                                           required
                                                    >
                                                    @error('ad_anschrift_strasse')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('ad_anschrift_strasse') d-none @enderror">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="ad_anschrift_hausnummer">Nr</label>
                                                    <input type="text" name="ad_anschrift_hausnummer" id="ad_anschrift_hausnummer"
                                                           aria-label="Haus Nummer" autocomplete="off"
                                                           class="form-control @error('ad_anschrift_hausnummer') is-invalid @enderror"
                                                           value="{{ old('ad_anschrift_hausnummer') ?? '' }}"
                                                    >
                                                    @error('ad_anschrift_hausnummer')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('ad_anschrift_hausnummer') d-none @enderror">max 100 Zeichen</span>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-2">
                                                    <label for="country_id">Land</label>
                                                    <select name="country_id" id="country_id" class="custom-select">
                                                        @foreach (App\Land::all() as $country)
                                                            <option value="{{ $country->id }}">{{ $country->land_iso }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="ad_anschrift_ort">Ort</label>
                                                    <input type="text" name="ad_anschrift_ort" id="ad_anschrift_ort" aria-label="Ort eintragen" autocomplete="off"
                                                           class="form-control @error('ad_anschrift_ort') is-invalid @enderror"
                                                           value="{{ old('ad_anschrift_ort') ?? '' }}"
                                                           required
                                                    >
                                                    @error('ad_anschrift_ort')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('ad_anschrift_ort') d-none @enderror">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="ad_anschrift_plz">PLZ</label>
                                                    <input type="text" name="ad_anschrift_plz" id="ad_anschrift_plz"
                                                           aria-label="Postleitzahl eintragen" autocomplete="off"
                                                           class="form-control @error('ad_anschrift_plz') is-invalid @enderror"
                                                           value="{{ old('ad_anschrift_plz') ?? '' }}"
                                                           required
                                                    >
                                                    @error('ad_anschrift_plz')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('ad_anschrift_plz') d-none @enderror">max 100 Zeichen</span>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="ckAddNewAddress" name="ckAddNewAddress" value="1">
                                                <label class="custom-control-label" for="ckAddNewAddress">Adresse neu anlegen</label>
                                            </div>
                                        </div><!-- Adress Details -->
                                        <div class="card p-3 mb-2">
                                            <h3 class="h5">Kontakt-Daten</h3>
                                            <div class="row mt-3">
                                                <div class="col-md-5">
                                                    <label for="con_name_kurz">Kürzel</label>
                                                    <input type="text" name="con_name_kurz" id="con_name_kurz"
                                                           aria-label="Suche" autocomplete="off"
                                                           class="form-control getAddress @error('con_name_kurz') is-invalid @enderror"
                                                           value="{{ old('con_name_kurz') ?? '' }}"
                                                           required
                                                    >
                                                    @error('con_name_kurz')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('con_name_kurz') d-none @enderror ">erforderliches Feld, max 20 Zeichen</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="anrede_id">Anrede</label>
                                                    <select name="anrede_id" id="anrede_id"
                                                            aria-label="Suche" autocomplete="off"
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
                                                    <input type="text" name="con_vorname" id="con_vorname"
                                                           aria-label="Suche" autocomplete="off"
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
                                                    <input type="text" name="con_name" id="con_name"
                                                           aria-label="Suche" autocomplete="off"
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
                                                    <input type="text" name="con_telefon" id="con_telefon"
                                                           aria-label="Suche" autocomplete="off"
                                                           class="form-control @error('con_telefon') is-invalid @enderror"
                                                           value="{{ old('con_telefon') ?? '' }}"
                                                    >
                                                    @error('con_telefon')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                    <span class="small text-primary @error('con_telefon') d-none @enderror ">max 100 Zeichen</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <x-emailfield id="con_email" name="con_email" label="E-Mail Adresse" />
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="ckAddNewContact" name="ckAddNewContact" value="1">
                                                <label class="custom-control-label" for="ckAddNewContact">Kontakt neu anlegen</label>
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
                                            address="{{ App\Address::find($firma->adress_id)->ad_anschrift_strasse }} - {{ App\Address::find($firma->adress_id)->ad_anschrift_ort }}"
                                            firmaid="{{ $firma->id }}"
                                            produktid="{{ $produkt->id }}"></x-addresslabel>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2" id="prodDoku" role="tabpanel" aria-labelledby="prodDoku-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('produktDoku.store') }}#prodDoku" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h2 class="h5">Dokument an Produkt anhängen</h2>
                                    <input type="hidden" name="produkt_id" id="produkt_id_doku" value="{{ $produkt->id }}">
                                    <div class="form-group">
                                        <label for="document_type_id">Dokument Typ</label>
                                        <div class="input-group">
                                            <select name="document_type_id" id="document_type_id" class="custom-select">
                                                @foreach (App\DocumentType::all() as $ad)
                                                    <option value="{{ $ad->id }}">{{ $ad->doctyp_name_kurz }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn-outline-primary btn ml-2"  data-toggle="modal" data-target="#modalAddDokumentType">
                                                <span class="fas fa-plus"></span> neuen Typ anlegen
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="proddoc_name_kurz">Bezeichnung</label>
                                        <input type="text" name="proddoc_name_kurz" id="proddoc_name_kurz"
                                               class="form-control @error('proddoc_name_kurz') is-invalid @enderror "
                                               value="{{ old('proddoc_name_kurz') ?? '' }}" required
                                        >
                                        @error('proddoc_name_kurz')
                                        <span class="text-danger small">Error {{ $message }}</span>
                                        @enderror
                                        <span class="small text-primary @error('proddoc_name_kurz') d-none @enderror">max 20 Zeichen, erforderlichen Feld</span>

                                    </div>
                                    <div class="form-group">
                                        <label for="proddoc_name_text">Datei Informationen</label>
                                        <textarea name="proddoc_name_text" id="proddoc_name_text" class="form-control">{{ old('proddoc_name_text') ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" id="prodDokumentFile" name="prodDokumentFile"
                                                   data-browse="Datei"
                                                   class="custom-file-input"
                                                   accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                                   required
                                            >
                                            <label class="custom-file-label" for="prodDokumentFile">Datei wählen</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block"><i class="fas fa-paperclip"></i> Neues Dokument an Material anhängen </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                @if (\App\ProduktDoc::where('produkt_id',$produkt->id)->count()>0)
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <th>Datei</th>
                                        <th>Typ</th>
                                        <th style="text-align: right;">Größe kB</th>
                                        <th>Hochgeladen</th>
                                        <th></th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach (\App\ProduktDoc::where('produkt_id',$produkt->id)->get() as $produktDoc)
                                            <tr>
                                                <td>{{ $produktDoc->proddoc_name_lang }}</td>
                                                <td>{{ $produktDoc->DocumentType->doctyp_name_kurz }}</td>
                                                <td style="text-align: right;">{{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}</td>
                                                <td>{{ $produktDoc->created_at }}</td>
                                                <td>
                                                    <x-deletebutton action="{{ route('produktDoku.destroy',$produktDoc->id) }}" id="{{ $produktDoc->id }}" />


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
                                                    <form action="{{ route('downloadProduktDokuFile') }}#prodDoku" method="get" id="downloadProdDoku_{{ $produktDoc->id }}">
                                                        @csrf
                                                        <input type="hidden"
                                                               name="id"
                                                               id="download_produktdoc_id_{{ $produktDoc->id }}"
                                                               value="{{ $produktDoc->id }}"
                                                        >
                                                    </form>
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();">
                                                        <span class="fas fa-download"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="small text-muted">Keine Dateien zum Produkt gefunden!</p>
                                @endif

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
    <script>
        $('.tooltips').tooltip();

        $('#btnGetAnforderungsListe').click( () => {
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungByVerordnungListe') }}",
                data: {id:$('#setAnforderung :selected').val()},
                success: function(res)  {
                    $('#anforderung_id').html(res.html);
                }
            });
        })

        $('#anforderung_id').change( () => {

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungData') }}",
                data: {id:$('#anforderung_id :selected').val()},
                success: (res) => {
                    const ver = $('#setAnforderung option:selected').text();
                    const intervall = (res.an_control_interval>0)? res.an_control_interval :'-';
                    const icon = (res.an_test_has) ? '<span class="fas fa-check text-success"></span>' : '<span class="fas fa-times text-muted"></span>';
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
                            <dt class="col-sm-4">Prüfung</dt>
                            <dd class="col-sm-8">${icon}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Intervall</dt>
                            <dd class="col-sm-8">${res.an_control_interval} Monate</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Beschreibung</dt>
                            <dd class="col-sm-8">${res.an_name_text}</dd>
                        </dl>
            `);
                }
            });
        });


    </script>
@endsection

@section('autoloadscripts')
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $("#srchInAdminBereich").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "{{ route('acAdminLocations') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {

                console.log(ui.item.value);
                console.log(ui.item.value);
                location.href = `/${ui.item.group}/${ui.item.value}`;

            }

        });
        $(".getFirma").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('getFirmenAjaxListe') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        let resp = $.map(data,function(obj){
                            return {
                                label : `(${obj.fa_kreditor_nr}) ${obj.fa_name_lang} - ${obj.ad_anschrift_ort} - ${obj.ad_anschrift_strasse}` ,
                                id:obj.id,
                                value:obj.fa_name_kurz
                            };
                        });
                        response(resp);
                    }
                });
            },
            select: function (event, ui) {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('getFirmenDaten') }}",
                    data: {id:ui.item.id},
                    success: (res) => {
                        $('#btnMakeNewFirma').text('Details');
                        $('#fa_name_kurz').val(res.firma.fa_name_kurz);
                        $('#fa_debitor_nr').val(res.firma.fa_debitor_nr);
                        $('#fa_kreditor_nr').val(res.firma.fa_kreditor_nr);
                        $('#fa_name_lang, #searchFirma').val(res.firma.fa_name_lang);
                        $('#fa_vat').val(res.firma.fa_vat);
                        $('#firma_id, #firma_id_tabfp').val(res.firma.id);
                        $('#adress_id').val(res.firma.adress_id);
                        $('#searchAddress').val(`${res.adresse.ad_anschrift_strasse} ${res.adresse.ad_anschrift_hausnummer} / ${res.adresse.ad_anschrift_ort}`);
                        $('#address_type_id').val(res.adresse.address_type_id);
                        $('#ad_name_kurz').val(res.adresse.ad_name_kurz);
                        $('#ad_anschrift_strasse').val(res.adresse.ad_anschrift_strasse);
                        $('#ad_anschrift_hausnummer').val(res.adresse.ad_anschrift_hausnummer);
                        $('#ad_anschrift_ort').val(res.adresse.ad_anschrift_ort);
                        $('#ad_anschrift_plz').val(res.adresse.ad_anschrift_plz);
                        $('#ckAddNewFirma').prop('checked', false);
                        $('#ckAddNewAddress').prop('checked', false);
                        $('#ckAddNewContact').prop('checked', false);

                        $('#con_name_kurz').val(res.contact.con_name_kurz);
                        $('#con_vorname').val(res.contact.con_vorname);
                        $('#con_name').val(res.contact.con_name);
                        $('#con_email').val(res.contact.con_email);
                        $('#con_telefon').val(res.contact.con_telefon);
                        $('#anrede_id').val(res.contact.anrede_id);
                        // $.each(res.contactnction (key, item) {
                        //     $('#setContact').append(`
                        //     <option value="${item.id}">${item.con_vorname} ${item.con_name}</option>
                        //     `);
                        // });

                    }
                });
            }
        });

        $(".getAddress").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('getAddressenAjaxListe') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        let resp = $.map(data,function(obj){
                            return {
                                label : `(${obj.ad_name_kurz}) ${obj.ad_name_lang} - ${obj.ad_anschrift_ort} - ${obj.ad_anschrift_strasse}` ,
                                id:obj.id,
                                value:obj.ad_name_kurz
                            };
                        });
                        response(resp);
                    }
                });
            },
            select: function (event, ui) {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('getAddressDaten') }}",
                    data: {id:ui.item.id},
                    success: (res) => {
                        $('#searchAddress').val(`${res.adresse.ad_anschrift_strasse} ${res.adresse.ad_anschrift_hausnummer} / ${res.adresse.ad_anschrift_ort}`);
                        $('#adress_id').val(res.adresse.id);
                        $('#address_type_id').val(res.adresse.address_type_id);
                        $('#ad_name_kurz').val(res.adresse.ad_name_kurz);
                        $('#ad_anschrift_strasse').val(res.adresse.ad_anschrift_strasse);
                        $('#ad_anschrift_hausnummer').val(res.adresse.ad_anschrift_hausnummer);
                        $('#ad_anschrift_ort').val(res.adresse.ad_anschrift_ort);
                        $('#ad_anschrift_plz').val(res.adresse.ad_anschrift_plz);
                        $('#ckAddNewAddress').prop('checked', false);
                    }
                });
            }
        });

        $('#ckAddNewFirma').click(function () {
            if ($(this).prop('checked')) {
                $('#firma_id').val('');
                $('#fa_name_kurz')
                    .val('')
                    .attr('placeholder','Bitte ein neues Kürzel vergeben!')
                    // .addClass('border-warning')
                    .focus();
            }
        });
        $('#ckAddNewAddress').click(function () {
            if ($(this).prop('checked')) {
                $('#adress_id').val('');
                $('#ad_name_kurz')
                    .val('')
                    .attr('placeholder','Bitte ein neues Kürzel vergeben!')
                    .addClass('border-warning')
                    .focus();
            }
        });
        $('#ad_name_kurz').blur(function () {
            ($(this).val()!=='' && $(this).hasClass('border-warning')) ? $(this).removeClass('border-warning'):$(this).addClass('border-warning');
        })

        $('#fa_name_kurz').blur(function () {
            ($(this).val()!=='' && $(this).hasClass('border-warning')) ? $(this).removeClass('border-warning'):$(this).addClass('border-warning');
        })
    </script>
@endsection
