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
                <h1 class="h3">Verordnungen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped "
                       id="tabVerordnungListe"
                >
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th class="text-center d-none d-md-table-cell">Anforderungen</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse (App\Verordnung::latest()->get() as $verordnung)
                        <tr>
                            <td style="vertical-align: middle;">{{ $verordnung->vo_name_lang }}</td>
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
        $('#tabVerordnungListe').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
            },
            "columnDefs": [
                {"orderable": false, "targets": 4}
            ],
            "dom": dom
        });
    </script>
@endsection
