@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
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
            @if(count($locationList)>=10)
                <x-locations_table :locations="$locationList"/>
            @else
                @foreach($locationList as $location)
                    <x-object_tile :object="$location"/>
                @endforeach
            @endif
        </div>


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
