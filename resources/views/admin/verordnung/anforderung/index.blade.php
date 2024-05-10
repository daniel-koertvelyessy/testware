@extends('layout.layout-admin')

@section('pagetitle','Anforderung')

@section('mainSection')
    {{__('Anforderungen')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h3">{{__('Anforderungen')}}</h1>
            </div>
        </div>
        <div class="row">
            <table class="table table-responsive-md table-striped"
                   id="tabAnforderungListe"
            >
                <thead>
                <tr>
                    <th>@sortablelink('an_name', __('Bezeichnung'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('an_label', __('Kennung'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('updated_at', __('Bearbeitet'))</th>
                    <th class="d-none d-md-table-cell">@sortablelink('an_control_interval', __('Intervall'))</th>
                    <th class="text-center d-none d-md-table-cell">{{__('Vorgänge')}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($requirements as $anforderung)
                    <tr>
                        <td>
                            <span class="d-flex justify-content-between align-items-center">


                            @if ($anforderung->AnforderungControlItem->count()===0)
                                    <span class="fas fa-exclamation-triangle text-warning mr-1 d-md-none"></span>
                                @endif
                            <a href="{{ route('anforderung.show',$anforderung) }}">
                                {{ $anforderung->an_name }}
                            </a>
                                @if($anforderung->is_external)
                                    <abbr title="{{ __('Diese Anforderung muss durch eine externe Firma ausgeführt werden') }}">ext</abbr>
                                @endif
                            </span>
                        </td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >{{ $anforderung->an_label }}</td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >
                            {{ ($anforderung->updated_at!==null)? $anforderung->updated_at->diffForHumans() :'-' }}
                        </td>
                        <td style="vertical-align: middle;"
                            class="d-none d-md-table-cell"
                        >
                            @if($anforderung->an_control_interval>0)
                                {{ $anforderung->an_control_interval }} {{ $anforderung->ControlInterval->ci_label??'' }}
                            @else
                                {{ __('ohne') }}
                            @endif
                        </td>
                        <td style="vertical-align: middle;"
                            class="text-center d-none d-md-table-cell"
                        >
                            <span class="{{ $anforderung->AnforderungControlItem->count()>0 ? '' : 'px-2 py-1 btn-warning' }}">
                                {{ $anforderung->AnforderungControlItem->count() }}
                            </span>
                        </td>
                        {{--  <td style="vertical-align: middle; text-align: right;">
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
                          </td>--}}
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
            <div class="d-flex justify-content-center">
                <div class="d-none d-lg-block">
                    {!! $requirements->withQueryString()->onEachSide(2)->links() !!}
                </div>
                <div class="d-lg-none">
                    {!! $requirements->withQueryString()->onEachSide(0)->links() !!}
                </div>
            </div>
        </div>

        @if($isSysAdmin)
            <div class="row">
                <header class="d-flex justify-content-between w-100">
                    <h2 class="h3 mt-3 mt-lg-7">{{ __('Gelöschte Anforderungen') }} </h2>
                    <i class="fa fa-user-shield ml-2 align-content-center"
                       title="{{ __('Nur sichtbar für SysAdmins!') }}"
                    ></i>
                </header>
                <table class="table table-responsive-md table-striped"
                       id="tabAnforderungListe"
                >
                    <thead>
                    <tr>
                        <th>{{ __('Bezeichnung')}}</th>
                        <th class="d-none d-md-table-cell">{{ __('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{ __('Gelöscht')}}</th>
                        <th class="d-none d-md-table-cell">{{ __('Intervall')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Vorgänge')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (\App\Anforderung::with('AnforderungControlItem','ControlInterval')->onlyTrashed()
                    ->withCount('AnforderungControlItem')
                    ->get() as $deletedRequirement)
                        <tr>
                            <td style="vertical-align: middle;">
                            <span class="d-flex justify-content-between align-items-center">
                            @if ($deletedRequirement->AnforderungControlItem_count===0)
                                    <span class="fas fa-exclamation-triangle text-warning mr-1 d-md-none"></span>
                                @endif
                                {{ $deletedRequirement->an_name }}

                                @if($deletedRequirement->is_external)
                                    <abbr title="{{ __('Diese Anforderung muss durch eine externe Firma ausgeführt werden') }}">ext</abbr>
                                @endif
                            </span>
                            </td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >{{ $deletedRequirement->an_label }}</td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >
                                {{ $deletedRequirement->deleted_at->diffForHumans()}}
                            </td>
                            <td style="vertical-align: middle;"
                                class="d-none d-md-table-cell"
                            >
                                @if($deletedRequirement->an_control_interval>0)
                                    {{ $deletedRequirement->an_control_interval }} {{
                                    $deletedRequirement->ControlInterval->ci_label??'' }}
                                @else
                                    {{ __('ohne') }}
                                @endif
                            </td>
                            <td style="vertical-align: middle;"
                                class="text-center d-none d-md-table-cell"
                            >
                            <span class="{{ $deletedRequirement->AnforderungControlItem->count()>0 ? '' : 'px-2 py-1
                            btn-warning'
                            }}"
                            >
                                {{ $deletedRequirement->AnforderungControlItem->count() }}
                            </span>
                            </td>
                            <td>
                                <form action="{{ route('anforderung.restore') }}"
                                      method="post"
                                >
                                    @csrf
                                    <input type="hidden"
                                           name="id"
                                           id="id"
                                           value="{{ $deletedRequirement->id }}"
                                    >
                                    <x-btnSave>
                                       <span class="d-none d-md-inline">
                                           {{ __('Wiederherstellen') }}
                                       </span>
                                    </x-btnSave>
                                </form>
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
                @endif
            </div>
    </div>

@endsection


