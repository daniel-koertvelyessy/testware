@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Prüfungen')}}
@endsection

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
                <h1 class="h3">{{__('Prüfungen')}}</h1>
            </div>
        </div>
        <div class="row">
            <table class="table table-responsive-md table-striped"
                   id="tabAnforderungItemListe"
            >
                <thead>
                <tr>
                    <th class="d-none d-md-table-cell">@sortablelink('aci_name', __('Anforderung'))</th>
                    <th>@sortablelink('Anforderung.an_label', __('Bezeichnung'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('updated_at', __('Geändert'))</th>
                    <th class="text-center d-none d-md-table-cell">@sortablelink('aci_execution', __('Ausführung'))</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @forelse ($aciitems as $aci)
                    <tr>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >{{ $aci->Anforderung->an_label }}</td>
                        <td style="vertical-align: middle;">{{ $aci->aci_name }}</td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >{{ $aci->updated_at->diffForHumans() ??'-' }}</td>
                        <td style="vertical-align: middle;"
                            class="text-center d-none d-md-table-cell"
                        >
                            {{ $aci->aci_execution=== 1 ? 'extern' : 'intern'  }}
                        </td>
                        <td style="vertical-align: middle;">
                            <x-menu_context :object="$aci"
                                            routeOpen="{{ route('anforderungcontrolitem.show',$aci) }}"
                                            routeCopy="{{ route('anforderungcontrolitem.copy',$aci) }}"
                                            routeDestory="{{ route('anforderungcontrolitem.destroy',$aci) }}"
                                            objectName="aci_name"
                                            objectVal="{{ $aci->aci_name }}"
                            />
                        </td>

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

@endsection
