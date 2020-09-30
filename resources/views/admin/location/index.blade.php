@extends('layout.layout-admin')

@section('pagetitle')
    Standortverwaltung | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@stop

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Standorte</li>
        </ol>
    </nav>

@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">Übersicht Standorte</h1>
            </div>
        </div>

{{--        <script src="/plugins/typehead/dist/jquery.typeahead.min.js"></script>

        <form id="form-user_v1" name="form-user_v1">
            <div class="typeahead__container">
                <div class="typeahead__field">
                    <div class="typeahead__query">
                        <input class="js-typeahead-user_v1" name="user_v1[query]" placeholder="Search" autocomplete="off">
                    </div>
                    <div class="typeahead__button">
                        <button type="submit">
                            <i class="typeahead__search-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <script type="text/javascript" src="{{ asset('js/autoload_typeahead.js') }}"></script>--}}


        @if  (App\Location::all()->count() >0)
            <div class="row" id="locationListField">
                @foreach (App\Location::all() as $location)
                    <div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="loc_id_{{$location->id}}">
                        <div class="card" style="height:20em;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $location->l_name_kurz }}</h5>
                                <h6 class="card-subtitletext-muted">{{ $location->l_name_lang }}</h6>
                                <p class="card-text mt-1 mb-0"><small><strong>Gebäude:</strong> {{ $location->buildings()->count() }}</small></p>
                                <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                <p class="mt-0" style="height:6em;overflow-y: scroll">{{ $location->l_beschreibung }}</p>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <a href="{{$location->path()}}" class="btn btn-link btn-sm mr-auto"><i class="fas fa-chalkboard"></i> Übersicht</a>
                                @if ($location->buildings()->count()===0)
                                        <button type="button" class="btn btn-link btn-sm btnDeleteLocation" data-id="{{ $location->id }}" title="Standort {{ $location->l_name_kurz }} löschen"><i class="far fa-trash-alt"></i></button>
                                        <form action="{{ route('location.destroy',$location->id) }}" id="frmDeleteLocation_{{ $location->id }}" target="_blank">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" id="id_{{ $location->id }}" value="{{ $location->id }}">
                                            <input type="hidden" name="frmOrigin" id="frmOrigin_{{ $location->id }}" value="building">
                                            <input type="hidden" name="l_name_kurz" id="l_name_kurz_{{ $location->id }}" value="{{ $location->l_name_kurz }}">
                                        </form>
                                    @endif
                                {!! App\Location::checkStatus() !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-6">
                    <div class="card" >
                        <form action="/location" method="post" class=" needs-validation">
                            @csrf
                            <div class="card-body">
                                <h5 class="card-title">Schnellstart</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Erstellen Sie den ersten Standort</h6>
                                <div class="form-group">
                                    <label for="l_name_kurz">Kurzbezeichnung (erforderlich, max 10 Zeichen)</label>
                                    <input type="text" name="l_name_kurz" id="l_name_kurz" class="form-control @error('l_name_kurz') ' is-invalid ' @enderror()" value="{{ old('l_name_kurz','') }}">
                                    @error('l_name_kurz')
                                    <span class="text-danger small">Die Kurzbezeichung ist zwingend notwendig!</span>
                                    @enderror()
                                </div>
                                <div class="form-group">
                                    <label for="l_name_lang">Bezeichnung (max 100 Zeichen)</label>
                                    <input type="text" name="l_name_lang" id="l_name_lang" class="form-control" maxlength="100"  value="{{ old('l_name_lang','') }}">
                                </div>
                                <p class="card-text">Sie können später weitere Informationen anlegen</p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-block"><i class="far fa-save"></i> Standort anlegen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('autocomplete')



@endsection


@section('actionMenuItems')

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item" href="makePDF/standortliste/Standortliste" target="_blank"><i class="far fa-file-pdf"></i> Standortbericht</a>
        </ul>
    </li>


@endsection

@section('scripts')
    <script>
        $('.btnDeleteLocation').click(function () {
            const rommId = $(this).data('id');
            console.log(rommId);
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('location.destroyLocationAjax') }}",
                data: $('#frmDeleteLocation_'+rommId).serialize(),
                success: function (res) {
                    if(res) location.reload();

                }
            });
        });
    </script>
@endsection
