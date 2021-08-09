@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    <h1>{{__('Page Expired')}}</h1>
    <p class="lead">{{ __('Sie haben für längere Zeit keine Eingabe gemacht. Aus Sicherheitsgründen wurde die Übermittlung der Daten verhindert. Bitte laden Sie die Seite neu.') }}</p>
@endsection
@section('buttons')
    <a href="#" onclick="history.back()" class="btn btn-lg btn-outline-secondary">{{__('zurück')}}</a>
    <a href="{{ route('portal-main') }}" class="btn btn-lg btn-primary">{{__('zum Portal')}}</a>
@endsection
