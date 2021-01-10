@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neu anlegen')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('modals')
    <div class="modal fade" id="modalAddNewAdresse" tabindex="-1" aria-labelledby="modalAddNewAdresseLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('adresse.store') }}"
                      method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddNewAdresseLabel">{{ __('Neue Adresse anlegen') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <x-frm_AddAdresse/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Anlegen') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddNewProfile" tabindex="-1" aria-labelledby="modalAddNewProfileLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('profile.store') }}"
                      method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddNewProfileLabel">{{ __('Neuen Mitarbeiter anlegen') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <x-frm_newprofile />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Anlegen') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="container mt-2">
        <h1 class="h3">{{__('Neuen Standort anlegen')}}</h1>
        <form action="{{ route('location.store') }}" method="post" class="needs-validation">
            @csrf
            <input type="hidden"
                   name="storage_id"
                   id="storage_id"
                   value="{{ Str::uuid() }}"
            >
            <div class="row">
                <div class="col">

                    <x-selectModalgroup id="adresse_id" label="{{__('Die Adresse des Standortes festlegen')}}" class="btnAddNewAdresse" modalid="modalAddNewAdresse">
                        @forelse (App\Adresse::all() as $addItem)
                            <option value="{{$addItem->id}}">{{ $addItem->ad_label  }} - {{ $addItem->ad_anschrift_strasse }}</option>
                        @empty
                            <option value="void" disabled>{{__('keine Adressen vorhanden')}}</option>
                        @endforelse
                    </x-selectModalgroup>

                </div>
                <div class="col">
                    <x-selectModalgroup id="profile_id" label="{{__('Leitung des Standortes hat')}}" class="btnAddNewProfile" modalid="modalAddNewProfile">
                        @forelse (App\Profile::all() as $profileItem)
                            <option value="{{$profileItem->id}}">{{ $profileItem->ma_name }}, {{ $profileItem->ma_vorname }}</option>
                        @empty
                            <option value="void" disabled>{{__('keine Mitarbeiter vorhanden')}}</option>
                        @endforelse
                    </x-selectModalgroup>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <x-rtextfield id="l_label" label="Kürzel" />
                    <x-textfield id="l_name" label="Bezeichnung" />
                    <x-textarea id="l_beschreibung" label="Beschreibung" />

                </div>
            </div>
            <x-btnMain>Standort anlegen <span class="ml-3 fas fa-download"></span></x-btnMain>
            {{--    @if (!env('app.makeobjekte') )        @else
                <x-btnMainDisabled>Standort anlegen <span class="ml-2 fas fa-download"></span></x-btnMainDisabled>
            @endif--}}
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
