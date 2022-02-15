@extends('layout.layout-admin')

@section('pagetitle')
{{__('Kontakt')}} &triangleright; {{ __('Organisation') }}
@endsection

@section('mainSection')
    {{ __('Organisation') }}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('modals')
    <x-modals.form_modal method="DELETE"
                    modalRoute="{{ route('contact.destroy',$contact) }}"
                    modalId="modalDeleteContact"
                    modalType="danger"
                    modalSize="lg"
                    title="{{ __('Vorsicht') }}"
                    btnSubmit="{{ __('Kontakt löschen') }}"
    >
        <p class="lead">{{__('Das Löschen des Kontaktes kann nicht rückgängig gemacht werden. Abhängige Objekte könnten dadurch ihre Zuordnung verlieren.')}}</p>

    </x-modals.form_modal>
@endsection

@section('content')

    <div class="container">
        <div class="row mb-lg-4 md-sm-2">
            <div class="col">
                <h1 class="h3">{{__('Kontakt bearbeiten')}}</h1>
            </div>
        </div>
        <form action="{{ route('contact.update',$contact) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="id"
                   value="{{ $contact->id??(old('id')??'') }}"
            >
            <div class="row">
                <div class="col">
                    <x-selectfield id="firma_id" label="{{__('Arbeitet bei Firma')}}">
                        @foreach(App\Firma::all() as $company)
                            <option value="{{ $company->id }}"
                                    @if($company->id === $contact->firma_id) selected @endif >
                                {{ $company->fa_name }}
                            </option>
                        @endforeach
                    </x-selectfield>
                </div>
                <div class="col-md-6">
                    <x-textfield id="con_position" label="{{__('Position')}}" value="{{ $contact->con_position }}"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-rtextfield id="con_label" label="{{__('Kürzel')}}" value="{{ $contact->con_label }}"/>
                </div>
                <div class="col">
                    <x-selectfield id="anrede_id" label="{{ __('Anrede') }}">
                        @foreach(\App\Anrede::all() as $anrede)
                            <option value="{{ $anrede->id }}" @if($anrede->id === $contact->anrede_id) selected @endif>{{ $anrede->an_formal }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
                <div class="col-md-6">
                    <x-textfield id="con_vorname" label="{{__('Vorname')}}" value="{{ $contact->con_vorname }}" max="100"/>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <x-textfield id="con_name" label="{{__('Name')}}" required value="{{ $contact->con_name }}"/>
                </div>
                <div class="col-md-4">
                    <x-textfield id="con_name_2" label="{{__('2. Name')}}" value="{{ $contact->con_name_2 }}" max="100"/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-textfield id="con_email" label="{{__('E-Mail')}}" value="{{ $contact->con_email }}"/>
                    <x-textfield id="con_telefon" label="{{__('Telefon')}}" value="{{ $contact->con_telefon }}"/>
                    <x-textfield id="con_mobil" label="{{__('Mobil')}}" value="{{ $contact->con_mobil }}"/>
                </div>
                <div class="col-md-6">
                    <x-textfield id="con_fax" label="{{__('Fax')}}" value="{{ $contact->con_fax }}"/>
                    <x-textfield id="con_com_1" label="{{__('Com 1')}}" value="{{ $contact->con_com_1 }}"/>
                    <x-textfield id="con_com_2" label="{{__('Com 2')}}" value="{{ $contact->con_com_2 }}"/>
                </div>
            </div>
            <button class="btn btn-primary mt-2">
                {{__('Kontakt speichern ')}}<span class="fas fa-download ml-2"></span>
            </button>

            <button type="button"
                    class="btn btn-outline-danger mt-2 ml-2"
                    data-toggle="modal"
                    data-target="#modalDeleteContact"
            >
                {{__('Kontakt löschen ')}} <i class="fas fa-trash-alt ml-2"></i>
            </button>
        </form>
    </div>

@endsection

