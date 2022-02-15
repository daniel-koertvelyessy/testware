@extends('layout.layout-admin')

@section('pagetitle')
{{__('Firma')}} {{ $firma->fa_label }} &triangleright; {{ __('Organisation') }}
@endsection

@section('mainSection')
    {{ __('Firma bearbeiten') }}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('modals')
    <x-modals.form_modal method="DELETE"
                         modalRoute="{{ route('firma.destroy',$firma) }}"
                         modalId="modalDeleteCompany"
                         modalType="danger"
                         modalSize="lg"
                         title="{{ __('Vorsicht') }}"
                         btnSubmit="{{ __('Firma löschen') }}"
    >
        <p class="lead">{{__('Das Löschen der Firma kann nicht rückgängig gemacht werden. Abhängige Objekte könnten dadurch ihre Zuordnung verlieren.')}}</p>

        <p class="mt-3">{{ __('Betroffene Kontakte') }}</p>
        <ul class="list-group list-group-horizontal">
            @forelse(App\Contact::where('firma_id',$firma->id)->get() as $contact)
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    {{ $contact->fullName() }}
                </li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Keine Kontakte der Firma gefunden!') }}</li>
            @endforelse
        </ul>

        <p class="mt-3">{{ __('Betroffene Produkte') }}</p>
        <ul class="list-group">
            @forelse(App\FirmaProdukt::where('firma_id',$firma->id)->get() as $product)
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    {{ $product->Produkt->prod_label }}
                    <span>verknüpfte Geräte <span
                                class="badge badge-danger">{{ $product->Produkt->Equipment->count() }}</span> </span>
                </li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Keine Produkte mit der Firma gefunden!') }}</li>
            @endforelse
        </ul>

        <p class="mt-3">{{ __('Betroffene befähigte Personen') }}</p>
        <ul class="list-group list-group-horizontal">
            @forelse(App\ProductQualifiedUser::where('product_qualified_firma',$firma->id)->take(5)->get() as $user)
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    {{ $user->user->name }}
                </li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Keine befähigte Person gefunden!') }}</li>
            @endforelse
        </ul>

        <p class="mt-3">{{ __('Betroffene eingewiesne Personen') }}</p>
        <ul class="list-group list-group-horizontal">
            @forelse(App\ProductInstructedUser::where('product_instruction_instructor_firma_id',$firma->id)->take(5)->get() as $user)
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    {{ $user->user->name }}
                </li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Keine eingewiesne Person gefunden!') }}</li>
            @endforelse
        </ul>

        <p class="mt-3">{{ __('Betroffene Kontrollvorgänge') }}</p>
        <ul class="list-group list-group-horizontal">
            @forelse(App\AnforderungControlItem::where('firma_id',$firma->id)->take(5)->get() as $requirementControlItem)
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    {{ $requirementControlItem->aci_name }}
                </li>
            @empty
                <li class="list-group-item list-group-item-success">{{ __('Keine Kontrollvorgänge mit der Firma gefunden!') }}</li>
            @endforelse
        </ul>

    </x-modals.form_modal>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row mb-lg-4 md-sm-2">
            <div class="col">
                <h1 class="h3">{{__('Firma bearbeiten')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h2 class="h4">{{ __('Stammdaten') }}</h2>
                <form action="{{ route('firma.update',$firma) }}"
                      method="post"
                >
                    @csrf
                    @method('put')
                    <input type="hidden"
                           name="id"
                           id="id"
                           value="{{ $firma->id??(old('id')??'') }}"
                    >
                    <div class="row">
                        <div class="col">
                            <x-rtextfield id="fa_label"
                                          label="{{__('Kürzel')}}"
                                          value="{{ $firma->fa_label }}"
                            />
                        </div>
                        <div class="col">
                            <x-textfield id="fa_vat"
                                         label="{{__('U-St-ID')}}"
                                         value="{{ $firma->fa_vat }}"
                                         max="30"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textfield id="fa_name"
                                         label="{{__('Name')}}"
                                         value="{{ $firma->fa_name }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-selectfield id="adresse_id"
                                           label="{{__('Adresse')}}"
                            >
                                @foreach(App\Adresse::all() as $adresse)
                                    <option value="{{ $adresse->id }}"
                                            @if($adresse->id === $firma->adresse_id) selected @endif >
                                        {{ $adresse->postalAddress() }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="fa_kreditor_nr"
                                         label="{{__('Liefranten Nummer')}}"
                                         value="{{ $firma->fa_kreditor_nr }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="fa_debitor_nr"
                                         label="{{__('Kundennummer bei Firma')}}"
                                         value="{{ $firma->fa_debitor_nr }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="fa_description"
                                        label="{{__('Beschreibung')}}"
                                        value="{{ $firma->fa_description }}"
                            />
                        </div>
                    </div>

                    <button class="btn btn-primary mt-2">
                        {{__('Firma speichern ')}}<span class="fas fa-download ml-2"></span>
                    </button>

                    <button type="button"
                            class="btn btn-outline-danger mt-2 ml-2"
                            data-toggle="modal"
                            data-target="#modalDeleteCompany"
                    >
                        {{__('Firma löschen ')}} <i class="fas fa-trash-alt ml-2"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-4">
                <h2 class="h4">{{ __('Kontakte') }}</h2>
                <div class="list-group">
                    @forelse(\App\Contact::where('firma_id',$firma->id)->get() as $contact)
                        <a class="list-group-item"
                           href="{{ route('contact.show',$contact) }}"
                        >
                            {{ $contact->fullName() }}
                        </a>
                    @empty
                        <a class="list-group-item"
                           href="{{ route('contact.create',['c'=>$firma]) }}"
                        >
                            {{ __('Neu anlegen') }}
                        </a>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection

