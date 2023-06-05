@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Prüfschritte')}}
@endsection

@section('mainSection')
    {{__('Prüfschritte')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row d-md-block d-none mb-4">
            <div class="col">
                <h1 class="h3">{{__('Prüfschritte')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped"
                       id="tabAnforderungItemListe"
                >
                    <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th class="d-none d-md-table-cell">@sortablelink('aci_name', __('Aus
                        Anforderung'))</th>
                        <th class="w-50">@sortablelink('Anforderung.an_label', __('Bezeichnung'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('updated_at', __('Geändert'))</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($aciitems as $aci)
                        <tr>
                            <td style="vertical-align: middle;">
                                <x-menu_context :object="$aci"
                                                routeOpen="{{ route('anforderungcontrolitem.show',$aci) }}"
                                                routeCopy="{{ route('anforderungcontrolitem.copy',$aci) }}"
                                                routeDestory="{{ route('anforderungcontrolitem.destroy',$aci) }}"
                                                objectName="aci_name"
                                                objectVal="{{ $aci->aci_name }}"
                                                right="true"
                                />
                            </td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >{{
                                $aci->Anforderung->an_label??'Ohne Anforderung' }}
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="{{ route('anforderungcontrolitem.show',$aci) }}">{{ $aci->aci_name }}</a>
                            </td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >{{ $aci->updated_at->diffForHumans() ??'-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-notifyer>{{ __('Keine Verordnungen gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <div class="d-none d-lg-block">
                        {!! $aciitems->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                    <div class="d-lg-none">
                        {!! $aciitems->withQueryString()->onEachSide(0)->links() !!}
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
