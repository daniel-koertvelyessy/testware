@extends('layout.layout-admin')

@section('pagetitle')
{{__('Adressen')}} &triangleright; {{ __('Organisation') }}
@endsection

@section('mainSection')
    {{ __('Organisation') }}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('modals')
    <x-modals.form_modal method="DELETE"
                    modalRoute="{{ route('adresse.destroy',$adresse) }}"
                    modalId="modalDeleteProfile"
                    modalType="danger"
                    title="{{ __('Vorsicht') }}"
                    btnSubmit="{{ __('Adresse löschen') }}"
    >
        <p class="lead">{{__('Das Löschen einer Adresse kann nicht rückgängig gemacht werden. Betriebe und Firmen könnten dadurch ihre Zuordnung verlieren.')}}</p>
        <p>{{ __('Betroffene Betriebe') }}</p>
        <ul class="list-group">
            @forelse(App\Location::where('adresse_id',$adresse->id)->get() as $location)
            <li class="list-group-item">{{ $location->l_name }}</li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Kein Standort mit der Adresse gefunden!') }}</li>
            @endforelse
        </ul>

        <p class="mt-4">{{ __('Betroffene Firmen') }}</p>
        <ul class="list-group">
            @forelse(App\Firma::where('adresse_id',$adresse->id)->get() as $company)
                <li class="list-group-item">{{ $company->fa_name }}</li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Keine Firma mit der Adresse gefunden!') }}</li>
            @endforelse
        </ul>


    </x-modals.form_modal>
@endsection

@section('content')

    <div class="container">
        <div class="row mb-lg-4 md-sm-2">
            <div class="col">
                <h1 class="h3">{{__('Adresse bearbeiten')}}</h1>
            </div>
        </div>
        <form action="{{ route('adresse.update',['adresse'=>$adresse]) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="id"
                   value="{{ $adresse->id??(old('id')??'') }}"
            >
            <div class="row">
                <div class="col-md-4">
                    <x-rtextfield name="ad_label" class="checkLabel" id="label" label="{{__('Kürzel')}}" value="{{ $adresse->ad_label??(old('ad_label')??'') }}"/>
                </div>
                <div class="col-md-4">
                    <x-textfield id="ad_name" label="{{__('Bezeichner')}}" value="{{ $adresse->ad_name??(old('ad_name')??'') }}"/>
                </div>
                <div class="col-md-4">
                    <x-selectfield id="address_type_id" label="{{__('Adress-Typ')}}">
                        @foreach(App\AddressType::all() as $adresseType)
                            <option value="{{ $adresseType->id }}"
                                    @if(isset($adresse) && $adresseType->id === $adresse->address_type_id) selected @endif >
                                {{ $adresseType->adt_name }}
                            </option>
                        @endforeach
                    </x-selectfield>
                </div>
            </div>
            <div class="row">
                <section class="col-md-8">
                    <h3 class="h5">{{__('Firmierung')}}</h3>
                    <x-textfield id="ad_name_firma" label="{{__('Firma')}}" value="{!! $adresse->ad_name_firma !!}"/>
                    <div class="row">
                        <div class="col-md-8">
                            <x-rtextfield max="100" id="ad_anschrift_strasse" label="{{__('Straße')}}" value="{!! $adresse->ad_anschrift_strasse !!}"/>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ad_anschrift_hausnummer" label="{{__('Nr')}}" value="{!! $adresse->ad_anschrift_hausnummer !!}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <x-rtextfield max="100" id="ad_anschrift_ort" label="{{__('Ort')}}" value="{!! $adresse->ad_anschrift_ort !!}"/>
                        </div>
                        <div class="col-md-4">
                            <x-rtextfield max="100" id="ad_anschrift_plz" label="{{__('PLZ')}}" value="{!! $adresse->ad_anschrift_plz !!}"/>
                        </div>
                    </div>
                    <x-selectfield id="land_id" label="{{__('Land')}}">
                        @foreach (App\Land::all() as $land)
                            <option value="{{ $land->id }}"
                                    @if($land->id === $adresse->land_id) selected @endif >
                                {{ $land->land_lang }}
                            </option>
                        @endforeach
                    </x-selectfield>

                </section>
                <section class="col-md-4">
                    <h3 class="h5">{{__('Optional Angaben')}}</h3>
                    <x-textfield id="ad_name_firma_2" label="{{__('Firma 2')}}" value="{!! $adresse->ad_name_firma_2 !!}"/>
                    <x-textfield id="ad_name_firma_co" label="{{__('Firma c/o')}}" value="{!! $adresse->ad_name_firma_co !!}"/>
                    <x-textfield id="ad_name_firma_abladestelle" label="{{__('Abladestelle')}}" value="{!! $adresse->ad_name_firma_abladestelle !!}"/>
                    <x-textfield id="ad_name_firma_wareneingang" label="{{__('Wareneingang')}}" value="{!! $adresse->ad_name_firma_wareneingang !!}"/>
                    <x-textfield id="ad_anschrift_eingang" label="{{__('Eingang')}}" value="{!! $adresse->ad_anschrift_eingang !!}"/>
                </section>
            </div>

            <button class="btn btn-primary mt-2">
                {{__('Adresse speichern ')}}<span class="fas fa-download ml-2"></span>
            </button>

            <button type="button"
                    class="btn btn-outline-danger mt-2"
                    data-toggle="modal"
                    data-target="#modalDeleteProfile"
            >
                {{__('Adresse löschen ')}} <i class="fas fa-trash-alt ml-2"></i>
            </button>
        </form>
    </div>

@endsection

