@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
    <p class="lead">{{ __($exception->getMessage() ?: 'Service Unavailable') }}</p>
<p>{{ __('Der geforderte Service der Anwendung konnte nicht ausgeführt werden. Bitte versuchen Sie es später noch einmal.') }}</p>
@endsection
@section('buttons')
    <a href="/" class="btn btn-lg btn-primary">{{__('zum Portal')}}</a>
@endsection
