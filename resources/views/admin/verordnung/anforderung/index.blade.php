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
                <h1 class="h3">{{__('Anforderungen')}}</h1>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped"  id="tabAnforderungListe">
                <thead>
                <tr>
                    <th>@sortablelink('an_name', __('Bezeichnung'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('an_label', __('Kennung'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('updated_at', __('Bearbeitet'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('an_control_interval', __('Intervall'))</th>
                    <th class="text-center d-none d-md-table-cell">{{__('Vorgänge')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($requirements as $anforderung)
                    <tr>
                        <td style="vertical-align: middle;">{{ $anforderung->an_name }}</td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >{{ $anforderung->an_label }}</td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >
                            {{ ($anforderung->updated_at!==NULL)? $anforderung->updated_at->diffForHumans() :'-' }}
                        </td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >{{ $anforderung->an_control_interval }} {{ $anforderung->ControlInterval->ci_label }}  </td>
                        <td style="vertical-align: middle;"
                            class="text-center d-none d-md-table-cell"
                        >{{ $anforderung->AnforderungControlItem->count() }}</td>
                        <td style="vertical-align: middle; text-align: right;">
                            <div class="btn-group dropleft">
                                <button type="button"
                                        class="btn  m-0 "
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                >
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('anforderung.show',$anforderung) }}"
                                       class="dropdown-item d-flex justify-content-between align-items-center"
                                    >
                                        Bearbeiten <i class="fas fa-edit"></i>
                                    </a>
                                    <a href=""
                                       onclick="event.preventDefault(); document.getElementById('frmDeleteAnforderung{{ $anforderung->id }}').submit();"
                                       class="dropdown-item d-flex justify-content-between align-items-center"
                                    >
                                        Löschen <i class="fas fa-trash-alt"></i>
                                    </a>

                                </div>
                                <form action="{{ route('anforderung.destroy',$anforderung) }}"
                                      id="frmDeleteAnforderung{{ $anforderung->id }}"
                                      method="post"
                                >
                                    @csrf
                                    @method('delete')


                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <x-notifyer>{{ __('Keine Anforderungen gefunden') }}</x-notifyer>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection


