@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))

<h1>{{__('Unauthorized')}}</h1>
<p class="lead">{{ __('Dieser Bereich ist gesperrt.') }}</p>
@endsection
@section('buttons')
    <a href="#" onclick="history.back()" class="btn btn-lg btn-outline-secondary">{{__('zurück')}}</a>
    <a href="{{ route('login') }}" class="btn btn-lg btn-primary">{{__('anmelden')}}</a>
@endsection
