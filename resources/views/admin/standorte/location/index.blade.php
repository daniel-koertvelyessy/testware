@extends('layout.layout-admin')

@section('pagetitle')
{{__('Standortverwaltung')}}
@endsection

@section('mainSection')
{{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStandort')
@stop

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{__('Standorte')}}
            </li>
        </ol>
    </nav>

@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Standorte')}}</h1>
            </div>
        </div>
        @if (isset($locationList))

            <div class="row">
                <div class="col">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">{{__('Standort')}}</th>
                            <th>{{__('Bezeichnung')}}</th>
                            <th class="d-none d-md-table-cell">{{__('Gebäude')}}</th>
                            <th class="d-none d-md-table-cell">{{__('Räume')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($locationList as $location)
                            <tr>
                                <td class="d-none d-md-table-cell">
                                    <a href="/location/{{$location->location->id}}">{{ $location->location->l_name_kurz  }}</a>
                                </td>
                                <td>{{ $location->l_name_lang }}</td>
                                <td>{{ $location->b_name_kurz }}</td>
                                <td class="d-none d-md-table-cell">{{ $location->BuildingType->btname }}</td>
                                <td>
                                    <a href="{{$location->path()}}">
                                        <i class="fas fa-chalkboard"></i> <span class="d-none d-md-table-cell">{{__('Übersicht')}}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $locationList->onEachSide(2)->links() !!}
                    </div>
                </div>

                @else

                    @if  (App\Location::all()->count() >0)
                        <nav class="d-flex justify-content-end align-items-center mb-2">

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary btnShowDataStyle"
                                    data-targetid="#locationListField"
                                    data-src="{{ route('getLocationListeAsTable') }}"
                            >
                                <i class="fas fa-list"></i>
                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary btnShowDataStyle"
                                    data-targetid="#locationListField"
                                    data-src="{{ route('getLocationListeAsKachel') }}"
                            >
                                <i class="fas fa-th"></i>
                            </button>
                        </nav>
                        <div class="row"
                             id="locationListField"
                        >
                            @foreach (App\Location::all() as $location)
                                <div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 "
                                     id="loc_id_{{$location->id}}"
                                >
                                    <div class="card"
                                         style="height:20em;"
                                    >
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $location->l_name_kurz }}</h5>
                                            <h6 class="card-subtitletext-muted">{{ $location->l_name_lang }}</h6>
                                            <p class="card-text mt-1 mb-0"><small><strong>{{__('Gebäude')}}:</strong> {{ $location->Building->count() }}</small></p>
                                            <p class="card-text mt-1 mb-0"><small><strong>{{__('Beschreibung')}}:</strong></small></p>
                                            <p class="mt-0"
                                               style="height:6em;overflow-y: scroll"
                                            >{{ $location->l_beschreibung }}</p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center">
                                            <a href="{{$location->path()}}"
                                               class="btn btn-link btn-sm mr-auto"
                                            ><i class="fas fa-chalkboard"></i> Übersicht
                                            </a>
                                            @if ($location->Building->count()===0)
                                                <button type="button"
                                                        class="btn btn-link btn-sm btnDeleteLocation"
                                                        data-id="{{ $location->id }}"
                                                        title="Standort {{ $location->l_name_kurz }} löschen"
                                                ><i class="far fa-trash-alt"></i></button>
                                                <form action="{{ route('location.destroy',$location->id) }}"
                                                      id="frmDeleteLocation_{{ $location->id }}"
                                                      target="_blank"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_{{ $location->id }}"
                                                           value="{{ $location->id }}"
                                                    >
                                                    <input type="hidden"
                                                           name="frmOrigin"
                                                           id="frmOrigin_{{ $location->id }}"
                                                           value="building"
                                                    >
                                                    <input type="hidden"
                                                           name="l_name_kurz"
                                                           id="l_name_kurz_{{ $location->id }}"
                                                           value="{{ $location->l_name_kurz }}"
                                                    >
                                                </form>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else

                        <a href="{{ route('location.create') }}" class="btn-outline-primary btn btn-lg">Neuen Standort erstellen</a>

                    @endif

                @endif
            </div>

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
                        data: $('#frmDeleteLocation_' + rommId).serialize(),
                        success: function (res) {
                            if (res) location.reload();

                        }
                    });
                });
            </script>
@endsection
