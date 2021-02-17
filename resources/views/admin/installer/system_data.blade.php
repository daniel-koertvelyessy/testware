@extends('layout.layout-login')

@section('pagetitle')
{{__('Benutzer')}} &triangleright; {{__('Installation')}} &triangleright; testWare
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
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('installer.company') }}"
                    >{{ __('Firmierung') }} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('installer.user') }}"
                    >{{ __('Benutzer') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link disabled"
                       href="#"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('System') }}<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <div class="navbar-nav">
                <a class="btn btn-sm btn-warning"
                   href="{{ route('installer.company') }}"
                >{{ __('Abbruch') }}</a>
                <a class="btn btn-sm btn-primary ml-4"
                   href="{{ route('portal-main') }}"
                >{{ __('Abschließen') }}</a>

            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-8">
                <h2 class="h4">{{ __('Produktstati') }}</h2>
                <div class="row">
                    <div class="col-md-6">
                        <x-textfield id="ps_label" label="{{ __('Bezeichner') }}" max="20" required/>
                    </div>
                    <div class="col-md-6">
                        <x-textfield id="ps_name" label="{{ __('Name') }}" max="100"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h5">{{ __('Statusfarben') }}</h2>
                        <x-selectfield id="ps_color" label="{{ __('Farbe') }}">
                            <option class="text-muted" value="muted">{{ __('Ohne - grau') }}</option>
                            <option class="text-info" value="success">{{ __('Information - blau') }}</option>
                            <option class="text-success" value="success">{{ __('In Ordnung - grün') }}</option>
                            <option class="text-warning" value="warning">{{ __('Warnung - Orange') }}</option>
                            <option class="text-danger" value="danger">{{ __('Gefahr - Rot') }}</option>
                        </x-selectfield>
                    </div>
                    <div class="col-md-6">
                        <h2 class="h5">{{ __('Statusicons') }}</h2>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sp_icon_muted" name="sp_icon" class="custom-control-input" value="fas fa-info">
                            <label class="custom-control-label" for="sp_icon_muted">
                                <span class="fas fa-info"></span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sp_icon_checked" name="sp_icon" class="custom-control-input" value="fas fa-check">
                            <label class="custom-control-label" for="sp_icon_checked">
                                <span class="fas fa-check"></span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sp_icon_exclamation" name="sp_icon" class="custom-control-input" value="fas fa-exclamation">
                            <label class="custom-control-label" for="sp_icon_exclamation">
                                <span class="fas fa-exclamation"></span>
                            </label>
                        </div>
                        <label for="sp_icon_other">{{ __('Andere Klasse') }}</label>
                        <input type="text" class="form-control form-control-sm" id="sp_icon_other" name="sp_icon_other" placeholder="fas fa-info">
                        <p class="muted">{!! __('Sie können auch andere icons aus der <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Fontawsome</a> Sammlung einfügen') !!}</p>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <h2 class="h4">{{__('Erfasst')}}</h2>
                <button type="reset"
                        id="btnResetProductStateForms"
                        class="btn btn-sm btn-outline-primary mr-2"
                >{{ __('Neu') }} <i class="far fa-file ml-2"></i></button>
                <button type="button"
                        id="btnStoreProductStateData"
                        class="btn btn-sm btn-outline-primary mr-2"
                >{{ __('Status speichern') }} <i class="fas fa-save ml-2"></i></button>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>Icon/{{ __('Farbe') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(App\ProduktState::all() as $produktState)
                        <tr>
                            <td>{{ $produktState->ps_label }}</td>
                            <td><span class="{{ $produktState->ps_icon }} text-{{ $produktState->ps_color }}"></span></td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>


    </script>

@endsection
