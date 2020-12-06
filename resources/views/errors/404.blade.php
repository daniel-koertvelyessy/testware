@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    <h1>{{__('Not Found')}}</h1>
    <p class="lead">{{ __('Die angeforderte Seite konnte nicht gefunden werden.') }}</p>
@endsection
@section('buttons')
    <a href="#" onclick="history.back()" class="btn btn-lg btn-outline-secondary">{{__('zurück')}}</a>
    <a href="/" class="btn btn-lg btn-primary">{{__('zum Portal')}}</a>
@endsection
