@extends('layout.layout-admin')

@section('pagetitle')
    Neues Gebäude anlegen  &triangleright;  Gebäudeverwaltung @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection


@section('content')
    {{-- `user_id``adress_id``l_beschreibung``l_name_lang``l_name_kurz``l_benutzt`--}}
    <div class="container mt-2">
        <h1 class="h3">Neues Gebäude anlegen</h1>
        <form action="{{ route('building.store') }}" method="post" class=" needs-validation">
            @csrf
            <input type="hidden"
                   name="standort_id"
                   id="standort_id"
                   value="{{ Str::uuid() }}"
            >
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="h5">Standort</h2>
                    <div class="form-group">
                        <label for="location_id">Das Gebäude befindet sich im Standort</label>
                        <select name="location_id" id="location_id" class="custom-select">
                            @foreach (App\Location::all() as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->l_name_kurz }}</option>
                            @endforeach
                        </select>
                    </div>
                    <h2 class="h5">Bezeichner</h2>
                    <div class="form-group">
                        <label for="b_name_kurz">Kurzbezeichnung</label>
                        <input type="text" name="b_name_kurz" id="b_name_kurz" class="form-control {{ $errors->has('b_name_kurz') ? ' is-invalid ': '' }}" maxlength="10" value="{{ old('b_name_kurz')??'' }}">
                        @if ($errors->has('b_name_kurz'))
                            <span class="text-danger small">{{ $errors->first('b_name_kurz') }}</span>
                        @else
                            <span class="small text-primary">max 20 Zeichen, <b>erforderliches Feld</b></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="b_name_ort">Ort</label>
                        <input type="text" name="b_name_ort" id="b_name_ort" class="form-control {{ $errors->has('b_name_ort') ? ' is-invalid ': '' }}" maxlength="100" value="{{ old('b_name_ort')??'' }}">
                        @if ($errors->has('b_name_ort'))
                            <span class="text-danger small">{{ $errors->first('b_name_ort') }}</span>
                        @else
                            <span class="small text-primary">max 100 Zeichen</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="b_name_lang">Bezeichnung</label>
                        <input type="text" name="b_name_lang" id="b_name_lang" class="form-control {{ $errors->has('b_name_lang') ? ' is-invalid ': '' }}" maxlength="100" value="{{ old('b_name_lang')??'' }}">
                        @if ($errors->has('b_name_lang'))
                            <span class="text-danger small">{{ $errors->first('b_name_lang') }}</span>
                        @else
                            <span class="small text-primary">max 100 Zeichen</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="b_name_text">Beschreibung</label>
                        <textarea name="b_name_text" id="b_name_text" class="form-control {{ $errors->has('b_name_text') ? ' is-invalid ': '' }}" rows="3">{{ old('b_name_text')??'' }}</textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="h5">Eigenschaften</h2>
                    <div class="form-group">
                        <label for="building_type_id">Gebäudetyp festlegen </label> <a data-toggle="collapse" href="#addNewGebtype" role="button" aria-expanded="false" aria-controls="addNewGebtype">neu anlegen</a>
                        <div class="collapse" id="addNewGebtype">
                            <div class=" align-items-center">
                                <div class="input-group">
                                    <label for="newBtname" class="sr-only">Name für neuen Gebäudetyp </label>
                                    <input type="text" name="newBtname" id="newBtname" class="form-control">
                                    <button type="button" class="btn btn-sm btn-secondary" id="btnaddNewGebtype">anlegen</button>
                                </div>
                            </div>
                        </div>

                        <select name="building_type_id" id="building_type_id" class="custom-select">
                            @foreach (App\BuildingTypes::all() as $bty)
                                <option value="{{ $bty->id }}">{{ $bty->btname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h2 class="h5">Wareneingang</h2>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="b_we_has" name="b_we_has" {{ (old('b_we_has')==='1')?' checked ': '' }}>
                            <label class="form-check-label" for="b_we_has">
                                Wareneingang vorhanden
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="b_we_name">WE Bezeichnung (max 100 Zeichen)</label>
                        <input type="text" name="b_we_name" id="b_we_name" class="form-control" {{ (old('b_we_has')==='1')?'': ' disabled ' }} maxlength="100" value="{{ old('b_we_name')??'' }}">
                        @if ($errors->has('b_we_name'))
                            <span class="text-danger small">{{ $errors->first('b_we_name') }}</span>
                        @else
                            <span class="small text-primary">max 100 Zeichen</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-block">Gebäude anlegen</button>
        </form>
    </div>
@endsection

@section('actionMenuItems')

@endsection()

@section('scripts')
    <script>
        $('#b_we_has').click(function (){
            let nd = $('#b_we_name');
            ($(this).prop('checked'))? nd.attr('disabled',false) : nd.attr('disabled',true)
        });
    </script>


@endsection
