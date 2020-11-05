@extends('layout.layout-app')

@section('pagetitle')
    {{__('Übersicht Gerät')}}
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Gerät</h1>
                @if (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->count()>0)
                    <h2 class="h5">Anleitung</h2>
                        @foreach (\App\ProduktDoc::where('produkt_id',$edata->produkt_id)->get() as $produktDoc)
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
                                    >
                                        {{ $produktDoc->proddoc_name_lang }}  <span class="fas fa-download ml-3"></span>
                                    </button>

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
                                    <td>{{ $equipDoc->eqdoc_name_lang }}</td>
                                    <td class="d-none d-md-table-cell">{{ $equipDoc->DocumentType->doctyp_name_kurz }}</td>
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
                    <a href="{{ route('equipment.show',$edata) }}" class="btn btn-lg btn-primary btn-block">zum Gerät <i class="fas fa-angle-right ml-3"></i></a>
                @endauth

            </div>
        </div>
    </div>

{{--{{ $edata }}--}}


@endsection
