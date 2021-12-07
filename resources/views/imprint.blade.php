@extends('layout.layout-portal')

@section('pagetitle')
    {{__('testWare')}}
@endsection

@section('navigation')
    @include('menus._menuPortal')
@endsection

@section('content')
    <div class="container mt-sm-5">
        <div class="row justify-content-md-center">
            <div class="col">
                <section class="mb-2 mb-md-4">
                    <h1 class="h2">{{__('Impressum')}}</h1>
                    <dl class="row">
                        <dt class="col-sm-3 col-lg-2">{{ __('Firma') }}</dt>
                        <dd class="col-sm-9 col-lg-10">{{ $company_name??'My Company Name' }}</dd>
                    </dl>
                    @if(isset($vat))
                    <dl class="row">
                        <dt class="col-sm-3 col-lg-2">{{ __('VAT') }}</dt>
                        <dd class="col-sm-9 col-lg-10">{{ $vat??'DE123145155' }}</dd>
                    </dl>
                    @endif
                    <dl class="row">
                        <dt class="col-sm-3 col-lg-2">{{ __('Adresse') }}</dt>
                        <dd class="col-sm-9 col-lg-10">{{ $address??'ComapnyStreet No 11 / 1234 CompanyCity' }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3 col-lg-2">{{ __('Konatkt') }}</dt>
                        <dd class="col-sm-9 col-lg-10">{{ $contact??'name' }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3 col-lg-2">{{ __('Telefon') }}</dt>
                        <dd class="col-sm-9 col-lg-10">{{ $telefon??'-' }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3 col-lg-2">{{ __('E-Mail') }}</dt>
                        <dd class="col-sm-9 col-lg-10">{{ $email??'-' }}</dd>
                    </dl>


                </section>
            </div>
        </div>
    </div>
@endsection
