@extends('layout.layout-admin')

@section('pagetitle')
{{__('Kontakte')}} &triangleright; {{__('Organisation')}}
@endsection

@section('mainSection')
    {{__('Organisation')}}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h1 class="h3">{{__('Kontakte')}}</h1>
                <span class="badge badge-light">{{__('Gesamt')}}: {{ $contacts->total() }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-striped">
                    <thead>
                    <tr>
                        <th>@sortablelink('con_email', __('Name'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('firma.fa_name', __('Firma'))</th>
                        <th>@sortablelink('con_email', __('E-Mail'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('con_telefon', __('Telefon'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($contacts as $contact)
                        <tr>
                            <td>
                                <a href="{{ route('contact.show',$contact) }}">{{ $contact->fullName() }}</a>
                            </td>
                            <td class="d-none d-md-table-cell"><a href="{{ route('firma.show',$contact->firma) }}">{{ $contact->firma->fa_name }}</a></td>
                            <td>{{ $contact->con_email }}</td>
                            <td class="d-none d-md-table-cell">{{ $contact->con_telefon }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>{{ __('Keine Kontakte gefunden!') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($contacts->count() >0)
                    <div class="d-flex justify-content-center">
                        {!! $contacts->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
