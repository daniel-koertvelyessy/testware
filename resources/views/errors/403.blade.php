@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')

    <h1>{{__($exception->getMessage() ?: 'Forbidden')}}</h1>
<p class="lead">{{ __('Dieser Bereich ist gesperrt.') }}</p>
@endsection
@section('buttons')
    <a href="#" onclick="history.back()" class="btn btn-lg btn-outline-secondary">{{__('zurück')}}</a>
    <a href="{{ route('login') }}" class="btn btn-lg btn-primary">{{__('anmelden')}}</a>
@endsection
