@extends('layout.layout-admin')

@section('mainSection')
    Standorte
@endsection

@section('pagetitle')
    Standortverwaltung | Start @ bitpack GmbH
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item"><a href="/location">Standorte</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{  $location->l_name_kurz  }}</li>
        </ol>
    </nav>
@endsection

@section('modals')
    <div class="modal" id="modalAddBuildingType" tabindex="-1" aria-labelledby="modalAddBuildingTypeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createBuildingType') }}" method="POST" class="needs-validation" id="frmCreateBuildingType" name="frmCreateBuildingType">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddBuildingTypeLabel">Neuen Gebäudetyp erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOrigin" value="location">
                        @csrf
                        <div class="form-group">
                            <label for="btname">Name</label>
                            <input type="text" name="btname" id="btname" class="form-control {{ $errors->has('btname') ? ' is-invalid ': '' }}" value="{{ old('btname') ?? '' }}" required>
                            @if ($errors->has('btname'))
                                <span class="text-danger small">{{ $errors->first('btname') }}</span>
                            @else
                                <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="btbeschreibung">Beschreibung des Gebäudetyps</label>
                            <textarea id="btbeschreibung" name="btbeschreibung" class="form-control">{{ old('btbeschreibung') ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch</button>
                        <button type="submit" class="btn btn-primary">Gebäudetyp speichern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <h1 class="h3"><span class="d-none d-md-inline">Übersicht Standort </span>{{ $location->l_name_kurz }}</h1>
{{--                <div class="visible-print text-center">
                    {!! QrCode::size(65)->generate($location->standort_id); !!}
                    <p class="text-muted small">Standort-ID</p>
                </div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active" id="locStammDaten-tab" data-toggle="tab" href="#locStammDaten" role="tab" aria-controls="locStammDaten" aria-selected="true">Stammdaten</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="locGebauede-tab" data-toggle="tab" href="#locGebauede" role="tab" aria-controls="locGebauede" aria-selected="false">Gebäude <span class="badge badge-info">{{ $location->Building->count() }}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2 " id="locStammDaten" role="tabpanel" aria-labelledby="locStammDaten-tab">
                        <form action="{{ route('location.update',['location'=>$location->id]) }}" method="post">
                            <div class="row">
                                <div class="col-lg-4">
                                    {{--                                    <h2 class="h5">Bezeichner</h2>--}}

                                    @method('PUT')
                                    @csrf

                                    <div class="form-group">
                                        <label for="l_name_kurz">Kurzbezeichnung (max 10 Zeichen)</label>
                                        <input type="text" name="l_name_kurz" id="l_name_kurz" class="form-control {{ $errors->has('l_name_kurz') ? ' is-invalid ': '' }}" maxlength="10" value="{{ $location->l_name_kurz }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="l_name_lang">Bezeichnung (max 100 Zeichen)</label>
                                        <input type="text" name="l_name_lang" id="l_name_lang" class="form-control" maxlength="100" value="{{ $location->l_name_lang ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="l_beschreibung">Beschreibung</label>
                                        <textarea name="l_beschreibung" id="l_beschreibung" class="form-control" rows="3">{{ $location->l_beschreibung ?? '' }}</textarea>
                                    </div>


                                </div>
                                <div class="col-lg-4">
                                    <h2 class="h5">Anschrift</h2>
                                    <div class="form-group">
                                        @if ($location->adresse_id===NULL)
                                            <label for="adresse_id" class="sr-only">Adresse auswähen und zuordnen</label>
                                            <select name="adresse_id" id="adresse_id" class="custom-select">
                                                <option value="void">Bitte Adresse zuordnen</option>
                                                @foreach (App\Adresse::all() as $adresse)
                                                    <option value="{{ $adresse->id }}">{{ $adresse->ad_name_lang }}</option>
                                                @endforeach
                                            </select>
                                            <a href="{{ route('adresse.create') }}" class="btn btn-outline-primary btn-block">neue Adresse anlegen</a>
                                        @else
                                            <label for="adresse_id" class="sr-only">Die Adresse des Standortes festlegen</label>
                                            <select class="custom-select" aria-label="Default select example" name="adresse_id" id="adresse_id">
                                                @foreach (App\Adresse::all() as $addItem)
                                                    <option value="{{$addItem->id}}" @if ($addItem->id == $location->adresse_id)
                                                    selected
                                                        @endif>{{ $addItem->ad_anschrift_ort }},  {{ $addItem->ad_anschrift_strasse }} - {{ $addItem->ad_anschrift_hausnummer }}</option>
                                                @endforeach
                                            </select>

                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Kürzel: {{ $location->Adresse->ad_name_kurz }}</h5>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Postal:</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_name_lang }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Straße, Nr</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_strasse }}, {{ $location->Adresse->ad_anschrift_hausnummer }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Plz</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_plz }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Ort</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_ort }}</dd>
                                                    </dl>
                                                </div>
                                            </div>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="h5">Leitung</h2>
                                    <div class="form-group">
                                        @if ($location->profile_id === NULL)
                                            <label for="profile_id">Keine Mitarbeiter gefunden!</label>
                                            <input type="hidden" name="profile_id" id="profile_id">
                                            <a href="{{ route('profile.create') }}" class="btn btn-outline-primary btn-block">neuen Mitarbeiter anlegen</a>
                                        @else
                                            <label for="profile_id" class="sr-only">Leitung des Standortes hat</label>
                                            <select class="custom-select" aria-label="Default select example" name="profile_id" id="profile_id">
                                                @foreach (App\Profile::all() as $profileItem)
                                                    <option value="{{$profileItem->id}}" @if ($profileItem->id == $location->profile_id)
                                                    selected
                                                        @endif>{{ $profileItem->ma_vorname }} {{ $profileItem->ma_name }}</option>
                                                @endforeach
                                            </select>
                                            <?php $profile = App\Profile::find( $location->profile_id ); $user= App\User::find($profile->user_id);  ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Kontaktdaten</h5>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Name</dt>
                                                        <dd class="col-sm-9">{{ $profile->ma_vorname }} {{ $profile->ma_name }} </dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3"><span class="text-truncate">Telefon</span></dt>
                                                        <dd class="col-sm-9">{{ $profile->ma_telefon }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Mobil</dt>
                                                        <dd class="col-sm-9"><a href="tel:{{ $profile->ma_mobil }}">{{ $profile->ma_mobil }}</a></dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">E-Mail</dt>
                                                        <dd class="col-sm-9"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block"><i class="fas fa-save"></i> Stammdaten speichern</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="locGebauede" role="tabpanel" aria-labelledby="locGebauede-tab">
                        <div class="row">
                            <div class="col">
                                <form class="row gy-2 gx-3  my-3"
                                      action="{{ route('building.store') }}#locGebauede" method="post" name="frmAddNewBuilding" id="frmAddNewBuilding">
                                    @csrf
                                    <input type="hidden"
                                           name="standort_id"
                                           id="standort_id"
                                           value="{{ Str::uuid() }}"
                                    >
                                    <input type="hidden" name="location_id" id="location_id" value="{{ $location->id }}">
                                    <input type="hidden" name="frmOrigin" id="frmOriginAddNewBuilding" value="location">
                                    <div class="col-auto">
                                        <label class="sr-only" for=""></label>
                                        <input type="text" class="form-control" id="b_name_kurz" name="b_name_kurz" required placeholder="Gebäudename kurz" value="{{ old('b_name_kurz')??'' }}">
                                        @if ($errors->has('b_name_kurz'))
                                            <span class="text-danger small">{{ $errors->first('b_name_kurz') }}</span>
                                        @else
                                            <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <label class="sr-only" for="b_name_ort">Gebäudeort</label>
                                        <input type="text" class="form-control" id="b_name_ort" name="b_name_ort" placeholder="Gebäudeort" value="{{ old('b_name_ort')??'' }}">
                                        @if ($errors->has('b_name_ort'))
                                            <span class="text-danger small">{{ $errors->first('b_name_ort') }}</span>
                                        @else
                                            <span class="small text-primary">maximal 100 Zeichen</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <label for="building_type_id" class="sr-only">Gebäudetyp angeben</label>
                                            <select name="building_type_id" id="building_type_id" class="custom-select">
                                                @foreach (\App\BuildingTypes::all() as $roomType)
                                                    <option value="{{ $roomType->id }}" title="{{ $roomType->btbeschreibung  }}">{{ $roomType->btname  }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalAddBuildingType"><i class="fas fa-plus"></i></button>
                                        </div>
                                        <span class="small text-primary">Gebäudetyp</span>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Neues Gebäude anlegen</button>
                                    </div>
                                </form>
                                @if ($location->Building->count()>0)
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nummer / ID</th>
                                            <th>Ort</th>
                                            <th class="d-none d-md-table-cell">Typ</th>
                                            <th class="d-none d-md-table-cell text-center">Räume</th>
                                            <th class="d-none d-md-table-cell">WE</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ( $location->Building as $building)
                                            <tr>
                                                <td>
                                                    {{$building->b_name_kurz}}
                                                </td>
                                                <td>
                                                    {{$building->b_name_ort}}
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    {{ $building->BuildingType->btname }}
                                                </td>
                                                <td class="d-none d-md-table-cell text-center">
                                                    {{ $building->rooms()->count() }}
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    @if ($building->b_we_has === 1)
                                                        {{$building->b_we_name}}
                                                    @else
                                                        <span class="fas fa-times"></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('building.show',$building) }}" class="btn-outline-secondary btn btn-sm" title="Gebäudedaten ansehen"><i class="fas fa-chevron-right"></i></a>
                                                    @if ($building->rooms()->count()===0)
                                                        <button type="button" class="btn btn-outline-dark btn-sm btnDeleteBuildig" data-id="{{ $building->id }}" title="Gebäude löschen"><i class="far fa-trash-alt"></i></button>
                                                        <form action="{{ route('building.destroy',$building->id) }}" id="frmDeleteBuildig_{{ $building->id }}" target="_blank">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id" id="id_{{ $building->id }}" value="{{ $building->id }}">
                                                            <input type="hidden" name="frmOrigin" id="frmOrigin_{{ $building->id }}" value="locaion">
                                                            <input type="hidden" name="b_name_kurz" id="b_name_kurz{{ $building->b_name_kurz }}" value="{{ $building->r_name_kurz }}">
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--<div class="tab-pane fade" id="locEqipment" role="tabpanel" aria-labelledby="locEqipment-tab">
                        <div class="row">
                            <div class="col">
                                <h2 class="h6">Folgende Geräte sind dem Standort zugeteilt</h2>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('actionMenuItems')

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Drucke Übersicht</a>
            <a class="dropdown-item" href="#"><i class="far fa-file-pdf"></i> Standortbericht</a>

        </ul>
    </li>

@endsection()

@section('scripts')
    @if ($errors->has('btname'))
        <script>
            $('#modalAddBuildingType').modal('show');
        </script>
    @endif
    <script>
        $('.btnDeleteBuildig').click(function () {
            const buildingId = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('destroyBuildingAjax') }}",
                data: $('#frmDeleteBuildig_'+buildingId).serialize(),
                success: function (res) {
                    if(res) location.reload();

                }
            });
        });
    </script>
@endsection
