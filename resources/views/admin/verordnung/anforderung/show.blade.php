@extends('layout.layout-admin')

@section('pagetitle',__('Anforderung'))

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection

@section('modals')


    <div class="modal fade"
         id="modalAddNewAnforderungType"
         tabindex="-1"
         aria-labelledby="modalAddNewAnforderungTypeLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalAddNewAnforderungTypeLabel"
                    >{{__('Neuen Anforderungstyp anlegen')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addNewAnforderungType') }}"
                          method="post"
                          id="frmAddNewAnforderungsType"
                    >
                        @csrf
                        <x-rtextfield id="at_label"
                                      label="{{__('Kürzel')}}"
                        />
                        <x-textfield id="at_name"
                                     label="{{__('Name')}}"
                        />
                        <x-textarea id="at_description"
                                    label="{{__('Beschreibung')}}"
                        />

                        <x-btnMain>{{__('Anforderungstyp anlegen')}}
                            <span class="fas fa-download"></span>
                        </x-btnMain>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="modalSortControlItems"
         tabindex="-1"
         aria-labelledby="modalSortControlItemsLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalSortControlItemsLabel"
                    >{{__('Prüfungen neu sortieren')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('anforderungcontrolitem.applySort',$anforderung) }}"
                          method="post"
                          id="frmSortControlItems"
                    >
                        @csrf

                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('Aufgabe')}}</th>
                                <th>
                                    <i class="fa fa-sort"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse (App\AnforderungControlItem::where('anforderung_id',$anforderung->id)->orderBy('aci_sort')->get() as $aci)
                                <tr>
                                    <td class="w-75">
                                        {{ $aci->aci_name }}
                                    </td>
                                    <td class="w-25">
                                        <input type="number"
                                               size="4"
                                               class="form-control form-control-sm"
                                               id="aci_sort_{{$aci->id}}"
                                               name="aci_sort[]"
                                               value="{{ $aci->aci_sort }}"
                                        />
                                        <input type="hidden"
                                               name="aci_id[]"
                                               id="aci_id_{{ $aci->id }}"
                                               value="{{ $aci->id }}"
                                        >
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <div class="align-items-center justify-content-between d-flex">
                                            <span class="text-muted">{{__('Keine Prüfungen gefunden')}}</span>
                                        </div>

                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <x-btnMain>{{__('Sortierung anwenden')}}
                            <span class="fas fa-refresh"></span>
                        </x-btnMain>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="modalDeleteRequirement"
         tabindex="-1"
         aria-labelledby="modalDeleteRequirementLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('anforderung.destroy',$anforderung) }}"
                      method="POST"
                >
                    @csrf
                    @method('DELETE')
                    <header class="modal-header">
                        <h5 class="modal-title"
                            id="modalDeleteRequirementLabel"
                        >{{__('Löschung bestätigen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </header>
                    <main class="modal-body">

                        <p class="text-danger">{{ __('Die Löschung der Anforderung werden folgende Objekte ebenfalls gelöscht.') }}</p>

                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{__('Prüfschritte')}}
                                <span class="badge badge-danger badge-pill">{{ \App\AnforderungControlItem::where('anforderung_id',$anforderung->id)->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{__('Produktanforderungen')}}
                                <span class="badge badge-danger badge-pill">{{ \App\ProduktAnforderung::where('anforderung_id',$anforderung->id)->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{__('Geräteprüfungen')}}
                                <span class="badge badge-danger badge-pill">{{ \App\ControlEquipment::where('anforderung_id',$anforderung->id)->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{__('Standortanforderungen')}}
                                <span class="badge badge-danger badge-pill">{{ \App\AnforderungObjekt::where('anforderung_id',$anforderung->id)->count() }}</span>
                            </li>

                        </ul>

                    </main>
                    <footer class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{ __('Abbruch') }}</button>
                        <x-btnMain class="btn-danger">{{ __('Anforderung mit abhängigen Obejkten löschen!') }}</x-btnMain>
                    </footer>

                </form>
            </div>
        </div>
    </div>


@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Anforderung')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <form action="{{ route('anforderung.update',$anforderung) }}"
                      method="POST"
                      id="frmEditVerordnungen"
                      name="frmEditVerordnungen"
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden"
                           name="id"
                           value="{{ $anforderung->id }}"
                    >

                    <x-selectfield name="verordnung_id"
                                   id="verordnung_id"
                                   label="{{__('Gehört zu Verordnung')}}"
                    >
                        @foreach (App\Verordnung::all() as $ad)
                            <option value="{{ $ad->id }}"
                                    @if ($ad->id === $anforderung->verordnung_id)
                                        selected
                                    @endif
                            >{{ $ad->vo_label }}</option>
                        @endforeach
                    </x-selectfield>


                    <x-selectModalgroup id="anforderung_type_id"
                                        label="{{__('Anforderung Typ')}}"
                                        modalid="modalAddNewAnforderungType"
                    >
                        @foreach(App\AnforderungType::all() as $anforderungType)
                            <option value="{{ $anforderungType->id }}">{{ $anforderungType->at_name }}</option>
                        @endforeach
                    </x-selectModalgroup>

                    <div class="row">
                        <div class="col">
                            <x-rtextfield id="updt_an_label"
                                          name="an_label"
                                          label="{{__('Kürzel')}}"
                                          value="{{ $anforderung->an_label }}"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_initial_test"
                                       name="is_initial_test"
                                       value="{{ $anforderung->is_initial_test ? ' 1 ' : '0'  }}"
                                    {{ $anforderung->is_initial_test ? ' checked ' : ''  }}
                                >
                                <label class="form-check-label"
                                       for="is_initial_test"
                                >
                                    {{ __('Ist initiale Funktionsprüfung?') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_external"
                                       name="is_external"
                                       value="{{ $anforderung->is_external ? ' 1 ' : '0'  }}"
                                    {{ $anforderung->is_external ? ' checked ' : ''  }}
                                >
                                <label class="form-check-label"
                                       for="is_external"
                                >
                                    {{ __('Extern durchgeführte Prüfung?') }}
                                </label>
                            </div>
                        </div>
                    </div>


                    <x-textfield id="updt_an_name"
                                 name="an_name"
                                 label="{{__('Name')}}"
                                 value="{{ $anforderung->an_name }}"
                    />

                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="updt_an_control_interval"
                                         name="an_control_interval"
                                         label="{{__('Prüfinterval')}}"
                                         value="{{ $anforderung->an_control_interval }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="control_interval_id"
                                           label="{{__('Zeit')}}"
                            >
                                @foreach (App\ControlInterval::all() as $controlInterval)
                                    <option value="{{ $controlInterval->id }}"
                                            @if ($controlInterval->id === $anforderung->control_interval_id)
                                                selected
                                            @endif
                                    >
                                        {{ $controlInterval->ci_label }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="an_date_warn"
                                         label="{{__('Vorwarnzeit für Prüfungen')}}"
                                         value="{{ $anforderung->an_date_warn }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="warn_interval_id"
                                           label="{{__('Zeit')}}"
                            >
                                @foreach (App\ControlInterval::all() as $controlInterval)
                                    <option value="{{ $controlInterval->id }}"
                                            @if ($controlInterval->id === $anforderung->warn_interval_id)
                                                selected
                                            @endif
                                    >
                                        {{ $controlInterval->ci_label }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>

                    <x-textarea id="updt_an_description"
                                name="an_description"
                                label="{{__('Beschreibung')}}"
                                value="{{ $anforderung->an_description }}"
                    />
                    <div class="d-flex">
                        <x-btnMain>{{__('Anforderung aktualisieren')}} <i class="fas fa-download"></i></x-btnMain>

                        <button type="button"
                                class="btn btn-outline-danger ml-1"
                                data-target="#modalDeleteRequirement"
                                data-toggle="modal"
                        >{{ __('Anforderung löschen') }} <i class="fa fa-trash-alt ml-1"></i></button>
                    </div>


                </form>
            </div>
            <div class="col-md-6">
                <h2 class="h4">{{__('Prüfungen zur Anforderung')}}</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{__('Kürzel')}}</th>
                        <th>{{__('Aufgabe')}}</th>
                        <th>
                            <button class="btn btn-sm btn-outline-secondary"
                                    data-target="#modalSortControlItems"
                                    data-toggle="modal"
                            >
                                <i class="fa fa-sort"></i>
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\AnforderungControlItem::where('anforderung_id',$anforderung->id)->orderBy('aci_sort')->get() as $aci)
                        <tr>
                            <td>
                                <a href="{{ route('anforderungcontrolitem.show',$aci) }}">{{ $aci->aci_label }}</a>
                            </td>
                            <td>
                                <span class="d-flex justify-content-between">
                                     {{ $aci->aci_name }}

                                    @if ($aci->isIncomplete($aci))
                                        <ul class="text-warning">
                                        {!! $aci->isIncomplete($aci) !!}
                                    </ul>
                                    @endif
                                </span>

                            </td>
                            <td>
                                {{ $aci->aci_sort }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <span class="text-muted">{{__('Keine Prüfungen gefunden')}}</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <a href="{{ route('anforderungcontrolitem.create',['rid'=>$anforderung]) }}" class="btn
                btn-outline-primary">{{ __('Neuen Prüfschritt erstellen') }} <i class="fa fa-angle-right ml-1"></i></a>
            </div>
        </div>

    </div>

@endsection
