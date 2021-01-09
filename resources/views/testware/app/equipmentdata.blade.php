@extends('layout.layout-app')

@section('pagetitle')
    {{__('Übersicht Gerät')}}
@endsection

@section('content')

    <div class="container">
        <div class="row mt-md-5 mt-sm-1">
            <div class="col">
                <span class="h5">Gerät</span>
                <h1 class="h3">{{ $edata->produkt->prod_name }}</h1>

                <h2 class="h5 mt-3">{{__('Dokumente')}}</h2>
                @if (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->count()>0)

                    @foreach (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->get() as $produktDoc)
                        <div class="card p-2 col-md-4 col-lg-3">
                            <dl class="row">
                                <dt class="col-md-4">{{ __(' Typ') }}:</dt>
                                <dd class="col-md-8">{{ $produktDoc->DocumentType->doctyp_name }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-4">{{ __(' Name') }}:</dt>
                                <dd class="col-md-8">{{ $produktDoc->proddoc_label }}</dd>
                            </dl>

                            <dl class="row">
                                <dt class="col-md-4">{{ __(' Größe') }}:</dt>
                                <dd class="col-md-8">{{ number_format(\Illuminate\Support\Facades\Storage::size($produktDoc->proddoc_name_pfad)/1028,1) }}kB</dd>
                            </dl>
                            <form action="{{ route('downloadProduktDokuFile') }}#prodDoku"
                                  method="get"
                                  id="downloadProdDoku_{{ $produktDoc->id }}"
                            >
                                @csrf
                                <input type="hidden"
                                       name="id"
                                       id="download_produktdoc_id_{{ $produktDoc->id }}"
                                       value="{{ $produktDoc->id }}"
                                >
                            </form>
                            <button
                                class="btn btn-primary btn-block mb-2"
                                onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();"
                            >{{ __('Öffnen') }} <span class="fas fa-download ml-3"></span>
                            </button>
                        </div>
                    @endforeach

                @else
                    <x-notifyer>{{__('Keine Dateien gefunden')}}!</x-notifyer>
                @endif


                @auth
                    <h2 class="h5 mt-3">Details zum Gerät </h2>
                    <dl class="row">
                        <dt class="col-sm-4">Inventar-Nr</dt>
                        <dd class="col-sm-8">{{ $edata->eq_inventar_nr }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Serien-Nr</dt>
                        <dd class="col-sm-8">{{ $edata->eq_serien_nr }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Standort</dt>
                        <dd class="col-sm-8">{{ $edata->standort->std_kurzel }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Inbetriebname</dt>
                        <dd class="col-sm-8">{{ Carbon\Carbon::parse($edata->eq_ibm)->DiffForHumans() }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">zuletzt bearbeitet</dt>
                        <dd class="col-sm-8">{{ $edata->created_at->DiffForHumans() }}</dd>
                    </dl>
                    <h2 class="h5 mt-3">Dateien zum Gerät </h2>
                    @if (App\EquipmentDoc::where('equipment_id',$edata->id)->count()>0)
                        <table class="table table-striped table-sm">
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
                    <a href="{{ route('equipment.show',$edata) }}"
                       class="btn btn-lg btn-primary btn-block"
                    >zum Gerät <i class="fas fa-angle-right ml-3"></i></a>
                @endauth

            </div>
        </div>
    </div>

    {{--{{ $edata }}--}}


@endsection
