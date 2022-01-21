@extends('layout.layout-app')

@section('pagetitle')
    {{__('Übersicht Gerät')}} {{ $edata->eq_name }}
@endsection

@section('mainSection')
   {{ str_limit(__('Übersicht Gerät') . ' '. $edata->eq_name,20) }}
@endsection

@section('content')
    <div class="container">
        <div class="row mt-md-5 mt-1 d-none d-md-block">
            <div class="col">
                <span class="h5">{{ __('Übersicht Gerät') }}</span>
                <h1 class="h3">{{ $edata->eq_name }}</h1>
            </div>
        </div>
        @if(Auth::user())
        <div class="row">
            <div class="col-md-6">
                    <h2 class="h5 mt-3">{{__('Details zum Gerät')}} </h2>
                    <dl class="row">
                        <dt class="col-sm-4">{{__('Inventar-Nr')}}</dt>
                        <dd class="col-sm-8">{{ $edata->eq_inventar_nr }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">{{__('Serien-Nr')}}</dt>
                        <dd class="col-sm-8">{{ $edata->eq_serien_nr }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">{{__('Standort')}}</dt>
                        <dd class="col-sm-8">{{ $edata->storage->storage_label }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">{{__('Inbetriebname')}}</dt>
                        <dd class="col-sm-8">{{ Carbon\Carbon::parse($edata->installed_at)->DiffForHumans() }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">{{__('zuletzt bearbeitet')}}</dt>
                        <dd class="col-sm-8">{{ $edata->created_at->DiffForHumans() }}</dd>
                    </dl>
            </div>
            <div class="col-md-6">
                <h2 class="h5 mt-3">{{__('Gerät Dokumente')}} </h2>
                @if (App\EquipmentDoc::where('equipment_id',$edata->id)->count()>0)
                    <table class="table table-responsive-md table-striped table-sm">
                        <thead>
                        <th>{{ __('Datei')}}</th>
                        <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                        <th style="text-align: right;">{{ __('Größe')}} kB</th>
                        <th></th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach (App\EquipmentDoc::where('equipment_id',$edata->id)->get() as $equipDoc)
                            <tr>
                                <td>{{ $equipDoc->eqdoc_name }}</td>
                                <td class="d-none d-md-table-cell">{{ $equipDoc->DocumentType->doctyp_label }}</td>
                                <td style="text-align: right;">{{ $equipDoc->getSize($equipDoc->eqdoc_name_pfad) }}</td>
                                <td>
                                    <form action="{{ route('downloadEquipmentDokuFile') }}#dokumente"
                                          method="get"
                                          id="downloadEquipmentFunction_{{ $equipDoc->id }}"
                                    >
                                        @csrf
                                        <input type="hidden"
                                               name="id"
                                               id="download_equipment_function_id_{{ $equipDoc->id }}"
                                               value="{{ $equipDoc->id }}"
                                        >
                                    </form>
                                    <button
                                        class="btn btn-sm btn-outline-secondary"
                                        onclick="event.preventDefault(); document.getElementById('downloadEquipmentFunction_{{ $equipDoc->id }}').submit();"
                                    >
                                        <span class="fas fa-download"></span>
                                    </button>
                                </td>
                                <td>
                                    <x-deletebutton action="{{ route('equipDoku.destroy',$equipDoc->id) }}#dokumente"
                                                    tabtarget="dokumente"
                                                    prefix="EquipmentFunction"
                                                    id="{{ $equipDoc->id }}"
                                    />
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <x-notifyer>{{__('Keine Dateien zum Gerät gefunden')}}!</x-notifyer>
                @endif
                <h2 class="h5 mt-3">{{__('Produktdokumente')}}</h2>
                @if (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->count()>0)

                    @foreach (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->get() as $produktDoc)
                        <x-filecard name="{{ $produktDoc->DocumentType->doctyp_name }}"
                                    label="{{ $produktDoc->proddoc_label }}"
                                    path="{{ $produktDoc->proddoc_name_pfad }}"
                                    id="{{ $produktDoc->id }}"
                        />
                    @endforeach

                @else
                    <x-notifyer>{{__('Keine Dateien gefunden')}}!</x-notifyer>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">
                    <a href="{{ route('equipment.show',$edata) }}"
                       class="btn btn-lg btn-primary"
                    >{{__('Gerät öffnen')}} <i class="fas fa-angle-right ml-3"></i></a>
                <a href="{{ route('edmg',$ident) }}"
                   class="btn btn-lg btn-outline-secondary"
                >{{__('Schaden melden')}} <i class="fas fa-angle-right ml-3"></i></a>
            </div>
        </div>
        @else
            <div class="row">
                <div class="col">
                    <h2 class="h5 mt-3">{{__('Produktdokumente')}}</h2>
                    @if (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->count()>0)

                        @foreach (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->get() as $produktDoc)
                            <x-filecard downloadroute="{{ route('downloadProduktDokuFile') }}"
                                        name="{{ $produktDoc->DocumentType->doctyp_name }}"
                                        label="{{ $produktDoc->proddoc_label }}"
                                        path="{{ $produktDoc->proddoc_name_pfad }}"
                                        id="{{ $produktDoc->id }}"
                            />
                        @endforeach

                    @else
                        <x-notifyer>{{__('Keine Dateien gefunden')}}!</x-notifyer>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="{{ route('edmg',$ident) }}"
                       class="btn btn-lg btn-primary"
                    >{{__('Schaden melden')}} <i class="fas fa-angle-right ml-3"></i></a>
                </div>
            </div>
        @endif
    </div>

    {{--{{ $edata }}--}}


@endsection
