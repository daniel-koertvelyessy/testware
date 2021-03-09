@extends('layout.layout-admin')

@section('pagetitle')
{{__('Firmen')}} &triangleright; {{__('Organnisation')}} @ bitpack GmbH
@endsection

@section('mainSection')
{{__('Organisation')}}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{__('Firma anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('firma.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <x-rtextfield id="fa_label" label="Kürzel"/>
                        </div>
                        <div class="col">
                            <x-textfield id="fa_vat" label="U-St-ID" max="30"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textfield id="fa_name" label="Name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="adresse_id" label="Adresse">
                                @foreach(App\Adresse::all() as $adresse)
                                    <option value="{{ $adresse->id }}">
                                        {{ $adresse->postalAddress() }}
                                    </option>
                                @endforeach
                                    <option value="new">{{ __('neu anlegen') }}</option>
                            </x-selectfield>
                        </div>
                    </div>
                    <div id="createNewAddress" class="d-none">
                        <x-frm_AddAdresse />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="fa_kreditor_nr" label="Liefranten Nummer" />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="fa_debitor_nr" label="Kundennummer bei Firma" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="fa_description" label="Becshreibung" />
                        </div>
                    </div>

                    <x-btnMain>{{ __('Firma speichern ')}}<span class="fas fa-download ml-2"></span></x-btnMain>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $('#adresse_id').change(function () {
            const node = $('#createNewAddress');
           if ($('#adresse_id :selected').val() === 'new'){
               node.removeClass('d-none').addClass('d-block');
           } else {
               node.removeClass('d-block').addClass('d-none');
           }
        });

        $(document).on('blur','#fa_kreditor_nr',function () {
            const kreditorNoNode = $('#fa_kreditor_nr');

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('firma.checkCompanyKreditor') }}",
                data: {kreditor: kreditorNoNode.val()},
                success: function (res) {
                    if (kreditorNoNode.val() ==='') {
                        kreditorNoNode.removeClass('is-valid').removeClass('is-invalid')
                    } else {
                        (res === true) ? kreditorNoNode.removeClass('is-valid').addClass('in-valid') : kreditorNoNode.removeClass('is-invalid').addClass('is-valid');
                    }

                }
            });
        });
        $(document).on('blur','#fa_label',function () {
            const labelNode =  $('#fa_label');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('firma.checkCompanyLabel') }}",
                data: {label:labelNode.val()},
                success: function(res) {
                    if (labelNode.val() ==='') {
                        labelNode.removeClass('is-valid').removeClass('is-invalid');
                    } else {
                        (res === true) ? labelNode.removeClass('is-valid').addClass('in-valid') : labelNode.removeClass('is-invalid').addClass('is-valid');
                    }

                }
            });
        });
    </script>

@endsection
