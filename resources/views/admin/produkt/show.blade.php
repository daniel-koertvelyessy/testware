@extends('layout.layout-admin')

@section('pagetitle')
    {{ __('Produkt :label bearbeiten',['label'=>$produkt->prod_nummer]) }} &triangleright; {{__('Produkte')}}@endsection

@section('mainSection')
    {{ __('Produktübersicht') }}
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('breadcrumbs')
    {{--  <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <a href="/">{{ __('Portal')}}</a>
              </li>
              <li class="breadcrumb-item">
                  <a href="{{ route('produkt.index') }}">{{ __('Produkte')}}</a>
              </li>
              <li class="breadcrumb-item">
                  <a href="/produkt/kategorie/{{ $produkt->ProduktKategorie->id }}">{{ $produkt->ProduktKategorie->pk_label }}</a>
              </li>
              <li class="breadcrumb-item active"
                  aria-current="page"
              >{{ $produkt->prod_nummer }}</li>
          </ol>
      </nav>--}}
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
            ><i class="fas fa-table"></i> {{__('Parameter hinzufügen')}}</a>
            <a class="dropdown-item"
               href="#"
            ><i class="fas fa-list"></i> {{__('Label drucken')}}</a>
            @can('isAdmin', Auth::user())
                <a class="dropdown-item"
                   href="#"
                   data-toggle="modal"
                   data-target="#modalDeleteProdukt"
                ><i class="far fa-trash-alt"></i> {{__('Produkt löschen')}}</a>
            @endcan
        </ul>
    </li>
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

                        <x-btnMain>{{__('Neue Kategorie anlegen')}}
                            <span class="fas fa-download ml-2"></span>
                        </x-btnMain>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade"
         id="modalSyncRequirement"
         tabindex="-1"
         aria-labelledby="modalSyncRequirementLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{__('Prüfungen Syncronisieren')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">Bitte die Geräte aussuchen, welche neue Prüftermine erhalten sollen.</p>
                    <form action="{{ route('control.sync') }}#productRequirements"
                          method="POST"
                          class="needs-validation"
                          id="frmSyncRequirement"
                          name="frmSyncRequirement"
                    >
                        @csrf
                        <table class="table table-responsive-md table-striped"
                               id="tabProduktEquipmentListe"
                        >
                            <thead>
                            <tr>
                                <th> {{__('Inventarnummer')}}</th>
                                <th> {{__('Seriennummer')}}</th>
                                <th> <input class="form-check-input"
                                            type="checkbox"
                                            value="1"
                                            id="selectAllSyncItems"
                                    >
                                    <label class="form-check-label"
                                           for="selectAllSyncItems"
                                    >
                                        {{ __('auswählen') }}
                                    </label></th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($equipLists as $equipment)
                                <tr>
                                    <td>
                                        {{ $equipment->eq_inventar_nr }}
                                    </td>
                                    <td>
                                        {{ $equipment->eq_serien_nr }}
                                    </td>
                                    <td class="d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input syncItem"
                                                   type="checkbox"
                                                   name="sycEquip[]"
                                                   id="sycEquip{{ $equipment->eq_uid }}"
                                                   value="{{ $equipment->eq_uid }}"
                                            >
                                            <label class="form-check-label"
                                                   for="sycEquip{{ $equipment->eq_uid }}"
                                            >auswählen
                                            </label>
                                        </div>
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



                        <div class="form-check my-2 my-md-4">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   id="sycEquipWithDeletion"
                                   name="sycEquipWithDeletion"
                            >
                            <label class="form-check-label"
                                   for="sycEquipWithDeletion"
                            >
                                Existierende Prüfungen löschen
                            </label>
                        </div>

                        <x-btnMain>{{__('Prüftermine syncronisieren')}}
                            <span class="fas fa-download ml-2"></span>
                        </x-btnMain>

                    </form>
                </div>

            </div>
        </div>
    </div>

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
                                <x-textfield id="doctyp_label"
                                             label="{{__('Kürzel')}}"
                                             required
                                />
                                <x-textfield id="doctyp_name"
                                             label="{{__('Bezeichnung')}}"
                                />
                                <x-textarea id="doctyp_description"
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
                <form action="{{ route('productparameter.store') }}#Parameter"
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
                        <h5 class="modal-title">{{__('Neuen Parameter für Produkt anlegen')}}</h5>
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
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="checkAddParameterToEquipment"
                                           name="checkAddParameterToEquipment"
                                    >
                                    <label class="custom-control-label"
                                           for="checkAddParameterToEquipment"
                                    >
                                        {{ __('Paramter auch für abgeleitete Geräte anfügen') }}
                                    </label>
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
         id="modalDeleteProdukt"
         tabindex="-1"
         aria-labelledby="modalDeleteProdukt"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
            <div class="modal-content">
                <form action="{{ route('produkt.destroy',$produkt) }}"
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

    <!-- Dialog addQualifiedUser  -->
    <div class="modal fade"
         id="addQualifiedUser"
         tabindex="-1"
         aria-labelledby="addQualifiedUserLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="addQualifiedUserLabel"
                    >{{__('Befähigte Person hinzufügen')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ProductQualifiedUser.store') }}#productRequirements"
                      method="post"
                >
                    <div class="modal-body">

                        @csrf
                        <input type="hidden"
                               name="produkt_id"
                               id="product_id_qualified_user"
                               value="{{ $produkt->id }}"
                        >
                        <div class="row">
                            <div class="col-md-4">
                                <x-datepicker id="product_qualified_date"
                                              label="{{ __('Befähigung erhalten am') }}"
                                              value="{{ date('Y-m-d') }}"
                                />
                            </div>
                            <div class="col-md-8">
                                @if($hasExternalSupplier)
                                    <x-selectfield id="product_qualified_firma"
                                                   label="{{__('durch Firma / Institution')}}"
                                    >
                                        @forelse($produkt->firma as $firma)
                                            <option value="{{ $firma->id }}">{{ $firma->fa_name }}</option>
                                        @empty
                                            @foreach(App\Firma::all() as $company)
                                                <option value="{{ $company->id }}">{{ $company->fa_name }}</option>
                                            @endforeach
                                        @endforelse
                                    </x-selectfield>
                                @else
                                    <label>{{__('durch Firma / Institution')}}</label>
                                    <div class="alert alert-info">
                                        {{ __('Bislang sind keine Firmen für dieses Produkt hinterlegt worden.') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <x-selectfield id="user_id"
                                               label="{{__('Mitarbeiter')}}"
                                >
                                    @foreach(App\User::all() as $user)
                                        @if(! $user->isQualifiedForProduct($produkt->id))
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </x-selectfield>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($hasExternalSupplier)
                            <button class="btn btn-primary">
                                {{__('Befähigte Person anlegen')}}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="addInstructedUser"
         tabindex="-1"
         aria-labelledby="addInstructedUserLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <form action="{{ route('ProductInstruction.store') }}#productRequirements"
                  method="post"
                  id="frmAddEquipmentInstruction"
            >
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="addInstructedUserLabel"
                        >{{__('Unterwiesene Person hinzufügen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden"
                               name="produkt_id"
                               id="product_id_instructions_modal"
                               value="{{ $produkt->id }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-datepicker id="product_instruction_date"
                                              label="{{__('Unterweisung erfolgte am')}}"
                                              value="{{ date('Y-m-d') }}"
                                              required
                                />
                                <x-selectfield id="product_instruction_trainee_id"
                                               label="{{__('Unterwiesene Person')}}"
                                >
                                    @foreach(App\Profile::all() as $trainee)
                                        @if(! $trainee->isInstructed($produkt->id) && ! $trainee->isQualified($produkt->id))
                                            <option value="{{ $trainee->id }}">{{ $trainee->fullName() }}</option>
                                        @endif
                                    @endforeach
                                </x-selectfield>
                            </div>
                            <div class="col-md-6">
                                @if($hasQualifiedUser)
                                    <x-selectfield id="product_instruction_instructor_profile_id"
                                                   label="{{__('Interne Unterweisung durch')}}"
                                                   required
                                    >
                                        <option value="0">{{ __('bitte auswählen') }}</option>
                                        @foreach($qualifiedUserList as $qualifiedUser)
                                            <option value="{{ $qualifiedUser->user->id }}">{{ $qualifiedUser->user->name }}</option>
                                        @endforeach
                                    </x-selectfield>
                                @else
                                    <label>Interne Unterweisung durch</label>
                                    <div class="alert alert-info">
                                        {{ __('Bislang sind keine Personen für dieses Produkt befähigt wurden.') }}
                                    </div>
                                @endif

                                @if($hasExternalSupplier)
                                    <x-selectfield id="product_instruction_instructor_firma_id"
                                                   label="{{__('Externe Unterweisung durch')}}"
                                    >
                                        <option value="0">{{__('bitte auswählen')}}</option>
                                        @foreach($produkt->firma as $firma)
                                            <option value="{{ $firma->id }}">{{ $firma->fa_name }}</option>
                                        @endforeach
                                    </x-selectfield>
                                @else
                                    <label>Externe Unterweisung durch</label>
                                    <div class="alert alert-info">
                                        {{ __('Bislang sind keine Firmen für dieses Produkt verknüpft worden.') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label>{{__('Unterschrift Unterwiesener')}}</label>
                                    <div>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnClearCanvas"
                                                data-targetpad="trainee"
                                        >{{__('Neu')}}</button>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnSignZuruck"
                                                data-targetpad="trainee"
                                        >{{__('Zurück')}}</button>
                                    </div>
                                </div>
                                <input type="hidden"
                                       name="product_instruction_trainee_signature"
                                       id="product_instruction_trainee_signature"
                                >
                                <div class="wrapper">
                                    <canvas id="signatureField_product_instruction_trainee_signature"
                                            class="signature-pad"
                                    ></canvas>
                                </div>
                                <span class="small text-primary">{{ __('erforderliches Feld') }}</span>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label>{{__('Unterschrift Einweiser')}}</label>
                                    <div>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnClearCanvas"
                                                data-targetpad="instructor"
                                        >{{__('Neu')}}</button>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnSignZuruck"
                                                data-targetpad="instructor"
                                        >{{__('Zurück')}}</button>
                                    </div>
                                </div>
                                <input type="hidden"
                                       name="product_instruction_instructor_signature"
                                       id="product_instruction_instructor_signature"
                                >
                                <div class="wrapper">
                                    <canvas id="signatureField_product_instruction_instructor_signature"
                                            class="signature-pad"
                                    ></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="selectedErrorMsg"
                             class="text-danger small"
                        ></div>
                        @if($hasExternalSupplier && $hasQualifiedUser)
                            <button type="button"
                                    id="btnStoreInstructedUser"
                                    class="btn btn-primary"
                            >{{ __('Unterweisung
                        erfassen')
                        }}</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-modals.modalAddRequirement route="{{ route('addProduktAnforderung') }}"
                                  tabTarget="productRequirements"
                                  objectIdLabel="produkt_id"
                                  :object="$produkt"
    />

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-2 d-md-flex d-none">
            <div class="col-md-6">
                <h1 class="h4">{{ __('Produktübersicht') }}</h1>
            </div>
            <div class="col-md-6 text-right">
                <p class="text-muted small">
                    {{ __('Produkt') }}-UUID <br>{{ $produkt->prod_uuid }}
                </p>
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
                           id="prodbase_data-tab"
                           data-toggle="tab"
                           href="#prodbase_data"
                           role="tab"
                           aria-controls="prodbase_data"
                           aria-selected="true"
                        >{{__('Stammdaten')}}</a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="Parameter-tab"
                           data-toggle="tab"
                           href="#Parameter"
                           role="tab"
                           aria-controls="Parameter"
                           aria-selected="false"
                        >{{__('Parameter')}}
                            <span class="badge badge-primary"
                            >{{ $params->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="productRequirements-tab"
                           data-toggle="tab"
                           href="#productRequirements"
                           role="tab"
                           aria-controls="productRequirements"
                           aria-selected="false"
                        >{{__('Anforderungen')}}
                            <span class="badge badge-primary"
                            >{{ $produkt->ProduktAnforderung->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="prodCompany-tab"
                           data-toggle="tab"
                           href="#prodCompany"
                           role="tab"
                           aria-controls="prodCompany"
                           aria-selected="false"
                        >{{__('Firmen')}}
                            <span class="badge badge-primary">{{  $produkt->firma->count() }}</span>
                        </a>
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
                        >{{__('Dokumente')}}
                            <span class="badge badge-primary"
                            >{{ $produkt->ProduktDoc->count() }}</span>
                        </a>
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
                        >{{__('Geräte')}}
                            <span class="badge badge-primary"
                            >{{ $produkt->Equipment->count() }}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content px-2 pt-4"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active"
                         id="prodbase_data"
                         role="tabpanel"
                         aria-labelledby="prodbase_data-tab"
                    >
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('produkt.update',$produkt) }}"
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
                                        <div class="col-md-4">
                                            <x-textfield id="prod_name"
                                                         label="{{__('Bezeichnung')}}"
                                                         value="{!! $produkt->prod_name !!}"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <x-textfield id="prod_nummer"
                                                         label="Nummer"
                                                         value="{!! $produkt->prod_nummer !!}"
                                            />
                                        </div>
                                        <div class="col md-4">
                                            <div class="input-group">
                                                <x-selectModalgroup id="produkt_kategorie_id"
                                                                    label="{{__('Kategorie')}}"
                                                                    modalid="modalAddProduktKategorie"
                                                >
                                                    @foreach (App\ProduktKategorie::all() as $produktKategorie)
                                                        <option value="{{ $produktKategorie->id }}"
                                                                @if($produktKategorie->id === $produkt->produkt_kategorie_id)
                                                                    selected
                                                                @endif
                                                        >
                                                            {{ $produktKategorie->pk_name }}
                                                        </option>
                                                    @endforeach
                                                </x-selectModalgroup>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <x-rtextfield id="prod_label"
                                                          label="{{__('Kurzbezeichnung / Spezifikation')}}"
                                                          value="{!! $produkt->prod_label !!}"
                                            />
                                        </div>
                                        <div class="col-md-3">
                                            <x-selectfield id="produkt_state_id"
                                                           label="{{__('Produkt Status')}}"
                                            >
                                                @foreach (App\ProduktState::all() as $produktState)
                                                    <option value="{{ $produktState->id }}" {{ ($produkt->produkt_state_id===$produktState->id)? ' selected ' : ''  }}>{{ $produktState->ps_label }}</option>
                                                @endforeach
                                            </x-selectfield>
                                        </div>
                                        <div class="col-md-2">
                                            <x-selectfield id="equipment_label_id"
                                                           label="{{__('Produkt Label')}}"
                                            >
                                                @foreach ($labels as $label)
                                                    <option value="{{ $label->id }}" {{ ($produkt->equipment_label_id===$label->id)? ' selected ' : ''  }}>{{ $label->name }}</option>
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
                                                            {{ ($produkt->prod_active==1)? ' checked ' : ''  }}
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
                                        <div class="col">
                                            <x-textarea id="prod_description"
                                                        label="Beschreibung"
                                                        value="{!! $produkt->prod_description !!}"
                                            />
                                        </div>
                                    </div>

                                    <x-btnMain>
                                        {{__('Produkt speichern')}}
                                        <span class="fas fa-download ml-3"></span>
                                    </x-btnMain>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade"
                         id="Parameter"
                         role="tabpanel"
                         aria-labelledby="Parameter-tab"
                    >
                        <div class="row">
                            <div class="col">
                                @if($params->count()===0)
                                    <div class="alert alert-info alert-dismissible fade show"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Hinweis') }}</h4>

                                        <p class="lead">{{ __('Paramter können Produkte und Geräte um Datenfelder ergänzen,
                                welche nur auf dem jeweiligen Objekt sichtbar sind.')
                            }}</p>
                                        <p>{{ __('Tipp: Sie können Parameter auch für Produktkategorien anlegen und so
                                    bequem
                                 bestimmte Parametergruppen erstellen. Beispiel: Produkte einer Kategorie Elektrogeräte
                                 können eigene Parameter wie Nennleistung, Nennstrom oder Nennspannung erhalten.')
                                 }}</p>

                                        <button type="button"
                                                class="close"
                                                data-dismiss="alert"
                                                aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <x-parameters.paramfield :params="$params"
                                                     :isproduct="true"
                            />
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="productRequirements"
                         role="tabpanel"
                         aria-labelledby="productRequirements-tab"
                    >
                        <div class="row">

                            <div class="col-md-7 mb-3 border-md-right border-dark">
                                <div class="d-flex justify-content-between">
                                    <h3 class="h5">{{__('Befähigte Personen')}}</h3>

                                    @if($hasExternalSupplier)
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-toggle="modal"
                                                data-target="#addQualifiedUser"
                                        >
                                            {{ __('Person hinzufügen') }} <i class="fas fa-user-plus ml-2"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-outline-warning btn-sm"
                                                data-toggle="modal"
                                                data-target="#noExternalCompanyFoundModal"
                                        >
                                            {{ __('Person hinzufügen') }} <i class="fas fa-user-plus ml-2"></i>
                                        </button>

                                        <div class="modal fade"
                                             id="noExternalCompanyFoundModal"
                                             tabindex="-1"
                                             aria-labelledby="noExternalCompanyFoundModalLabel"
                                             aria-hidden="true"
                                        >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header alert-warning">
                                                        <h5 class="modal-title"
                                                            id="noExternalCompanyFoundModalLabel"
                                                        >{{ __('Fehlende Voraussetzungen beheben') }}</h5>
                                                        <button type="button"
                                                                class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close"
                                                        >
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="lead">{{ __('Diesem Produkt muss noch eine Firma zugeordnet werden, damit diese eine Person im Umgang mit dem Produkt befähigen kann.') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary"
                                                                data-dismiss="modal"
                                                        >{{ __('Alles klar') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                                <table class="table table-responsive-md">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Qualifiziert am') }}</th>
                                        <th>{{ __('durch') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse (\App\ProductQualifiedUser::where('produkt_id',$produkt->id)->get() as $qualifiedUser)
                                        <tr>
                                            <td>{{ $qualifiedUser->user->name }} </td>
                                            <td>{{ $qualifiedUser->product_qualified_date }}</td>
                                            <td>{{ $qualifiedUser->firma->fa_name ?? '-' }}</td>
                                            <td style="padding: 0; vertical-align: middle; text-align: right;">
                                                <form action="{{ route('ProductQualifiedUser.destroy',$qualifiedUser) }}"
                                                      method="post"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_delete_Qualified_User_{{ $qualifiedUser->id }}"
                                                           value="{{ $qualifiedUser->id }}"
                                                    >
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <span class="d-none d-lg-inline mr-2">{{ __('Löschen') }}</span>
                                                        <span class="far fa-trash-alt"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <p class="m-2">
                                                    <x-notifyer>{{__('Keine befähigte Personen gefunden')}}</x-notifyer>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="dropdown-divider my-4"></div>
                                <div class="d-flex justify-content-between">
                                    <h3 class="h5">{{__('Unterwiesene Personen')}}</h3>
                                    @if($hasExternalSupplier && $hasQualifiedUser)
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-toggle="modal"
                                                data-target="#addInstructedUser"
                                        >
                                            {{ __('Person hinzufügen') }} <i class="fas fa-user-plus ml-2"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-outline-warning btn-sm"
                                                data-toggle="modal"
                                                data-target="#noExternalCompanyOrQualifiedUserFoundModal"
                                        >
                                            {{ __('Person hinzufügen') }} <i class="fas fa-user-plus ml-2"></i>
                                        </button>

                                        <div class="modal fade"
                                             id="noExternalCompanyOrQualifiedUserFoundModal"
                                             tabindex="-1"
                                             aria-labelledby="noExternalCompanyOrQualifiedUserFoundModalLabel"
                                             aria-hidden="true"
                                        >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header alert-warning">
                                                        <h5 class="modal-title"
                                                            id="noExternalCompanyOrQualifiedUserFoundModalLabel"
                                                        >{{ __('Fehlende Voraussetzungen beheben') }}</h5>
                                                        <button type="button"
                                                                class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close"
                                                        >
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="lead">{{ __('Bitte die benötigten Voraussetzungen erfüllen, damit befähigte Personen angelegt werden können. ') }}</p>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                @if($hasExternalSupplier)
                                                                    <i class="far fa-check-square text-success mr-1"></i>
                                                                @else
                                                                    <i class="far fa-square text-muted mr-1"></i>
                                                                @endif
                                                                {{ __('Dem Produkt wurde mind. eine Firma zugeordet') }}
                                                            </li>
                                                            <li>
                                                                @if($hasQualifiedUser)
                                                                    <i class="far fa-check-square text-success mr-1"></i>
                                                                @else
                                                                    <i class="far fa-square text-muted mr-1"></i>
                                                                @endif
                                                                {{ __('Dem Produkt wurde mind. eine befähigte Person zugeordet') }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary"
                                                                data-dismiss="modal"
                                                        >{{ __('Alles klar') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <table class="table table-responsive-md">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Unterwiesen am')}}</th>
                                        <th>{{__('gez.')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse (\App\ProductInstructedUser::where('produkt_id',$produkt->id)->get() as $instructedUser)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $instructedUser->profile->fullName() }}</td>
                                            <td style="vertical-align: middle;">{{ $instructedUser->product_instruction_date }}</td>
                                            <td>
                                                <img src="{{ $instructedUser->product_instruction_trainee_signature }}"
                                                     class="img-fluid"
                                                     style="max-height: 40px"
                                                     alt="unterschrift"
                                                >
                                            </td>
                                            <td style="vertical-align: middle; text-align:right; padding:0">
                                                <form action="{{ route('ProductInstruction.destroy',$instructedUser) }}#requirements"
                                                      method="post"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_delete_ProductInstruction_{{ $instructedUser->id }}"
                                                           value="{{ $instructedUser->id }}"
                                                    >
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <span class="d-none d-lg-inline">{{__('Löschen')}}</span>
                                                        <span class="far fa-trash-alt ml-2"
                                                        ></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <x-notifyer>{{__('Keine unterwiesene Personen gefunden')}}</x-notifyer>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="h5">{{__('Anforderungen')}}</h2>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary"
                                                data-toggle="modal"
                                                data-target="#modalAddRequirement"
                                        >
                                            {{ __('hinzufügen') }}
                                            <span class="fas fa-plus ml-1"></span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary"
                                                data-toggle="modal"
                                                data-target="#modalSyncRequirement"
                                        >
                                            {{ __('Prüfungen sync') }}
                                            <span class="fas fa-sync ml-1"></span>
                                        </button>
                                    </div>

                                </div>

                                @forelse ($requirementList as $produktAnforderung)
                                    @if ($produktAnforderung->anforderung_id!=0)
                                        <x-requirement_box :requirement="$produktAnforderung->Anforderung"
                                                           :produkt="$produkt"
                                                           :produktAnforderungId="$produktAnforderung->id"
                                        />
                                    @endif
                                @empty
                                    <p class="text-muted small">{{ __('Bislang sind keine Anforderungen verknüpft')}}
                                        !</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="prodCompany"
                         role="tabpanel"
                         aria-labelledby="prodCompany-tab"
                    >
                        <div class="row">
                            @can('isAdmin', Auth::user())
                                <div class="col-md-8">
                                    <form action="{{ route('addProduktFirma') }}#prodCompany"
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
                                                    id="btnSectionFirmaDetails"
                                            >
                                                <span id="btnMakeNewFirma">{{__('Neu')}}</span>
                                                <span class="fas fa-angle-down"
                                                ></span>
                                            </button>
                                            <button class="btn btn-primary ml-1">{{__('Zuordnen')}}
                                                <span class="fas fa-angle-right"
                                                ></span>
                                            </button>
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
                                                        <x-textfield id="fa_label"
                                                                     label="{{__('Kürzel')}}"
                                                                     class="getFirma checkLabel"
                                                                     required
                                                                     max="20"
                                                        />
                                                        <span class="small text-primary getFirmaRes"></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <x-textfield id="fa_name"
                                                                     label="{{__('Name')}}"
                                                                     class="getFirma"
                                                                     max="100"
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
                                                        <x-textfield id="ad_labels"
                                                                     name="ad_label"
                                                                     label="{{ __('Kürzel') }}"
                                                                     class="getAddress checkLabel"
                                                                     max="20"
                                                        />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <x-selectfield id="address_type_id"
                                                                       label="{{__('Adresse Typ')}}"
                                                        >
                                                            @foreach (App\AddressType::all() as $addressType)
                                                                <option value="{{ $addressType->id }}"
                                                                >{{ $addressType->adt_name }}</option>
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
                                                                <option value="{{ $country->id }}"
                                                                >{{ $country->land_iso }}</option>
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
                                                    <h3 class="h5">{{__('Kontakt - Daten')}}</h3>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                               class="custom-control-input"
                                                               id="ckAddNewContact"
                                                               name="ckAddNewContact"
                                                               value="1"
                                                        >
                                                        <label class="custom-control-label"
                                                               for="ckAddNewContact"
                                                        >{{__('Kontakt neu anlegen')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-5">
                                                        <x-textfield id="con_label"
                                                                     label="{{ __('Kürzel') }}"
                                                                     max="20"
                                                        />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <x-selectfield id="anrede_id"
                                                                       label="{{ __('Anrede') }}"
                                                        >
                                                            @foreach (App\Anrede::all() as $anrede)
                                                                <option value="{{ $anrede->id }}"
                                                                >{{ $anrede->an_kurz }}</option>
                                                            @endforeach
                                                        </x-selectfield>

                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-5">
                                                        <x-textfield id="con_vorname"
                                                                     label="{{ __('Vorname') }}"
                                                                     max="100"
                                                        />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <x-textfield id="con_name"
                                                                     label="{{ __('Nachname') }}"
                                                                     max="100"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-5">
                                                        <x-textfield id="con_telefon"
                                                                     label="{{ __('Telefon') }}"
                                                                     max="100"
                                                        />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <x-emailfield id="con_email"
                                                                      name="con_email"
                                                                      label="E-Mail Adresse"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- Kontakt Details -->
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                        @forelse ($produkt->firma as $firma)
                                            <x-addresslabel firma="{!!  $firma->fa_name !!}"
                                                            address="{{ $firma->Adresse->ad_anschrift_strasse }} - {{ $firma->Adresse->ad_anschrift_ort }}"
                                                            firmaid="{{ $firma->id }}"
                                                            produktid="{{ $produkt->id }}"
                                            ></x-addresslabel>
                                        @empty
                                            <x-notifyer>{{ __('Dem Produkt ist keine Firma zugeordnet.') }}</x-notifyer>
                                        @endforelse

                                    </div>
                                </div>

                            @else
                                <div class="col">
                                    <div class="list-group">
                                        @foreach ($produkt->firma as $firma)
                                            <x-addresslabel firma="{!!  $firma->fa_name !!}"
                                                            address="{{ $firma->Adresse->ad_anschrift_strasse }} - {{ $firma->Adresse->ad_anschrift_ort }}"
                                                            firmaid="{{ $firma->id }}"
                                                            produktid="{{ $produkt->id }}"
                                            ></x-addresslabel>
                                        @endforeach

                                    </div>
                                </div>
                            @endcan
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
                                    <h2 class="h5">{{__('Dokument an Produkt anhängen')}}
                                        <span class="small text-muted"
                                        >max 20MB</span>
                                    </h2>

                                    <input type="hidden"
                                           name="produkt_id"
                                           id="produkt_id_doku"
                                           value="{{ $produkt->id }}"
                                    >
                                    <div class="form-group">
                                        <label for="document_type_id">{{__('Dokument Typ')}}</label>
                                        <div class="input-group">
                                            <select name="document_type_id"
                                                    id="document_type_id"
                                                    class="custom-select"
                                            >
                                                @foreach (App\DocumentType::all() as $ad)
                                                    <option value="{{ $ad->id }}">{{ $ad->doctyp_label }}</option>
                                                @endforeach
                                            </select>
                                            @can('isAdmin', Auth::user())
                                                <button type="button"
                                                        class="btn-outline-primary btn ml-2"
                                                        data-toggle="modal"
                                                        data-target="#modalAddDokumentType"
                                                >
                                                    <span class="fas fa-plus"></span> {{__('neuen Typ anlegen')}}
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                    <x-textfield id="proddoc_label"
                                                 label="{{__('Bezeichnung')}}"
                                                 value="{{ $produkt->proddoc_label }}"
                                    />

                                    <x-textarea id="proddoc_description"
                                                label="{{__('Datei Informationen')}}"
                                                value="{{ $produkt->proddoc_description }}"
                                    />

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
                                            >{{__('Datei wählen')}}
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">{{ __('Neues Dokument an Produkt anhängen')}}
                                        <i class="fas fa-paperclip ml-2"
                                        ></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                @if ($produkt->ProduktDoc->count()>0)
                                    <table class="table table-responsive-md table-striped table-sm">
                                        <thead>
                                        <th>{{__('Datei')}}</th>
                                        <th>{{__('Typ')}}</th>
                                        <th class="d-none d-lg-table-cell"
                                            style="text-align: right;"
                                        >{{__('Größe kB')}}
                                        </th>
                                        <th class="d-none d-lg-table-cell">{{__('Hochgeladen')}}</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach ($produkt->ProduktDoc as $produktDoc)
                                            @if(Storage::disk('local')->exists(($produktDoc->proddoc_name_pfad)))
                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        <a href="#"
                                                           onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();"
                                                        >
                                                        <span title="{{ $produktDoc->proddoc_name }}">
                                                    {{ str_limit($produktDoc->proddoc_label,25) }}
                                                    </span>
                                                        </a>
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
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ $produktDoc->DocumentType->doctyp_label }}</td>
                                                    <td class="d-none d-lg-table-cell"
                                                        style="text-align: right; vertical-align: middle;"
                                                    >{{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}</td>
                                                    <td class="d-none d-lg-table-cell"
                                                        style="vertical-align: middle;"
                                                    >{{ $produktDoc->created_at->DiffForHumans() }}</td>
                                                    <td>
                                                        <x-deletebutton prefix="produktDoc"
                                                                        action="{{ route('produktDoku.destroy',$produktDoc->id) }}"
                                                                        id="{{ $produktDoc->id }}"
                                                        />
                                                    </td>
                                                </tr>
                                            @endif
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
                                <a href="{{ route('equipment.create',['produkt_id' => $produkt->id]) }}"
                                   class="btn btn-outline-primary mb-3"
                                >{{ __('Gerät aus Produkt erstellen') }}</a>
                                <table class="table table-responsive-md table-striped"
                                       id="tabProduktEquipmentListe"
                                >
                                    <thead>
                                    <tr>
                                        <th>@sortablelink('produktDetails.eq_inventar_nr', __('Inventarnummer'))</th>
                                        <th>@sortablelink('produktDetails.eq_serien_nr', __('Seriennummer'))</th>
                                        <th>@sortablelink('produktDetails.installed_at', __('Inbetriebname'))</th>
                                        <th>@sortablelink('EquipmentState.estat_label', __('Status'))</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($equipLists as $equipment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('equipment.show',$equipment) }}">{{ $equipment->eq_inventar_nr }}</a>
                                            </td>
                                            <td>
                                                {{ $equipment->eq_serien_nr }}
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($equipment->installed_at)->DiffForHumans() }}
                                            </td>
                                            <td class="d-flex align-items-center justify-content-between">
                                                {{ $equipment->EquipmentState->estat_label }}
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
                                    <div class="d-flex justify-content-center">
                                        {!! $equipLists->withQueryString()->onEachSide(2)->links() !!}
                                    </div>
                                    @if($equipLists->count() > 10) @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @error('doctyp_label')
    <script>
        $('#modalAddDokumentType').modal('show');
    </script>
    @enderror

    @error('pp_label')
    <script>
        $('#modalAddParameter').modal('show');
    </script>
    @enderror

    <script src="{{ asset('js/signatures.js') }}"></script>
    <script>
        $('.tooltips').tooltip();


        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio = Math.max(window.devicePixelRatio || 1, 1);

            // This part causes the canvas to be cleared
            trainee_pad_id.width = trainee_pad_id.offsetWidth * ratio;
            trainee_pad_id.height = trainee_pad_id.offsetHeight * ratio;
            trainee_pad_id.getContext("2d").scale(ratio, ratio);

            // This part causes the canvas to be cleared
            instructor_pad_id.width = instructor_pad_id.offsetWidth * ratio;
            instructor_pad_id.height = instructor_pad_id.offsetHeight * ratio;
            instructor_pad_id.getContext("2d").scale(ratio, ratio);

            // This library does not listen for canvas changes, so after the canvas is automatically
            // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            // that the state of this library is consistent with visual state of the canvas, you
            // have to clear it manually.
            signaturePadTrainee.clear();
            signaturePadInstructor.clear();
        }

        signatureField_product_instruction_trainee_signature
        signatureField_product_instruction_instructor_signature

        let trainee_pad_id = document.getElementById('signatureField_product_instruction_trainee_signature'),
            signaturePadTrainee = new SignaturePad(trainee_pad_id, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)',
                onEnd: function () {
                    $('#product_instruction_trainee_signature').val(this.toDataURL());
                }
            }),
            instructor_pad_id = document.getElementById('signatureField_product_instruction_instructor_signature'),
            signaturePadInstructor = new SignaturePad(instructor_pad_id, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)',
                onEnd: function () {
                    $('#product_instruction_instructor_signature').val(this.toDataURL());
                }
            });

        $('#addInstructedUser').on('shown.bs.modal', function () {
            resizeCanvas();
        });

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;

        $('.btnClearCanvas').click(function () {
            ($(this).data('targetpad') === 'trainee') ? signaturePadTrainee.clear() : signaturePadInstructor.clear();
        });
        $('.btnSignZuruck').click(function () {
            let data = ($(this).data('targetpad') === 'trainee') ? signaturePadTrainee.toData() : signaturePadInstructor.toData();
            if (data) {
                data.pop(); // remove the last dot or line\n'+
                ($(this).data('targetpad') === 'trainee') ? signaturePadTrainee.fromData(data) : signaturePadInstructor.fromData(data);
            }
        });

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

        $('#proddoc_label').val(
            $('#document_type_id :selected').text() + ' ' + $('#prod_name').val()
        );

        $('#document_type_id').change(() => {
            $('#proddoc_label').val(
                $('#document_type_id :selected').text() + ' ' + $('#prod_name').val()
            );
        });

        $('#btnSectionFirmaDetails').click(function () {
            $('#ckAddNewFirma, #ckAddNewAddress, #ckAddNewContact').prop('checked', true);


        });


        $('#anforderung_id').change(() => {

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungData') }}",
                data: {id: $('#anforderung_id :selected').val()},
                success: (res) => {
                    const text = (res.an_description === null) ? '-' : res.an_description;
                    $('#produktAnforderungText').html(`
                         <dl class="row">
                            <dt class="col-sm-4">{{__('Gehört zu Verordnung')}}</dt>
                            <dd class="col-sm-8">${res.verordnung.vo_label}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">{{__('Anforderung')}}</dt>
                            <dd class="col-sm-8">${res.an_label}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">{{__('Name')}}</dt>
                            <dd class="col-sm-8">${res.an_name}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">{{__('Intervall')}}</dt>
                            <dd class="col-sm-8">${res.an_control_interval}  ${res.control_interval.ci_name}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">{{__('Beschreibung')}}</dt>
                            <dd class="col-sm-8">${text}</dd>
                        </dl>
            `);
                }
            });
        });
    </script>

    <script>

        $('#selectAllSyncItems').click(function () {
             $('.syncItem').prop('checked',$(this).prop('checked'));
        })

        $('#btnStoreInstructedUser').click(function () {
            let checkInstructorIsSelected = false;
            let checkTraneeHasSignature = false;
            let checkInstructorHasSignature = false;

            let msg = '';

            const selectedErrorMsg = $('#selectedErrorMsg');
            const product_instruction_instructor_profile_id = $('#product_instruction_instructor_profile_id');
            const product_instruction_instructor_firma_id = $('#product_instruction_instructor_firma_id');
            const product_instruction_trainee_signature = $('#product_instruction_trainee_signature');
            const signatureField_product_instruction_trainee_signature = $('#signatureField_product_instruction_trainee_signature');
            const signatureField_product_instruction_instructor_signature = $('#signatureField_product_instruction_instructor_signature');
            const product_instruction_instructor_signature = $('#product_instruction_instructor_signature');


            if (
                product_instruction_instructor_profile_id.val() === '0' &&
                product_instruction_instructor_firma_id.val() === '0'
            ) {
                msg = msg + '<span class="mr-2">{{__('Bitte entweder eine befähigte Person oder Firma auswählen.')
                }}</span>';
                product_instruction_instructor_profile_id.addClass('is-invalid');
                product_instruction_instructor_firma_id.addClass('is-invalid');
                product_instruction_instructor_profile_id.removeClass('is-valid');
                product_instruction_instructor_firma_id.removeClass('is-valid');
                checkInstructorIsSelected = false;
            } else {
                product_instruction_instructor_profile_id.addClass('is-valid');
                product_instruction_instructor_firma_id.addClass('is-valid');
                product_instruction_instructor_profile_id.removeClass('is-invalid');
                product_instruction_instructor_firma_id.removeClass('is-invalid');
                checkInstructorIsSelected = true;
            }


            if (product_instruction_trainee_signature.val() === '') {
                msg = msg + '<span class="mr-2">{{__('Es fehlt die Unterschrift der eingewiesenen Person.')}}</span>';
                signatureField_product_instruction_trainee_signature.addClass('is-invalid');
                signatureField_product_instruction_trainee_signature.removeClass('is-valid');
                checkTraneeHasSignature = false;
            } else {
                signatureField_product_instruction_trainee_signature.addClass('is-valid');
                signatureField_product_instruction_trainee_signature.removeClass('is-invalid');
                checkTraneeHasSignature = true;
            }

            if (product_instruction_instructor_signature.val() === '') {
                msg = msg + '<span class="mr-2">{{__('Es fehlt die Unterschrift der eingewiesenen Person.')}}</span>';
                signatureField_product_instruction_instructor_signature.addClass('is-invalid');
                signatureField_product_instruction_instructor_signature.removeClass('is-valid');
                checkInstructorHasSignature = false;
            } else {
                signatureField_product_instruction_instructor_signature.addClass('is-valid');
                signatureField_product_instruction_instructor_signature.removeClass('is-invalid');
                checkInstructorHasSignature = true;
            }

            if (
                checkInstructorIsSelected &&
                checkTraneeHasSignature &&
                checkInstructorHasSignature
            ) {
                console.log(msg);
                selectedErrorMsg.html('');
                $('#frmAddEquipmentInstruction').submit();
            } else {
                console.log(msg);
                selectedErrorMsg.html(msg);
            }


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
                                label: `(${obj.fa_label}) ${obj.fa_name} `,
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

                        $('#ckAddNewFirma').prop('checked', false)
                        $('#ckAddNewAddress').prop('checked', false)
                        $('#ckAddNewContact').prop('checked', false)

                        $('#adress_id').val(res.adresse.id);
                        $('#ad_labels').val(res.adresse.ad_label);
                        $('#address_type_id').val(res.adresse.address_type_id);
                        $('#ad_anschrift_strasse').val(res.adresse.ad_anschrift_strasse);
                        $('#ad_anschrift_hausnummer').val(res.adresse.ad_anschrift_hausnummer);
                        $('#ad_anschrift_plz').val(res.adresse.ad_anschrift_plz);
                        $('#ad_anschrift_ort').val(res.adresse.ad_anschrift_ort);
                        $('#land_id').val(res.adresse.land_id);

                        $('#firma_id').val(res.firma.id);
                        $('#firma_id_tabfp').val(res.firma.id);
                        $('#fa_label').val(res.firma.fa_label);
                        $('#fa_name').val(res.firma.fa_name);
                        $('#fa_kreditor_nr').val(res.firma.fa_kreditor_nr);
                        $('#fa_debitor_nr').val(res.firma.fa_debitor_nr);
                        $('#fa_vat').val(res.firma.fa_vat);

                        if (res.contact) {
                            $('#anrede_id').val(res.contact.anrede_id);
                            $('#con_label').val(res.contact.con_label);
                            $('#con_vorname').val(res.contact.con_vorname);
                            $('#con_name').val(res.contact.con_name);
                            $('#con_telefon').val(res.contact.con_telefon);
                            $('#con_email').val(res.contact.con_email);
                        }


                    }
                });

            }
        });
    </script>

@endsection
