

<form action="{{ route('addNewAnforderungControlItem') }}#Produkte" method="POST" name="frmAddNewAnforderungControlItem" id="frmAddNewAnforderungControlItem">
    @csrf
    <input type="hidden" name="anforderung_id" id="anforderung_id">
    <div class="tab-content" id="nav-tabContent">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-cianforderung-tab" data-toggle="tab" href="#nav-cianforderung" role="tab" aria-controls="nav-cianforderung" aria-selected="true">Anforderung</a>
                <a class="nav-link disabled" id="nav-cicontrol-tab" data-toggle="tab" href="#nav-cicontrol" role="tab" aria-controls="nav-cicontrol" aria-selected="false">Umfang</a>
                <a class="nav-link disabled" id="nav-cicontact-tab" data-toggle="tab" href="#nav-cicontact" role="tab" aria-controls="nav-cicontact" aria-selected="false">Ausführung</a>
            </div>
        </nav>
        <div class="tab-pane fade show active" id="nav-cianforderung" role="tabpanel" aria-labelledby="nav-cianforderung-tab">
            <p class="lead text-primary">Wählen Sie als erstes die Anforderung aus, welche zum Vorgang zugeordnet werden soll.</p>

            <x-selectfield id="anforderung_id_modal" name="anforderung_id" label="Anforderung">
                @foreach (App\Anforderung::all() as $anforderung)
                    <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_lang }}</option>
                @endforeach
            </x-selectfield>

            <button type="button" class="btn btn-sm btn-primary bentNextTab mt-5"
                    data-showtab="#nav-cicontrol-tab"
            >weiter</button>
        </div>
        <div class="tab-pane fade" id="nav-cicontrol" role="tabpanel" aria-labelledby="nav-cicontrol-tab">
            <p class="lead text-primary">Vergeben Sie Namen und Kürzel für den neuen Vorgang.</p>
            <div class="row">
                <div class="col-md-4">
                    <x-rtextfield id="aci_name_kurz" label="Kürzel" />
                </div>
                <div class="col-md-8">
                    <x-rtextfield id="aci_name_lang" label="Name" max="150" />
                </div>
            </div>
            <p class="lead text-primary my-3">Legen Sie nun den Umfang des Vorgangs fest.</p>
            <x-textarea id="aci_task" label="Aufgabe" />

            <div class="row">
                <div class="col-md-4">
                    <x-textfield id="aci_value_si" label="SI-Einheit [kg, °C, V usw]" max="10" />
                </div>
                <div class="col-md-4">
                    <x-textfield id="aci_vaule_soll" label="Sollwert" />
                </div>
            </div>
            <div class="card p-3 my-4">
                <p>Die Felder <code>Sollwert</code> und <code>SI-Einheit</code> können leer gelassen werden. In diesem Fall wird ein einfacher Entscheidungsschalter generiert. Dieser speichert, ob die oben beschriebene Aufgabe erfült wurde oder nicht.</p>
                <p>Soll ein Messwert abgelesen werden sind die Angaben <code>Sollwert</code> und <code>SI-Einheit</code> zwingend erforderlich!</p>
            </div>



            <button type="button" class="btn btn-sm btn-outline-secondary bentBackTab"
                    data-showtab="#nav-cianforderung-tab"
            >zurück</button>
            <button type="button" class="btn btn-sm btn-primary bentNextTab"
                    data-showtab="#nav-cicontact-tab"
            >weiter</button>
        </div>
        <div class="tab-pane fade" id="nav-cicontact" role="tabpanel" aria-labelledby="nav-cicontact-tab">
            <p class="lead text-primary">Legen Sie zum Abschluss fest, wer den Vorgang ausführen wird.</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="custom-control custom-radio custom-control-inline mb-3">
                        <input type="radio" id="aci_internal" name="aci_exinternal" class="custom-control-input" value="internal" checked>
                        <label class="custom-control-label" for="aci_internal">Interne Durchführung</label>
                    </div>
                    <x-selectfield id="aci_contact_id" label="Mitarbeiter">
                        @foreach (App\Profile::all() as $profile)
                            <option value="{{ $profile->id }}">{{ substr($profile->ma_vorname,0,1)}}. {{ $profile->ma_name }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-radio custom-control-inline mb-3">
                        <input type="radio" id="aci_external" name="aci_exinternal" class="custom-control-input" value="external">
                        <label class="custom-control-label" for="aci_external">Externe Durchführung</label>
                    </div>
                    <x-selectfield id="firma_id" label="Firma">
                        @foreach (App\Firma::all() as $firma)
                            <option value="{{ $firma->id }}">{{ $firma->fa_name_lang }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
            </div>
            <button class="btn btn-primary btn-block">Vorgang anlegen</button>
        </div>

    </div>
</form>

<script>
    $('.bentNextTab').click(function () {
        if($(this).data('showtab')==='#nav-cicontact-tab'){
            const aci_task = $('#aci_task');
            const aci_name = $('#aci_name');
            let flag = false;
            if (aci_task.val()===''|| aci_name.val()==='') {
                (aci_task.val()==='') ? aci_task.addClass('is-invalid') : aci_task.removeClass('is-invalid');
                (aci_name.val()==='') ? aci_name.addClass('is-invalid') : aci_name.removeClass('is-invalid');
                flag = false;
            } else {
                (aci_task.val()==='') ? aci_task.addClass('is-invalid') : aci_task.removeClass('is-invalid');
                (aci_name.val()==='') ? aci_name.addClass('is-invalid') : aci_name.removeClass('is-invalid');
                flag = true;
            }

            (aci_name.val()==='') ? aci_name.addClass('is-invalid') : aci_name.removeClass('is-invalid');
            if (flag)
                $($(this).data('showtab')).removeClass('disabled').tab('show');
        } else {
            $($(this).data('showtab')).removeClass('disabled').tab('show');
        }
    });

    $('#firma_id').change(function () {
        $('#aci_external').prop('checked',true);
    })

    $('#aci_contact_id').change(function () {
        $('#aci_internal').prop('checked',true);
    })

    $('.bentBackTab').click(function () {
        $($(this).data('showtab')).removeClass('disabled').tab('show');
    });

</script>
