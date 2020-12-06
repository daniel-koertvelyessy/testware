@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    <h1>{{__('Server Error')}}</h1>
    <p class="lead">{{ __('Entschuldigung. Bei der Verarbeitung des Daten ist ein Fehler unterlaufen.') }}</p>
@endsection
@section('buttons')
    <a href="#" onclick="history.back()" class="btn btn-lg btn-outline-secondary">{{__('zurück')}}</a>
    <a href="/" class="btn btn-lg btn-primary">{{__('zum Portal')}}</a>
@endsection
