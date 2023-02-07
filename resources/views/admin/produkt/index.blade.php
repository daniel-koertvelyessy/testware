@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Produktübersicht')}}
@endsection

@section('mainSection')
    {{__('Produkte')}}
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('modals')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4 d-md-block d-none">
            <div class="col">
                <h1 class="h4 mb-0">{{__('Übersicht Produkte')}}</h1>
                <span class="small mt-0">{{__('Gesamt')}}: <span
                        class="badge badge-light"
                    >{{ number_format(App\Produkt::all()->count(),0,',','.') }}</span></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped"
                >
                    <thead>
                    <tr>
                        <th>@sortablelink('prod_label', __('Bezeichung'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('prod_nummer', __('Artikelnummer'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ProduktKategorie.pk_label', __('Kategorie'))
                        </th>
                        <th>@sortablelink('prod_active', __('Aktiv'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ControlProdukt.id', __('Prüfmittel'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ProduktState.ps_label', __('Status'))</th>
                        @if($isSysAdmin)
                        <th></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($produktList as $produkt)
                        @if($produkt)
                        <tr>
                            <td>
                                <a href="{{ route('produkt.show',$produkt) }}">{{ $produkt->prod_name }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $produkt->prod_nummer }}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->ProduktKategorie->pk_label }}</td>
                            <td>{!!  ($produkt->prod_active == 1) ? '<i class="far fa-check-circle text-success"></i>' : '<i class="far fa-times-circle text-danger"></i>' !!}</td>
                            <td class="d-none d-md-table-cell">{!! $produkt->ControlProdukt ? '<i class="far fa-check-circle text-success"></i>' : '' !!}</td>
                            <td class="d-none d-md-table-cell">
                                <span class="p-1 bg-{{ $produkt->ProduktState->ps_color }} text-white mr-1">
                                    {{ $produkt->ProduktState->ps_label }}
                                </span>

                                @if($produkt->ProductQualifiedUser->count()===0)
                                    <span class="fas fa-user-md text-warning" title="{{ __('Es ist keine befähigte Person hinterlegt') }}"></span>
                                @endif

                                @if($produkt->ProduktAnforderung->count()===0)
                                    <span class="fas fa-stethoscope text-warning" title="{{ __('Es ist keine Anforderung hinterlegt') }}"></span>
                                @endif

                            </td>
                            @if($isSysAdmin)
                            <td>
                                <x-menu_context :object="$produkt"
                                                routeOpen="{{ route('produkt.show',$produkt) }}"
                                                routeCopy="#"
                                                routeDestory="{{ route('produkt.destroy',$produkt)}}"
                                                objectName="prod_label"
                                                objectVal="{{ $produkt->prod_label }}"
                                                />
                            </td>
                            @endif
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-notifyer>{{__('Keine Produkte gefunden')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($produktList->count() >0)
                    <div class="d-flex justify-content-center">
                        {{ $produktList->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
