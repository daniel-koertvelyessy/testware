@extends('layout.layout-admin')

@section('pagetitle','Verordnungen')

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Übersicht')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped "
                       id="tabVerordnungListe"
                >
                    <thead>
                    <tr>
                        <th>@sortablelink('vo_name', __('Bezeichnung'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('vo_nummer', __('Kennung'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('updated_at', __('Bearbeitet'))</th>
                        <th class="text-center d-none d-md-table-cell">{{ __('Anforderungen')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($verordnungen as $verordnung)
                        <tr>
                            <td style="vertical-align: middle;">{{ $verordnung->vo_name }}</td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >{{ $verordnung->vo_nummer }}</td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >{{ $verordnung->updated_at??'-' }}</td>
                            <td style="vertical-align: middle;"
                                class="text-center d-none d-md-table-cell"
                            >{{ $verordnung->anforderung->count() }}</td>
                            <td style="vertical-align: middle; text-align: right;">
                                <x-menu_context :object="$verordnung"
                                                route="verordnung"
                                                routeOpen="{{ route('verordnung.show',$verordnung) }}"
                                                routeDestory="{{ route('verordnung.destroy',$verordnung) }}"
                                                routeCopy="#"
                                                tabName=""
                                                objectName="verordnung"
                                                objectVal="{{ $verordnung->id }}"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <x-notifyer>{{ __('Keine Verordnungen gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
