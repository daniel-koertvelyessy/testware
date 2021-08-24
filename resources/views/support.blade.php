@extends('layout.layout-portal')

@section('pagetitle')
    {{ __('Support')}} @ testWare
@endsection

@section('navigation')
    @include('menus._menuPortal')
@stop

@section('content')

    <div class="container-lg">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="h3">{{__('Senden Sie uns Ihr Anliegen')}}</h1>
                <div class="mb-3">
                    <label for="suppportFromName" class="form-label">{{__('Ansprechpartner')}}</label>
                    <input type="text" class="form-control" id="suppportFromName" name="suppportFromName" placeholder="Vor- Nachname">
                </div>
                <div class="mb-3">
                    <label for="supportFromEMail" class="form-label">{{__('Email Adresse')}}</label>
                    <input type="email" class="form-control" id="supportFromEMail" name="supportFromEMail" placeholder="email@adresse.de">
                </div>
                <div class="mb-3">
                    <label for="supportFromMsg" class="form-label">{{__('Bitte beschreiben Sie Ihr Problem')}}</label>
                    <textarea class="form-control" id="supportFromMsg" name="supportFromMsg" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <h2 class="h4">{{__('Dringlichkeit')}}</h2>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="supportLevel" id="spLvlNormal" value="option1" checked>
                        <label class="form-check-label" for="spLvlNormal">{{__('Normal')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="supportLevel" id="spLvlHigh" value="option2">
                        <label class="form-check-label" for="spLvlHigh">{{__('Hoch')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="supportLevel" id="spLvlSOS" value="option3">
                        <label class="form-check-label" for="spLvlSOS">{{__('SOS')}}</label>
                    </div>
                </div>
                <button type="button" class="btn btn-primary">{{__('Anliegen absenden')}}</button>
            </div>
            <div class="col-lg-4">
                <div class="card">
{{--                    <img src="#" class="card-img-top" alt="Herr XL">--}}
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Ihr Ansprechpartner')}}</h5>
                        <div class="card-text">
                            <ul class="list-unstyled">
                                <li>{{ __('Daniel Körtvélyessy')}}</li>
                                <li>Mobil: <a href="tel:+49173855998">+49 173 5779408</a></li>
                                <li>E-Mail: <a href="mailto:daniel.koertvelyessy@bitpack.io">daniel.koertvelyessy@bitpack.io</a></li>
                            </ul>
                            <p>{{ __('Ihre Kundennummer')}}: <br><span class="lead" >556975</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
