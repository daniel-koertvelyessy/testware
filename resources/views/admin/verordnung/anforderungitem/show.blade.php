@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Prüfschritt')}} {{ $anforderungcontrolitem->aci_label }} &triangleright; testWare
@endsection

@section('mainSection')
    {{__('Prüfschritt')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection

@section('modals')

    <x-modals.form_modal modalId="modalDeleteTestProcedure"
                         title="{{ __('Prüfschritt löschen') }}"
                         methode="DELETE"
                         modalType="danger"
                         modalSize="lg"
                         modalRoute="{{ route('anforderungcontrolitem.destroy',$anforderungcontrolitem) }}"
                         btnSubmit="{{ __('Prüfschritt entgültig löschen') }}"
    >
        <input type="hidden"
               name="id"
               id="id"
               value="{{$anforderungcontrolitem->id}}"
        >
        @if($testEventFromItem->count()>0)
            <h1 class="h3">{{ __('Vorsicht') }}</h1>
            <p>{{ __('Folgende Prüfungen haben diesen Prüfschritt verwendet. Ein Löschung lässt deren Zuordnung nicht mehr nachvollziehen!') }}</p>
            <ul class="list-unstyled">
                @foreach($testEventFromItem as $item )
                    <li class="list-group-item">
                        <span class="text-muted">{{ __('Datum') }} :</span> {{ $item->ControlEvent->control_event_date }}
                        |
                        <span class="text-muted">{{ __('Prüfer') }} :</span>{{ $item->ControlEvent->control_event_controller_name }}
                        |
                        <span class="text-muted">{{ __('Gerät') }} :</span> {{ $item->ControlEvent->Equipment->eq_name??'-' }}
                    </li>
                @endforeach
            </ul>

        @else
            <p>{{ __('Es wurden keine vergangenen Prüfungen mit diesem Prüfschritt gefunden.') }}</p>
        @endif
    </x-modals.form_modal>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4 d-none d-md-block">
            <div class="col">
                <h1 class="h3">{{__('Prüfschritt')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <h2 class="h4">{{ __('Details') }}</h2>

                <form action="{{ route('anforderungcontrolitem.update',['anforderungcontrolitem'=>$anforderungcontrolitem]) }}"
                      method="post"
                >
                    @csrf
                    @method('put')
                    <input type="hidden"
                           name="id"
                           id="aci_id"
                           value="{{ $anforderungcontrolitem->id }}"
                    >
                    <x-selectfield id="updt_anforderung_id"
                                   name="anforderung_id"
                                   label="{{__('Anforderung')}}"
                    >
                        @foreach (App\Anforderung::all() as $anforderung)
                            <option value="{{ $anforderung->id }}"
                                    @if ($anforderung->id === $anforderungcontrolitem->anforderung_id )
                                        selected
                                    @endif
                            >{{ $anforderung->an_name }}</option>
                        @endforeach
                    </x-selectfield>
                    <div class="row">
                        <div class="col-md-4">
                            <x-rtextfield id="aci_label"
                                          label="{{__('Kürzel')}}"
                                          value="{{ $anforderungcontrolitem->aci_label }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-rtextfield id="aci_name"
                                          label="{{__('Name')}}"
                                          max="150"
                                          value="{{ $anforderungcontrolitem->aci_name }}"
                            />
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       name="aci_control_equipment_required"
                                       id="aci_control_equipment_required"
                                       @if ($anforderungcontrolitem->aci_control_equipment_required)
                                           checked
                                        @endif
                                >
                                <label class="custom-control-label"
                                       for="aci_control_equipment_required"
                                >{{__('Prüfmittel benötigt')}}</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <x-textfield id="aci_sort"
                                         type="number"
                                         label="{{ __('Sortierung') }}"
                                         :value="$anforderungcontrolitem->aci_sort"
                            />
                        </div>
                    </div>

                    <x-textarea id="aci_task"
                                label="{{__('Aufgabe')}}"
                                value="{{ $anforderungcontrolitem->aci_task }}"
                    />

                    <div class="row">
                        <div class="col-md-2">
                            <x-textfield id="aci_value_si"
                                         label="{{__('SI-Einheit')}}"
                                         max="10"
                                         value="{{ $anforderungcontrolitem->aci_value_si }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="aci_vaule_soll"
                                         label="{{__('Sollwert')}}"
                                         class="decimal"
                                         value="{{ $anforderungcontrolitem->aci_vaule_soll }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-tolModeSelect
                                    id="aci_value_target_mode"
                                    mode="{{ $anforderungcontrolitem->aci_value_target_mode }}"
                                    :setdp="true"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-textfield id="aci_value_tol"
                                         label="{{__('± Toleranz')}}"
                                         class="decimal"
                                         value="{{ $anforderungcontrolitem->aci_value_tol??'' }}"
                            />
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio"
                                       id="aci_value_tol_mod_abs"
                                       name="aci_value_tol_mod"
                                       class="custom-control-input"
                                       value="abs"
                                        {{ $anforderungcontrolitem->aci_value_tol_mod === 'abs'? ' checked ' :'' }}
                                >
                                <label class="custom-control-label"
                                       for="aci_value_tol_mod_abs"
                                >abs
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio"
                                       id="aci_value_tol_mod_pro"
                                       name="aci_value_tol_mod"
                                       class="custom-control-input"
                                       value="pro"
                                        {{ $anforderungcontrolitem->aci_value_tol_mod === 'pro'? ' checked ' :'' }}
                                >
                                <label class="custom-control-label"
                                       for="aci_value_tol_mod_pro"
                                >%
                                </label>
                            </div>
                        </div>
                    </div>

                    {{--  <div class="row">
                          <div class="col-md-6">
                              <div class="custom-control custom-radio custom-control-inline mb-3">
                                  <input type="radio"
                                         id="updt_aci_internal"
                                         name="aci_execution"
                                         class="custom-control-input"
                                         value="0"
                                         @if (!$anforderungcontrolitem->aci_execution)
                                             checked
                                          @endif
                                  >
                                  <label class="custom-control-label"
                                         for="updt_aci_internal"
                                  >{{__('Interne Durchführung')}}</label>
                              </div>
                              <x-selectfield name="aci_contact_id"
                                             id="updt_aci_contact_id"
                                             label="{{__('Mitarbeiter')}}"
                              >
                                  @forelse (App\User::with('profile')->get() as $user)
                                      <option value="{{ $user->id }}"
                                              @if ($user->id === $anforderungcontrolitem->aci_contact_id)
                                                  selected
                                              @endif
                                      >
                                          @if($user->profile)
                                              {{ substr($user->profile->ma_vorname,0,1)??''}}
                                              . {{ $user->profile->ma_name }}
                                          @else
                                              {{ $user->name }}
                                          @endif
                                      </option>
                                  @empty
                                      <option value="void"
                                              disabled
                                      >{{ __('keinen Eintrag gefunden') }}</option>
                                  @endforelse
                              </x-selectfield>
                          </div>
                          <div class="col-md-6">
                              <div class="custom-control custom-radio custom-control-inline mb-3">
                                  <input type="radio"
                                         id="updt_aci_external"
                                         name="aci_execution"
                                         class="custom-control-input"
                                         value="1"
                                         @if ($anforderungcontrolitem->aci_execution)
                                             checked
                                          @endif
                                  >
                                  <label class="custom-control-label"
                                         for="updt_aci_external"
                                  >{{__('Externe Durchführung')}}</label>
                              </div>
                              <x-selectfield id="firma_id"
                                             label="{{__('Firma')}}"

                              >
                                  @foreach (App\Firma::all() as $firma)
                                      @if ($firma->id !== 1)
                                          <option value="{{ $firma->id }}"
                                                  @if ($firma->id === $anforderungcontrolitem->firma_id)
                                                      selected
                                                  @endif
                                          >{{ $firma->fa_name }}</option>
                                      @endif

                                  @endforeach
                              </x-selectfield>
                          </div>
                      </div>--}}

                    <button class="btn btn-primary">{{__('Prüfschritt speichern')}}</button>
                    <button class="btn btn-outline-danger ml-2"
                            data-toggle="modal"
                            type="button"
                            data-target="#modalDeleteTestProcedure"
                    >{{ __('Prüfschritt löschen') }}</button>
                </form>
            </div>
            <div class="col-md-5 d-flex flex-column justify-content-between">
                <main>
                    <h2 class="h4">{{ __('Datenpunkte') }}</h2>
                    <p>{{ __('Es können verschiedene Datenpunkte einem Prüfschritt zugeordnet werden.')
                    }}</p>


                    @if($dataSetItems->count() > 0)
                        <table class="table">
                            <tr>
                                <th>Soll-Wert</th>
                                <th>Ziel</th>
                                <th></th>
                            </tr>
                            @foreach($dataSetItems as $item)
                                <tr>
                                    <td>
                                        {{ $item->data_point_value }}
                                        {{ $item->data_point_sort }}
                                    </td>
                                    <td>
                                        {{ $item->data_point_tol }}
                                        {{ $item->data_point_tol_mod === 'pro' ? '%':'' }}
                                    </td>
                                    <td>
                                        <x-menu_context :object="$item"
                                                        modal-open="#modalEditDatensatz{{ $item->id }}"
                                                        route-open="#"
                                                        route-copy="#"
                                                        route-destory=""
                                                        objectName="aci_name"
                                                        objectVal="{{ $item->id }}"
                                                        right="true"
                                        />

                                        <x-modals.form_blank :title="__('Datensatz bearbeiten')"
                                                             modalId="modalEditDatensatz{{ $item->id }}"
                                                             modalSize="lg"
                                        >
                                            <x-formUpdateAciDataset :acidataset="$item" />
                                        </x-modals.form_blank>

                                    </td>
                                </tr>


                            @endforeach
                        </table>

                    @else
                        <h3 class="h5">{{ __('Neuen Datenpunkt anlegen') }}</h3>
                        <x-formAddAciDataset :aciid="$anforderungcontrolitem->id"/>
                    @endif


                </main>
                @if($dataSetItems->count() >0)
                    <x-modals.form_blank modalId="frmAddNewAciDataset"
                                         title="Neuen Datensatz anlegen"
                                         modalSize="xl"
                    >
                        <x-formAddAciDataset :aciid="$anforderungcontrolitem->id"/>
                    </x-modals.form_blank>
                    <footer>
                        <button class="btn btn-outline-primary "
                                id="btnAddNewDataPoint"
                                data-toggle="modal"
                                data-target="#frmAddNewAciDataset"
                        >
                            <span class="d-none d-md-inline mr-2">{{ __('Neuen Datenpunkt anlegen') }}</span>
                            <span class="fas fa-plus"></span>
                        </button>
                    </footer>
                @endif

            </div>
        </div>

    </div>

@endsection
