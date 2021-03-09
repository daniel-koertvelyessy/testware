@extends('layout.layout-admin')

@section('pagetitle')
{{ __('Kontakt anlegen') }} &triangleright; {{ __('Organisation') }}
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
                <h1 class="h3">{{ __('Kontakt anlegen') }}</h1>
            </div>
        </div>
        <div class="row mt-md-4">
            <div class="col">
                <form action="{{ route('contact.store') }}"
                      method="post"
                >
                    @csrf
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="firma_id"
                                           label="{{__('Arbeitet bei Firma')}}"
                            >
                                @foreach(App\Firma::all() as $company)
                                    <option value="{{ $company->id }}" {{ $company_id==$company->id ? ' selected ' : '' }}>
                                        {{ $company->fa_name }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="con_position"
                                         label="{{__('Position')}}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <x-rtextfield id="con_label"
                                          label="{{__('Kürzel')}}"
                            />
                        </div>
                        <div class="col">
                            <x-selectfield id="anrede_id"
                                           label="{{ __('Anrede') }}"
                            >
                                @foreach(\App\Anrede::all() as $anrede)
                                    <option value="{{ $anrede->id }}">{{ $anrede->an_formal }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="con_vorname"
                                         label="{{__('Vorname')}}"
                                         max="100"
                            />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textfield id="con_name"
                                         label="{{__('Name')}}"
                                         required
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="con_name_2"
                                         label="{{__('2. Name')}}"
                                         max="100"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="con_email"
                                         label="{{__('E-Mail')}}"
                            />
                            <x-textfield id="con_telefon"
                                         label="{{__('Telefon')}}"
                            />
                            <x-textfield id="con_mobil"
                                         label="{{__('Mobil')}}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="con_fax"
                                         label="{{__('Fax')}}"
                            />
                            <x-textfield id="con_com_1"
                                         label="{{__('Com 1')}}"
                            />
                            <x-textfield id="con_com_2"
                                         label="{{__('Com 2')}}"
                            />
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2">
                        {{__('Kontakt speichern ')}}<span class="fas fa-download ml-2"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
