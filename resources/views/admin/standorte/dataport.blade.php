@extends('layout.layout-admin')

@section('pagetitle')
{{__('Export Import')}} &triangleright; {{__('Standortverwaltung')}} @ bitpack.io GmbH
@endsection

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{__('Export / Import')}}</h1>
                <p>{{__('Sie können in diesem Modul den Export und Import von ihren Standort-Objekten vornehmen. Dies ist keine Backup-Funktion, da die Datensätze neu angelegt werden!')}}</p>
                <p class="lead text-warning">{{__('Beachten Sie, dass der Export und vor allem der Import auf eigene Gefahr geschieht. Der Import von fehlerhaften Dateien kann Ihre Datenbank-Struktur im schlimmsten Fall zerstören.')}}</p>
                <p>{{__('Wenden Sie sich an Ihren Ansprechpartner, wenn Sie bei diesem Vorgang Unterstützung benötigen. Wir stehen gerne für Sie mit Rat und Tat zur Seite.')}}</p>
                {{ env('app.maxobjekte') }}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 p-3">
                <div class="card p-3">
                    <h2 class="h4">{{__('Objekte')}}</h2>

                    <form action="{{ route('exportLocationJSON') }}" method="get" id="frmDataPort">
                        <label for="objektSource">Objektart wählen</label>
                        <select name="objektSource"
                                id="objektSource"
                                class="custom-select"
                        >
                            <option value="1"
                                    data-export="{{ route('exportLocationJSON') }}"
                                    data-import="{{ route('importLocationJSON') }}"
                            >
                                {{__('Standorte')}}
                            </option>
                            <option value="2"
                                    data-export="{{ route('exportBuildingJSON') }}"
                                    data-import="{{ route('importBuildingJSON') }}"
                            >
                                {{__('Gebäude')}}
                            </option>
                            <option value="3"
                                    data-export="{{ route('exportRoomJSON') }}"
                                    data-import="{{ route('importRoomJSON') }}"
                            >
                                {{__('Räume')}}
                            </option>
                            <option value="4"
                                    data-export="{{ route('exportStellplatzJSON') }}"
                                    data-import="{{ route('importStellplatzJSON') }}"
                            >
                                {{__('Stellplätze')}}
                            </option>
                        </select>
                        @csrf
                    </form>
                    <div class="dropdown-divider my-3"></div>
                    <form action="" id="frmImportData"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="custom-file mb-3">
                            <input type="file"
                                   class="custom-file-input"
                                   id="importDataPortFile" name="importDataPortFile"
                                   data-browse="Datei"
                                   accept=".json,.xml"
                                   required
                            >
                            <label class="custom-file-label" for="customFile">{{__('JSON Datei wählen max. 2MB')}}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="ignoreDoubleData" name="handleImportData" value="ignore" class="custom-control-input" checked>
                            <label class="custom-control-label" for="ignoreDoubleData">{{__('Identische Daten ignorieren')}}</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="appendDoubleData" name="handleImportData" value="append" class="custom-control-input">
                            <label class="custom-control-label" for="appendDoubleData">{{__('Identische Daten mit dem Vermerk _I1 als neue Datensätze anhängen')}}</label>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-block mt-2 d-flex justify-content-between align-items-center importObjectData">
                            {{__('Objekte')}} {{__('importieren')}} <i class="fas fa-file-import"></i>
                        </button>
                    </form>
                    <div class="dropdown-divider my-3"></div>
                    <button type="button" class="btn btn-outline-primary btn-block d-flex justify-content-between align-items-center exportObjectData">
                        {{__('Objekte')}} {{__('exportieren')}} <i class="fas fa-file-export"></i>
                    </button>
                </div>
                @if (session()->has('status'))
                    {!! session()->get('status') !!}
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>

        $('.exportObjectData').click(function () {

            $('#frmDataPort').attr('action',$('#objektSource :selected').data('export')).submit();
        });

        $('.importObjectData').click(function () {
            $('#frmImportData').attr('action',$('#objektSource :selected').data('import')).submit();
        });

    </script>

@endsection
