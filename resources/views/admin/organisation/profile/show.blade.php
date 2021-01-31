@extends('layout.layout-admin')

@section('pagetitle')
{{__('Profil')}} {{ $profile->fa_label }} &triangleright; {{__('Organisation')}}
@endsection

@section('mainSection')
    {{__('Organisation')}}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('modals')
    <x-modals.form_modal methode="DELETE"
                    modalRoute="{{ route('profile.destroy',$profile) }}"
                    modalId="modalDeleteProfile"
                    modalType="danger"
                    title="{{ __('Vorsicht') }}"
                    btnSubmit="{{ __('Mitarbeiter löschen') }}"
    >
        <p class="lead">Das Löschen eines Mitarbeiters kann nicht rückgängig gemacht werden.</p>
    </x-modals.form_modal>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Mitarbeiter bearbeiten')}}</h1>
            </div>
        </div>
        <form action="{{ route('profile.update',['profile'=>$profile]) }}"
              method="post"
        >
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="id"
                   value="{{ $profile->id??(old('id')??'') }}"
            >
            <div class="row">

                <div class="col-md-4">
                    <x-textfield id="ma_vorname"
                                 label="{{__('Vorname')}}"
                                 value="{{ $profile->ma_vorname }}"
                    />
                </div>
                <div class="col-md-4">
                    <x-rtextfield id="ma_name"
                                  label="{{__('Name')}}"
                                  value="{{ $profile->ma_name }}"
                    />
                </div>
                <div class="col-md-4">
                    <x-textfield id="ma_name_2"
                                 label="{{__('2. Name')}}"
                                 value="{{ $profile->ma_name_2 }}"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <x-textfield id="ma_nummer"
                                 label="{{__('MA Nummer')}}"
                                 value="{{ $profile->ma_nummer }}"
                    />
                </div>
                <div class="col-md-4">
                    @if(isset($profile->user->id))
                        <x-selectfield id="adresse_id"
                                       label='Verknüpfter <a href="/user/{{ $profile->user->id }}">System Benutzer</a>'
                        >
                            @foreach(App\User::all() as $user)
                                <option value="{{ $user->id }}"
                                        @if( $user->id === $profile->user_id ) selected @endif >
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </x-selectfield>
                    @else
                        <x-selectfield id="adresse_id"
                                       label='Verknüpfter Nuzer'
                        >
                            <option value="">{{ __('ohne Zuordnung') }}</option>
                            @foreach(App\User::all() as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </x-selectfield>
                    @endif
                </div>
                <div class="col-md-3">
                    <x-datepicker id="ma_eingetreten"
                                  label="{{__('Eingetreten')}}"
                                  value="{{ $profile->ma_eingetreten }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-datepicker id="ma_ausgetreten"
                                  label="{{__('Ausgetreten')}}"
                                  value="{{ $profile->ma_ausgetreten }}"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-textfield id="ma_telefon"
                                 label="{{__('Telefon')}}"
                                 value="{{ $profile->ma_telefon }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-textfield id="ma_mobil"
                                 label="{{__('Mobil')}}"
                                 value="{{ $profile->ma_mobil }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-textfield id="ma_fax"
                                 label="{{__('Fax')}}"
                                 value="{{ $profile->ma_fax }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-textfield id="ma_com_1"
                                 label="{{__('Com 1')}}"
                                 value="{{ $profile->ma_com_1 }}"
                    />
                </div>

            </div>

            <button class="btn btn-primary mt-2">
                {{__('Mitarbeiter speichern ')}}<span class="fas fa-download ml-2"></span>
            </button>

            <button type="button"
                    class="btn btn-outline-danger mt-2"
                    data-toggle="modal"
                    data-target="#modalDeleteProfile"
            >
                {{__('Mitarbeiter löschen ')}} <i class="fas fa-trash-alt ml-2"></i>
            </button>
        </form>

    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener("keydown", function (zEvent) {

            if (zEvent.altKey && zEvent.key === "s") {  // case sensitive
                document.forms[0].submit()
            }
            if (zEvent.altKey && zEvent.key === "n") {  // case sensitive
                location.href = "{{ route('profile.create') }}"

            }
        });


    </script>
@endsection
