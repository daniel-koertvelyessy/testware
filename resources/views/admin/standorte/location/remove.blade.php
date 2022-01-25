@extends('layout.layout-admin')

@section('pagetitle')
{{__('Standort löschen')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('content')
    <div class="container mt-2">
        <h1 class="h3">{{__('Standort')}} <span class="text-danger">{{ $location->l_name }}</span> löschen</h1>
        <form action="{{ route('location.destroy', $location) }}"
              method="post"
              class="needs-validation"
        >
            @csrf
            @method('delete')
            <input type="hidden"
                   name="storage_id"
                   id="storage_id"
                   value="{{ $location->storage_id }}"

            >
            <div class="row">
                <div class="col-md-2">
                    <p class="lead">Adresse</p>
                </div>
                <div class="col-md-10">
                    @if(\App\Adresse::count()>0)
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="deleteAddress" name="deleteAddress" value="{{ $address->id }}">
                        <label class="custom-control-label text-danger" for="deleteAddress">
                            {{ __('Zugehörige Adresse löschen') }}
                        </label>
                    </div>
                        @else
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" disabled class="custom-control-input" id="deleteAddress" name="deleteAddress" value="{{ $address->id }}">
                            <label class="custom-control-label text-warning" for="deleteAddress">
                                {{ __('Zugehörige Adresse kann nur gelöscht werden, wenn mehr als zwei angelegt sind!') }}
                            </label>
                        </div>
                    @endif
                    <div class="border-top pt-2">
                        <dl class="row">
                            <dt class="col-sm-3">{{__('Postal')}}:</dt>
                            <dd class="col-sm-9">{{ $location->Adresse->ad_name }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">{{__('Straße')}}, {{__('Nr')}}</dt>
                            <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_strasse }}, {{ $location->Adresse->ad_anschrift_hausnummer }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">{{__('Plz')}}</dt>
                            <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_plz }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">{{__('Ort')}}</dt>
                            <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_ort }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p class="lead">{{ __('Mitarbeiter')}}</p>
                </div>
                <div class="col-md-10">
                    @if(\App\Profile::count()>1)
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="deleteEmployee" name="deleteEmployee" value="{{ $employee->id }}">
                        <label class="custom-control-label text-danger" for="deleteEmployee">
                            {{ __('Zugewiesenen Mitarbeiter löschen') }}
                        </label>
                    </div>
                    @else
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" disabled class="custom-control-input" id="deleteEmployee" name="deleteEmployee" value="{{ $employee->id }}">
                            <label class="custom-control-label text-warning" for="deleteEmployee">
                                {{ __('Zugewiesenen Mitarbeiter können nur gelöscht werden, wenn zwei oder mehr angelegt sind!') }}
                            </label>
                        </div>
                    @endif
                    <div class="border-top pt-2">
                        <dl class="row">
                            <dt class="col-sm-3">{{__('Name')}}</dt>
                            <dd class="col-sm-9">{{ $employee->ma_vorname }} {{ $employee->ma_name }} </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">
                                <span class="text-truncate">{{__('Telefon')}}</span>
                            </dt>
                            <dd class="col-sm-9">{{ $employee->ma_telefon }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">{{__('Mobil')}}</dt>
                            <dd class="col-sm-9">
                                <a href="tel:{{ $employee->ma_mobil }}">{{ $employee->ma_mobil }}</a>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">{{__('E-Mail')}}</dt>
                            <dd class="col-sm-9">{{ $employee->ma_email }}</dd>
                        </dl>

                    </div>
                </div>
            </div>
            @if(count($buildings)>0)
            <p>Folgende Objekte sind in dem Betrieb angelegt:</p>
            <div class="row">
                <div class="col-md-2">
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="deleteLocationObjects" name="deleteLocationObjects" value="{{ $location->id }}">
                        <label class="custom-control-label text-danger" for="deleteLocationObjects">
                            {{ __('Verknüpfte Objekte löschen') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <p class="lead">{{ __('Gebäude') }}</p>
                    @foreach($buildings as $building)
                        <div class="row @if( ! $loop->last ) border-bottom @endif">
                            <div class="col-md-2">
                                <span class="font-weight-bold">{{ $building->b_label}}</span>
                            </div>
                            <div class="col-md-10">
                                <p class="lead">{{ __('Räume') }}</p>
                                @foreach($building->room as $room)
                                    <div class="row @if( ! $loop->last ) border-bottom @endif">
                                        <div class="col-md-2">
                                            <span class="font-weight-bold">{{ $room->r_label}}</span>
                                        </div>
                                        <div class="col-md-10">
                                            <p class="lead">{{ __('Stellplätze') }}</p>
                                            @foreach($room->stellplatzs as $stellplatz)
                                                <div class="row @if( ! $loop->last ) border-bottom @endif">
                                                    <div class="col-md-2">
                                                        <span class="font-weight-bold">{{ $stellplatz->sp_label}}</span>
                                                    </div>
                                                    <div class="col-md-10">

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-md-2">
                        <span class="lead">Gebäude</span>
                    </div>
                    <div class="col-md-10">
                            <i class="far fa-check-circle text-success"></i> Keine Gebäude zum Betrieb gefunden
                    </div>
                </div>
            @endif
            <a href="{{ route('location.show',$location) }}"
               class="btn btn-primary  mt-3 mt-md-7"
            >
                <i class="fas fa-angle-left"></i> {{ __('Zurück') }}
            </a>
            <button class="btn-outline-danger btn mt-3 mt-md-7">{{__('Standort endgültig löschen')}} <span class="ml-3 far fa-trash-alt"></span></button>
        </form>
    </div>

@endsection


@section('actionMenuItems')
    {{--    <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
            <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
                <a class="dropdown-item" href="#">Drucke Übersicht</a>
                <a class="dropdown-item" href="#">Standortbericht</a>
                <a class="dropdown-item" href="#">Formularhilfe</a>
            </ul>--}}
@endsection()

@section('scripts')

    <script>


    </script>

@endsection
