@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Vorgang')}}
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
                <h1 class="h3">{{__('Vorgang')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
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
                                   label="Anforderung"
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
                                          label="Kürzel"
                                          value="{{ $anforderungcontrolitem->aci_label }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-rtextfield id="aci_name"
                                          label="Name"
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
                                       value="1"
                                       @if ($anforderungcontrolitem->aci_control_equipment_required ===1)
                                           checked
                                       @endif
                                >
                                <label class="custom-control-label"
                                       for="aci_control_equipment_required"
                                >Prüfmittel benötigt</label>
                            </div>
                        </div>
                    </div>

                    <x-textarea id="aci_task"
                                label="Aufgabe"
                                value="{{ $anforderungcontrolitem->aci_task }}"
                    />

                    <div class="row">
                        <div class="col-md-2">
                            <x-textfield id="aci_value_si"
                                         label="SI-Einheit [kg, °C, V usw]"
                                         max="10"
                                         value="{{ $anforderungcontrolitem->aci_value_si }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="aci_vaule_soll"
                                         label="Sollwert"
                                         class="decimal"
                                         value="{{ $anforderungcontrolitem->aci_vaule_soll }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <label for="aci_value_target_mode">Zielwert i.O.</label> <select name="aci_value_target_mode"
                                                                                             id="aci_value_target_mode"
                                                                                             class="custom-select"
                            >
                                <option @if($anforderungcontrolitem->aci_value_target_mode ==='lt') selected
                                        @endif value="lt"
                                >Kleiner als Soll
                                </option>
                                <option @if($anforderungcontrolitem->aci_value_target_mode ==='eq') selected
                                        @endif value="eq"
                                >Gleich ± Toleranz
                                </option>
                                <option @if($anforderungcontrolitem->aci_value_target_mode ==='gt') selected
                                        @endif value="gt"
                                >Größer als Soll
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <x-textfield id="aci_value_tol"
                                         label="± Toleranz"
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
                                >abs</label>
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
                                >%</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio"
                                       id="updt_aci_internal"
                                       name="aci_execution"
                                       class="custom-control-input"
                                       value="0"
                                       @if ($anforderungcontrolitem->aci_execution===0)
                                       checked
                                    @endif
                                >
                                <label class="custom-control-label"
                                       for="updt_aci_internal"
                                >Interne Durchführung</label>
                            </div>
                            <x-selectfield name="aci_contact_id"
                                           id="updt_aci_contact_id"
                                           label="Mitarbeiter"
                            >
                                @foreach (App\User::with('profile')->get() as $user)
                                    <option value="{{ $user->id }}"
                                            @if ($user->id === $anforderungcontrolitem->aci_contact_id)
                                            selected
                                        @endif
                                    >{{ substr($user->profile->ma_vorname,0,1)}}. {{ $user->profile->ma_name }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio"
                                       id="updt_aci_external"
                                       name="aci_execution"
                                       class="custom-control-input"
                                       value="1"
                                       @if ($anforderungcontrolitem->aci_execution===1)
                                       checked
                                    @endif
                                >
                                <label class="custom-control-label"
                                       for="updt_aci_external"
                                >Externe Durchführung</label>
                            </div>
                            <x-selectfield id="firma_id"
                                           label="Firma"

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
                    </div>

                    <button class="btn btn-primary">{{__('Vorgang')}} speichern</button>
                </form>
            </div>
        </div>

    </div>

@endsection
