@extends('layout.layout-login')

@section('pagetitle')
{{__('Initialdaten')}} &triangleright; {{__('Installation')}} &triangleright; testWare
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand"
           href="#"
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
                <li class="nav-item active">
                    <a class="nav-link"
                       href="{{ route('installer.company') }}"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('Firmierung') }} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="#"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('Benutzer') }}<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="#"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('System') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="#"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('Initialdaten') }}</a>
                </li>
            </ul>
            <div class="navbar-nav">
                <a class="btn btn-sm btn-outline-warning"
                   href="/"
                >{{ __('Abbruch') }}</a>
            </div>
            <a class="btn btn-sm btn-primary ml-4"
               onclick="event.preventDefault(); document.getElementById('frmSetSeederData').submit();"
               href="#"
            >{{ __('weiter') }}</a>
        </div>
    </nav>

    <div class="container">
        <form method="POST"
              action="{{ route('installer.user') }}"
              id="frmSetSeederData"
        >
            @method('get')
            @csrf
            <div class="row mt-3">
                <div class="col-md-6">
                    <h2 class="h4">{{__('Firma')}}</h2>
                    <input type="hidden"
                           name="company_id"
                           id="company_id"
                           value="{{ $company->id??'' }}"
                    >
                    <x-textfield id="fa_label"
                                 label="{{ __('Bezeichner') }}"
                                 max="20"
                                 required
                                 class="col-md-6"
                                 value="{{ $company->fa_label ?? '' }}"
                    />
                    <x-textfield id="fa_name"
                                 label="{{ __('Name') }}"
                                 value="{{ $company->fa_name ?? '' }}"
                    />
                    <x-textfield id="fa_description"
                                 label="{{ __('Beschreibung') }}"
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
                               id="address_id"
                               value="{{ $address->id??'' }}"
                        >
                        <div class="col-md-6">
                            <x-textfield id="ad_labels"
                                         name="ad_label"
                                         label="{{ __('Kürzel') }}"
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
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ad_anschrift_plz"
                                         label="{{ __('PLZ') }}"
                                         value="{{ $address->ad_anschrift_plz ?? '' }}"
                                         required
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
        </form>
    </div>
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

    </script>

@endsection
