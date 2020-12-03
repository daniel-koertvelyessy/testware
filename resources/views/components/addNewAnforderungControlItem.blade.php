

<form action="{{ route('anforderungcontrolitem.store') }}" method="POST" name="frmAddNewAnforderungControlItem" id="frmAddNewAnforderungControlItem">
    @csrf
    <input type="hidden" name="anforderung_id" id="anforderung_id">
    <div class="tab-content" id="nav-tabContent">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-cianforderung-tab" data-toggle="tab" href="#nav-cianforderung" role="tab" aria-controls="nav-cianforderung" aria-selected="true">{{__('Anforderung')}}</a>
                <a class="nav-link disabled" id="nav-cicontrol-tab" data-toggle="tab" href="#nav-cicontrol" role="tab" aria-controls="nav-cicontrol" aria-selected="false">{{__('Umfang')}}</a>
                <a class="nav-link disabled" id="nav-cicontact-tab" data-toggle="tab" href="#nav-cicontact" role="tab" aria-controls="nav-cicontact" aria-selected="false">{{__('Ausführung')}}</a>
            </div>
        </nav>
        <div class="tab-content pt-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-cianforderung" role="tabpanel" aria-labelledby="nav-cianforderung-tab">
            <p class="lead text-primary">{{__('Wählen Sie als erstes die Anforderung aus, welche zum Vorgang zugeordnet werden soll.')}}</p>

            <x-selectfield id="anforderung_id_modal" name="anforderung_id" label="Anforderung">
                @foreach (App\Anforderung::all() as $anforderung)
                    <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_lang }}</option>
                @endforeach
            </x-selectfield>

            <button type="button" class="btn btn-sm btn-primary bentNextTab mt-5"
                    data-showtab="#nav-cicontrol-tab"
            >{{__('weiter')}}</button>
        </div>
        <div class="tab-pane fade" id="nav-cicontrol" role="tabpanel" aria-labelledby="nav-cicontrol-tab">
            <p class="lead text-primary">{{__('Vergeben Sie Namen und Kürzel für den neuen Vorgang.')}}</p>
            <div class="row">
                <div class="col-md-4">
                    <x-rtextfield id="aci_name_kurz" label="Kürzel" />
                </div>
                <div class="col-md-6">
                    <x-rtextfield id="aci_name_lang" label="Name" max="150" />
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               name="aci_control_equipment_required"
                               id="aci_control_equipment_required"
                               value="1"
                        >
                        <label class="custom-control-label"
                               for="aci_control_equipment_required"
                        >{{__('Prüfmittel benötigt')}}</label>
                    </div>
                </div>
            </div>
            <p class="lead text-primary my-3">{{__('Legen Sie nun den Umfang des Vorgangs fest.')}}</p>
            <x-textarea id="aci_task" label="Aufgabe" />

            <div class="row">
                <div class="col-md-2">
                    <x-textfield  id="aci_value_si" label="{{__('SI-Einheit')}}" max="10"/>
                </div>
                <div class="col-md-3">
                    <x-textfield id="aci_vaule_soll" label="{{__('Sollwert')}}" class="decimal"/>
                </div>
                <div class="col-md-3">
                    <label for="aci_value_target_mode">{{__('Zielwert i.O.')}}</label>
                    <select name="aci_value_target_mode"
                            id="aci_value_target_mode"
                            class="custom-select"
                    >
                        <option @if(old('aci_value_target_mode') ==='lt') selected @endif value="lt">{{__('Kleiner als Soll')}}</option>
                        <option @if(old('aci_value_target_mode') ==='eq') selected @endif value="eq">{{__('Gleich ± Toleranz')}}</option>
                        <option @if(old('aci_value_target_mode') ==='gt') selected @endif value="gt">{{__('Größer als Soll')}}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <x-textfield id="aci_value_tol" label="± Toleranz" class="decimal"  />
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"
                               id="aci_value_tol_mod_abs" name="aci_value_tol_mod"
                               class="custom-control-input"
                               value="abs"
                            {{ old('aci_value_tol_mod') === 'abs'? ' checked ' :'' }}
                        >
                        <label class="custom-control-label" for="aci_value_tol_mod_abs">abs</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"
                               id="aci_value_tol_mod_pro" name="aci_value_tol_mod"
                               class="custom-control-input"
                               value="pro"
                            {{ old('aci_value_tol_mod') === 'pro'? ' checked ' :'' }}
                        >
                        <label class="custom-control-label" for="aci_value_tol_mod_pro">%</label>
                    </div>
                </div>
            </div>
            <div class="card p-3 my-4">
                <p>Die Felder <code>Sollwert</code> und <code>SI-Einheit</code> können leer gelassen werden. In diesem Fall wird ein einfacher Entscheidungsschalter generiert. Dieser speichert, ob die oben beschriebene Aufgabe erfült wurde oder nicht.</p>
                <p>Soll ein Messwert abgelesen werden sind die Angaben <code>Sollwert</code> und <code>SI-Einheit</code> zwingend erforderlich!</p>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary bentBackTab"
                    data-showtab="#nav-cianforderung-tab"
            >{{__('zurück')}}</button>
            <button type="button" class="btn btn-sm btn-primary bentNextTab"
                    data-required="#aci_name_kurz,#aci_name_lang"
                    data-showtab="#nav-cicontact-tab"
            >{{__('weiter')}}</button>
        </div>
        <div class="tab-pane fade" id="nav-cicontact" role="tabpanel" aria-labelledby="nav-cicontact-tab">
            <p class="lead text-primary">{{__('Legen Sie zum Abschluss fest, wer den Vorgang ausführen wird.')}}</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="custom-control custom-radio custom-control-inline mb-3">
                        <input type="radio" id="aci_internal" name="aci_execution" class="custom-control-input" value="0" checked>
                        <label class="custom-control-label" for="aci_internal">{{__('Interne Durchführung')}}</label>
                    </div>
                    <x-selectfield id="aci_contact_id" label="{{__('Eingewiesener Mitarbeiter')}}">
                        @foreach (App\User::with('Profile')->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-radio custom-control-inline mb-3">
                        <input type="radio" id="aci_external" name="aci_execution" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="aci_external">{{__('Externe Durchführung')}}</label>
                    </div>
                    <x-selectfield id="firma_id" label="Firma">
                        @foreach (App\Firma::all() as $firma)
                            <option value="{{ $firma->id }}">{{ $firma->fa_name_lang }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
            </div>
            <button class="btn btn-primary btn-block">{{__('Vorgang anlegen')}}</button>
        </div>
        </div>
    </div>
</form>

<script>


    $('#firma_id').change(function () {
        $('#aci_external').prop('checked',true);
    })

    $('#aci_contact_id').change(function () {
        $('#aci_internal').prop('checked',true);
    })


</script>
