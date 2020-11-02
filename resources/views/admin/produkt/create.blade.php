@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neu anlegen')}} &triangleright; {{__('Produkt')}} @ bitpack GmbH
@endsection

@section('mainSection')
{{__('Produkte')}}
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('breadcrumbs')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{__('Portal')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produkt.index') }}">{{__('Produkte')}}</a></li>
                @if ($pk)
                <li class="breadcrumb-item"><a href="/produkt/kategorie/{{ $pk }}">{{ App\ProduktKategorie::find($pk)->pk_name_kurz }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{__('Neu anlegen')}}</li>
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
                <h1 class="h4">{{__('Neues')}} @if ($pk) {{ App\ProduktKategorie::find($pk)->pk_name_kurz}} @endif {{__('Produkt anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('produkt.store') }}" method="post" class="needs-validation">
                    @csrf
                    <x-form_AddProdukt :pk="$pk" mkpk />
                    <button class="btn btn-primary btn-block">{{__('Produkt anlegen')}}</button>
{{--
<button @if (!config('app.makeobjekte') ) disabled @endif  class="btn btn-primary btn-block">Produkt anlegen</button>
--}}
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


