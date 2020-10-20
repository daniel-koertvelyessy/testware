@extends('layout.layout-admin')

@section('pagetitle','Anforderung')

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
                <h1 class="h3">Anforderungen</h1>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Bezeichnung</th>
                    <th class="d-none d-md-table-cell">Kennung</th>
                    <th class="d-none d-md-table-cell">Bearbeitet</th>
                    <th class="d-none d-md-table-cell">Intervall</th>
                    <th class="text-center d-none d-md-table-cell">Vorgänge</th>
                    <th></th>
                    <th class="d-none d-md-table-cell"></th>
                </tr>
                </thead>
                <tbody>

                @forelse (App\Anforderung::latest()->get() as $anforderung)
                    <tr>
                        <td style="vertical-align: middle;">{{ $anforderung->an_name_lang }}</td>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $anforderung->an_name_kurz }}</td>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $anforderung->updated_at??'-' }}</td>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $anforderung->an_control_interval }} {{ $anforderung->ControlInterval->ci_name }}  </td>
                        <td style="vertical-align: middle;" class="text-center d-none d-md-table-cell">{{ $anforderung->AnforderungControlItem->count() }}</td>
                        <td style="vertical-align: middle;"><a href="{{ route('anforderung.show',$anforderung) }}">Bearbeiten</a></td>
                        <td class="d-none d-md-table-cell" style="vertical-align: middle;">
                            <form action="{{ route('anforderung.destroy',$anforderung) }}" method="post">
                                @csrf
                                @method('delete')

                                <button class="btn btn-link">löschen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <x-notifyer>{{ __('Keine Anforderungen gefunden') }}</x-notifyer>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
