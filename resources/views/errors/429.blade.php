@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message')
    <p class="lead">{{ __('Nicht so schnell ...') }}</p>
    <p>{{ __('Sie haben in kurzer Zeit zu viele Anfragen versucht. Aus Sicherheitsgründen wird Ihr Zugang für eine kurze Zeit gesperrt.') }}</p>
@endsection
@section('buttons')
    <a href="/" class="btn btn-lg btn-primary">{{__('zum Portal')}}</a>
@endsection
