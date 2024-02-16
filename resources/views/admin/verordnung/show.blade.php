@extends('layout.layout-admin')

@section('pagetitle')
{{__('Verordnung ')}}  &triangleright; {{__('Vorschriften')}}
@endsection

@section('mainSection')
    {{__('Verordnung')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Verordnung')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <form action="{{ route('verordnung.update',$verordnung) }}" method="POST" id="frmEditVerordnungen" name="frmEditVerordnungen">
                    @csrf
                    @method('PUT')
                    <input type="hidden"
                           name="id"
                           value="{{ $verordnung->id }}"
                    >
                    <x-rtextfield id="updt_vo_label" name="vo_label" label="{{__('Kürzel')}}" value="{{
                    $verordnung->vo_label }}" />

                    <x-textfield id="updt_vo_name" name="vo_name" label="{{__('Name')}}" value="{{
                    $verordnung->vo_name }}" />

                    <x-textfield id="updt_vo_nummer" name="vo_nummer" label="{{__('Nummer/Zeichen')}}" value="{{
                    $verordnung->vo_nummer }}" />

                    <x-textfield id="updt_vo_stand" name="vo_stand" label="{{__('Stand')}}" value="{{
                    $verordnung->vo_stand }}" />

                    <x-textarea id="updt_vo_description" name="vo_description" label="{{__('Beschreibung')}}"
                                value="{{ $verordnung->vo_description }}" />

                    <x-btnMain>{{__('Verordnung aktualisieren')}}</x-btnMain>

                </form>
            </div>
            <div class="col-md-5">
                <h2 class="h4">Anforderungen in der Verordnung</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Erstellt</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\Anforderung::where('verordnung_id',$verordnung->id)->get() as $requirement)
                        <tr>
                            <td>
                                <a href="{{ route('anforderung.show', $requirement) }}">{{ $requirement->an_name }}</a></td>
                            <td>{{ $requirement->created_at->DiffForHumans() }}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                <x-notifyer>Keine Anforderungen gefunden</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfooter>
                        <tr>
                            <td colspan="2">
                                <a href="{{ route('anforderung.create') }}?v={{ $verordnung->id }}">Neue Anforderung
                                    anlegen</a>
                            </td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>

    </div>

@endsection
