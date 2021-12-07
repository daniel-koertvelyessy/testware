@extends('layout.layout-login')

@section('pagetitle')
{{__('Firmierung')}} &triangleright; {{__('Installation')}} &triangleright; testWare
@endsection

@section('content')

    <form method="POST"
          action="{{ route('installer.setCompany') }}"
          id="frmSetCompanyData"
    >
        @csrf
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <a class="navbar-brand"
               href="{{ route('portal-main') }}"
            >{{ __('Installation') }}</a>
            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"
                 id="navbarSupportedContent"
            >
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('installer.server') }}"
                           tabindex="-1"
                           aria-disabled="false"
                        >{{ __('Server') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('installer.user') }}"
                           aria-disabled="false"
                        >{{ __('Benutzer') }} </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link disabled"
                           aria-disabled="true"
                           href="{{ route('installer.company') }}"
                        >{{ __('Firmierung') }}<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled"
                           href="{{ route('installer.location') }}"
                           tabindex="-1"
                           aria-disabled="true"
                        >{{ __('memStandort') }}</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <a class="btn btn-sm btn-outline-warning"
                       href="/"
                    >{{ __('Abbruch') }}</a>

                    <a class="btn btn-sm btn-outline-primary ml-2"
                       href="{{ route('installer.user') }}"
                    >{{ __('zurück') }}</a>

                    <button class="btn btn-sm btn-primary"
                    >{{ __('weiter') }}</button>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-6">
                    <h2 class="h4">{{__('Firma')}}</h2>
                    <input type="hidden"
                           name="company_id"
                           id="company_id"
                           value="{{ $company->id??'' }}"
                    >
                    @isset($company->adresse_id)
                        <input type="hidden"
                               name="adresse_id"
                               id="company_adresse_id"
                               value="{{ $company->adresse_id }}"
                        >
                    @else
                        <input type="hidden"
                               name="adresse_id"
                               id="company_adresse_id"
                               value="{{ $address->id??'' }}"
                        >
                    @endif
                    <x-textfield id="fa_label"
                                 label="{{ __('Bezeichner') }}"
                                 max="20"
                                 required
                                 class="col-md-6 checkLabel"
                                 :placeholer="__('fa_')"
                                 value="{{ $company->fa_label ?? '' }}"
                    />
                    <x-textfield id="fa_name"
                                 label="{{ __('Name') }}"
                                 :placeholer="__('Mein Firmenname') "
                                 value="{{ $company->fa_name ?? '' }}"
                    />
                    <x-textfield id="fa_description"
                                 label="{{ __('Beschreibung') }}"
                                 :placeholer=" __('Kurze Beschreibung der Firma') "
                                 value="{{ $company->fa_description ?? '' }}"
                    />
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="fa_kreditor_nr"
                                         label="{{ __('Kreditor Nr') }}"
                                         value="{{ $company->fa_kreditor_nr ?? '' }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="fa_debitor_nr"
                                         label="{{ __('Debitor Nr') }}"
                                         value="{{ $company->fa_debitor_nr ?? '' }}"
                            />
                        </div>
                    </div>
                    <x-textfield id="fa_vat"
                                 label="{{ __('UST-ID') }}"
                                 value="{{ $company->fa_vat ?? '' }}"
                    />
                </div>
                <div class="col-md-6">
                    <h2 class="h4">{{__('Adresse')}}</h2>
                    <div class="row">
                        <input type="hidden"
                               name="address_id"
                               id="new_address_id"
                               value="{{ $address->id??'' }}"
                        >
                        <div class="col-md-6">
                            <x-textfield id="ad_labels"
                                         name="ad_label"
                                         label="{{ __('Kürzel') }}"
                                         :placeholder="__('ad_')"
                                         class="checkLabel"
                                         max="20"
                                         required
                                         value="{{ $address->ad_label ?? '' }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="address_type_id"
                                           label="{{ __('Adresstyp') }}"
                            >
                                @foreach(App\AddressType::all() as $addressType)
                                    <option value="{{ $addressType->id }}"
                                            @if(isset($address->address_type_id) && $address->address_type_id == $addressType->id) selected @endif >{{ $addressType->adt_name }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <x-textfield id="ad_name"
                                 label="{{ __('Adresse Name') }}"
                                 value="{{ $address->ad_name ?? '' }}"
                    />
                    <div class="row">
                        <div class="col-md-8">
                            <x-textfield id="ad_anschrift_strasse"
                                         label="{{ __('Straße') }}"
                                         required
                                         max="100"
                                         class="required"
                                         value="{{ $address->ad_anschrift_strasse ?? '' }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ad_anschrift_hausnummer"
                                         label="{{ __('Nr') }}"
                                         value="{{ $address->ad_anschrift_hausnummer ?? '' }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <x-textfield id="ad_anschrift_ort"
                                         label="{{ __('Ort') }}"
                                         value="{{ $address->ad_anschrift_ort ?? '' }}"
                                         required
                                         max="100"
                                         class="required"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ad_anschrift_plz"
                                         label="{{ __('PLZ') }}"
                                         value="{{ $address->ad_anschrift_plz ?? '' }}"
                                         required
                                         max="100"
                                         class="required"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="land_id"
                                           label="{{ __('Land') }}"
                            >
                                @foreach(\App\Land::all() as $land)
                                    <option value="{{ $land->id }}">
                                        {{ $land->land_lang }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>

                    <x-textfield id="ad_name_firma"
                                 label="{{ __('Firma Name') }}"
                                 value="{{ $address->ad_name_firma ?? '' }}"
                    />

                </div>
            </div>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger fixed-bottom alert-dismissible fade show">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endsection

@section('scripts')

    <script>
        function checkForm() {
            event.preventDefault();
        }


        $('#fa_name').change(function () {
            $('#ad_name_firma').val($(this).val());
        })
    </script>

@endsection
