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
            <table class="table table-striped" id="tabAnforderungItemListe">
                <thead>
                <tr>
                    <th>{{__('Bezeichnung')}}</th>
                    <th class="d-none d-md-table-cell">{{__('Anforderung')}}</th>
                    <th class="d-none d-md-table-cell">{{__('Geändert')}}</th>
                    <th class="text-center d-none d-md-table-cell">{{__('Ausführung')}}</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @forelse (App\AnforderungControlItem::latest()->get() as $aci)
                    <tr>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $aci->Anforderung->an_name_kurz }}</td>
                        <td style="vertical-align: middle;">{{ $aci->aci_name_lang }}</td>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $aci->updated_at->diffForHumans() ??'-' }}</td>
                        <td style="vertical-align: middle;" class="text-center d-none d-md-table-cell">
                            {{ $aci->aci_execution=== 1 ? 'extern' : 'intern'  }}
                        </td>
                        <td style="vertical-align: middle;"><a href="{{ route('anforderungcontrolitem.show',$aci) }}">{{__('Bearbeiten')}}</a></td>
                        <td style="vertical-align: middle;">
                            <form action="{{ route('anforderungcontrolitem.destroy',$aci) }}" method="post">
                                @csrf
                                @method('delete')

                                <button class="btn btn-link">{{__('löschen')}}</button>
                            </form>
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

@endsection

@section('scripts')
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"
    >

    <script type="text/javascript"
            charset="utf8"
            src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"
    ></script>
    <script type="text/javascript"
            charset="utf8"
            src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"
    ></script>

    <script>
        const dom = ($('tr').length > 15) ? 't<"bottom"flp><"clear">' : 't';
        $('#tabAnforderungItemListe').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
            },
            "columnDefs": [
                {"orderable": false, "targets": 5}
            ],
            "dom": dom
        });
    </script>

@endsection
