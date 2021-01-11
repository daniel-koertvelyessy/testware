@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Übersicht Prüfungen')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht')}}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-striped" id="tabControlListe">
                    <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">{{__('Gerät')}}</th>
                        <th>@sortablelink('Equipment.eq_inventar_nr', __('Inventar-Nr'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('Anforderung.an_name', __('Prüfung'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('qe_control_date_due', __('Fällig'))</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($controlItems as $controlItem)
                        <tr>
                            <td class="d-none d-md-table-cell">
                                {{ $controlItem->Equipment->Produkt->prod_label }}
                            </td>
                            <td>
                                <span class="d-md-none">{!! $controlItem->checkDueDateIcon($controlItem) !!}</span>
                                {{ $controlItem->Equipment->eq_inventar_nr }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if($controlItem->Anforderung->isInComplete($controlItem->Anforderung))
                                    <a href="{{ route('anforderung.show',$controlItem->Anforderung) }}">
                                        {{ $controlItem->Anforderung->an_name }}
                                    </a>
                                    {!! $controlItem->Anforderung->isInComplete($controlItem->Anforderung)['msg'] !!}
                                @else
                                    {{ $controlItem->Anforderung->an_name }}
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">
                                {!! $controlItem->checkDueDate($controlItem) !!}
                            </td>
                            <td>
                                <a href="{{ route('control.create',['test_id' => $controlItem]) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <span class="d-none d-md-inline">{{__('jetzt prüfen')}}</span>
                                    <span class="fas fa-stethoscope"></span>
                                </a>
                                @if ($controlItem->Anforderung->isInComplete($controlItem->Anforderung))
                                    <span class="d-md-none">
                                        {!! $controlItem->Anforderung->isInComplete($controlItem->Anforderung)['msg'] !!}
                                    </span>
                                @endif

                            </td>
                        </tr>
                        @if ($controlItem->Anforderung->isInComplete($controlItem->Anforderung) )
                            <tr>
                                <td colspan="5">
                                    <blockquote class="d-md-none blockquote border-left border-warning pl-3">
                                            <span class="fas fa-exclamation-triangle text-warning"
                                                  aria-label="Symbol für unvollständige Prüfung"
                                            ></span> => {{__('Prüfung ist unvollständig. Vor dem Start der Prüfung muss diese ergänzt werden.')}}
                                    </blockquote>
                                </td>
                            </tr>

                        @endif
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-notifyer>{{__('Es sind bislang keine Prüfungen angelegt')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($controlItems->count()>1)
                    <div class="d-flex justify-content-center">
                        {!! $controlItems->withQueryString()->onEachSide(2)->links()??'' !!}
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
{{--@section('scripts')
    @if ($controlItems->count()>0)
        <link rel="stylesheet"
              type="text/css"
              href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"
        >
        <script type="text/javascript"
                charset="utf8"
                src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"
        ></script>

        <script>

            $('#tabControlListe').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                "columnDefs": [
                    {"orderable": false, "targets": 4}
                ],
                "dom": '<"top"i>rt<"bottom"p><"clear">',
                "pagingType": "full"
            });
        </script>
    @endif
@endsection--}}
