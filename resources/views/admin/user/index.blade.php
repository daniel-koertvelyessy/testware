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
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{__('Verwaltung')}}</li>
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
                        <th class="d-none d-md-table-cell">{{__('Rolle(n)')}}</th>
                        <th class="d-none d-md-table-cell">@sortablelink('created_at', __('Erstellt'))</th>
                        <th class="d-none d-md-table-cell text-center">{{__('API token')}}</th>
                        <th class="text-center">@sortablelink('role_id', __('SysAdmin'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($userList as $user)
                        <tr>
                            <td>
                                <a href="{{ route('user.show',$user->id) }}">{{ $user->name }}</a>
                               {{-- @if($user->deleted_at)
                                    @if($user->deleted_at->addMinutes(30) < now())
                                        <div class="d-flex justify-content-between">
                                    <span>
                                    <span class="fas fa-trash fa-sm text-warning"
                                          title="{{ __('Gelöschtwer Benutzer') }}"
                                    ></span>
                                    {{ $user->name }}</span>
                                            <a href="{{ route('user.restore',$user) }}">
                                                <span class="fas fa-history"></span>
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('user.show',$user->id) }}">{{ $user->name }}</a>
                                @endif--}}
                            </td>
                            <td class="d-none d-md-table-cell">{{ $user->username }}</td>
                            <td class="d-none d-md-table-cell">
                                @foreach($user->roles as $role)
                                    {{ $role->name }}
                                    @if (!$loop->last) / @endif
                                @endforeach
                            </td>
                            <td class="d-none d-md-table-cell">{{ $user->created_at->DiffForHumans() }}</td>
                            <td class="d-none d-md-table-cell text-center">{!! $user->api_token !== null ? '<i class="fas fa-check-circle text-success"></i>' : '' !!}</td>
                            <td class="text-center">
                                {!! $user->role_id===1 ? '<i class="fas fa-check-circle text-success"></i>' : '' !!}
                            </td>
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
