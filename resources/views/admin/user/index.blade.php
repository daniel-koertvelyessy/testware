@extends('layout.layout-admin')

@section('pagetitle')
{{__('Benutzer')}} &triangleright;  {{__('Systemeinstellungen')}} | {{__('Start')}}
@endsection

@section('mainSection')
{{__('Admin')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{__('Portal')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('Verwaltung')}}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Übersicht Benutzer')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortablelink('name', __('Name'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('name', __('Anzeigename'))</th>
                        <th>{{__('Rolle(n)')}}</th>
                        <th class="d-none d-md-table-cell">@sortablelink('created_at', __('Erstellt'))</th>
                        <th class="d-none d-md-table-cell">{{__('API token')}}</th>
                        <th class="d-none d-md-table-cell">@sortablelink('role_id', __('SysAdmin'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($userList as $user)
                        <tr>
                            <td><a href="{{ route('user.show',$user->id) }}">{{ $user->name }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $user->username }}</td>
                            <td>
                            @foreach($user->roles as $role)
                                {{ $role->name }}
                                    @if (!$loop->last) / @endif
                            @endforeach
                            </td>
                            <td class="d-none d-md-table-cell">{{ $user->created_at }}</td>
                            <td class="d-none d-md-table-cell">{!! $user->api_token !== null ? '<i class="fas fa-check-circle text-success"></i>' : '' !!}</td>
                            <td class="d-none d-md-table-cell">{!! $user->role_id===1 ? '<i class="fas fa-check-circle text-success"></i>' : '' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <x-notifyer>Keine Benutzer erstellt! Wer hat sich denn dann angemeledet?????</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($userList->count() >0)
                    <div class="d-flex justify-content-center">
                        {{ $userList->withQueryString()->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>


    </div>

@endsection
