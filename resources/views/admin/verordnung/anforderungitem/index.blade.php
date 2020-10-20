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
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Bezeichnung</th>
                    <th class="d-none d-md-table-cell">Anforderung</th>
                    <th class="d-none d-md-table-cell">Aufgabe</th>
                    <th class="text-center d-none d-md-table-cell">Ausführung</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @forelse (App\AnforderungControlItem::latest()->get() as $aci)
                    <tr>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $aci->Anforderung->an_name_kurz }}</td>
                        <td style="vertical-align: middle;">{{ $aci->aci_name_lang }}</td>
                        <td style="vertical-align: middle;" class="d-none d-md-table-cell">{{ $aci->updated_at??'-' }}</td>
                        <td style="vertical-align: middle;" class="text-center d-none d-md-table-cell">
                            {{ $aci->User->name ?? $aci->firma->fa_name_kurz }}
                        </td>
                        <td style="vertical-align: middle;"><a href="{{ route('anforderungitem.show',$aci) }}">Bearbeiten</a></td>
                        <td style="vertical-align: middle;">
                            <form action="{{ route('anforderungitem.destroy',$aci) }}" method="post">
                                @csrf
                                @method('delete')

                                <button class="btn btn-link">löschen</button>
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
