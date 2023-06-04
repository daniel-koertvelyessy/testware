<form action="{{ route('anforderungcontrolitem.store') }}"
      method="POST"
      name="frmAddNewAnforderungControlItem"
      id="frmAddNewAnforderungControlItem"
>
    @csrf
    <input type="hidden"
           name="anforderung_id"
           id="anforderung_id"
           value="{{ $rid??'' }}"
    >
    <div class="tab-content"
         id="nav-tabContent"
    >
        <nav>
            <div class="nav nav-tabs"
                 id="nav-tab"
                 role="tablist"
            >
                <a class="nav-link active"
                   id="nav-cianforderung-tab"
                   data-toggle="tab"
                   href="#nav-cianforderung"
                   role="tab"
                   aria-controls="nav-cianforderung"
                   aria-selected="true"
                >{{__('Anforderung')}}</a>
                <a class="nav-link disabled"
                   id="nav-cicontrol-tab"
                   data-toggle="tab"
                   href="#nav-cicontrol"
                   role="tab"
                   aria-controls="nav-cicontrol"
                   aria-selected="false"
                >{{__('Umfang')}}</a>
            </div>
        </nav>
        <div class="tab-content"
             id="nav-tabContent"
        >
            <div class="tab-pane fade show active p-2"
                 id="nav-cianforderung"
                 role="tabpanel"
                 aria-labelledby="nav-cianforderung-tab"
            >
                <div class="row">
                    <div class="col-md-8">
                        <p class="lead text-primary">{{__('Wählen Sie als erstes die Anforderung aus, welche dem Prüfschritt zugeordnet werden soll.')}}</p>

                        <x-selectfield id="anforderung_id_modal"
                                       name="anforderung_id"
                                       label="{{__('Anforderung')}}:"
                        >
                            @foreach (App\Anforderung::select('id', 'an_name')->get() as $anforderung)
                                <option value="{{ $anforderung->id }}"
                                        @if($rid == $anforderung->id) selected @endif>{{ $anforderung->an_name }}</option>
                            @endforeach
                        </x-selectfield>
                    </div>
                    <div class="col-md-4">
                        <p class="lead text-primary">{{__('Wählen Sie die Position, nachdem der Prüfschritt erfolgen soll.')}}</p>
                        <section id="acilist" class="mt-3"> @php $pos = 0; @endphp
                            @if(isset($rid ))
                                @forelse(\App\Anforderung::find($rid)->AnforderungControlItem()->orderBy('aci_sort')->get() as $aci)
                                    @php $pos = $pos + 5; @endphp

                                    <input type="hidden"
                                           name="sort[]"
                                           id="{{ $aci->id }}"
                                           value="{{ $aci->aci_sort??$pos}}"
                                    >
                                    <label for="placeafteritem{{ $aci->id }}" class="placeafteritem border border-primary px-2 py-1 rounded w-100 btn-outline-primary d-flex justify-content-between align-items-center" data-sort="{{ $aci->aci_sort??$pos }}">
                                    <span>
                                        <input type="radio"
                                               name="placeafteritem"
                                               id="placeafteritem{{ $aci->id }}"
                                               value="{{ $aci->aci_sort??$pos}}"
                                               {{ $loop->last ? ' checked ' :'' }}
                                    >
                                    <span class="ml-3">{{ $aci->aci_label }}</span>
                                    </span>
                                        <span>{{ $aci->aci_sort??$pos}}</span>
                                    </label>
                                @empty
                                    @php $pos = 5; @endphp
                                @endforelse
                            @else
                            @forelse(\App\Anforderung::select('id')->first()->AnforderungControlItem()->orderBy('aci_sort')->get() as $aci)
                                @php $pos = $pos + 5; @endphp

                                <input type="hidden"
                                       name="sort[]"
                                       id="{{ $aci->id }}"
                                       value="{{ $aci->aci_sort??$pos}}"
                                >
                                <label for="placeafteritem{{ $aci->id }}" class="placeafteritem border border-primary px-2 py-1 rounded w-100 btn-outline-primary d-flex justify-content-between align-items-center" data-sort="{{ $aci->aci_sort??$pos }}">
                                    <span>
                                        <input type="radio"
                                           name="placeafteritem"
                                           id="placeafteritem{{ $aci->id }}"
                                           value="{{ $aci->aci_sort??$pos}}"
                                               {{ $loop->last ? ' checked ' :'' }}
                                    >
                                    <span class="ml-3">{{ $aci->aci_label }}</span>
                                    </span>
                                    <span>{{ $aci->aci_sort??$pos}}</span>
                                </label>
                            @empty
                                @php $pos = 5; @endphp
                            @endforelse
                            @endif
                            <input type="hidden"
                                   name="aci_sort"
                                   id="aci_sort"
                                   value="{{ $pos }}"
                            >

                        </section>
                    </div>
                </div>

                <button type="button"
                        class="btn btn-sm btn-primary bentNextTab mt-5"
                        data-showtab="#nav-cicontrol-tab"
                >{{__('weiter')}}</button>
            </div>
            <div class="tab-pane fade p-2"
                 id="nav-cicontrol"
                 role="tabpanel"
                 aria-labelledby="nav-cicontrol-tab"
            >
                <p class="lead text-primary">{{__('Vergeben Sie Namen und Kürzel für den neuen Prüfschritt.')}}</p>
                <div class="row">
                    <div class="col-md-4">
                        <x-rtextfield id="aci_label"
                                      label="{{__('Kürzel')}}:"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-rtextfield id="aci_name"
                                      label="{{__('Name')}}:"
                                      max="150"
                        />
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
                <p class="lead text-primary my-3">{{__('Legen Sie nun den Umfang des Prüfschritts fest.')}}</p>
                <x-textarea id="aci_task"
                            label="{{__('Aufgabe')}}:"
                />

                <div class="row">
                    <div class="col-md-2">
                        <x-textfield id="aci_value_si"
                                     label="{{__('SI-Einheit')}}:"
                                     max="10"
                        />
                    </div>
                    <div class="col-md-3">
                        <x-textfield id="aci_vaule_soll"
                                     label="{{__('Sollwert')}}:"
                                     class="decimal"
                        />
                    </div>
                    <div class="col-md-3">
                        <x-selectfield id="aci_value_target_mode"
                                       label="{{__('Zielwert i.O.')}}:"
                        >
                            <option @if(old('aci_value_target_mode') ==='lt') selected
                                    @endif value="lt"
                            >{{__('Kleiner als Soll')}}</option>
                            <option @if(old('aci_value_target_mode') ==='eq') selected
                                    @endif value="eq"
                            >{{__('Gleich ± Toleranz')}}</option>
                            <option @if(old('aci_value_target_mode') ==='gt') selected
                                    @endif value="gt"
                            >{{__('Größer als Soll')}}</option>
                            <option @if(old('aci_value_target_mode') ===NULL) selected
                                    @endif value=""
                            >{{__('Prüfschritt ohne Zielwert')}}</option>
                        </x-selectfield>
                    </div>
                    <div class="col-md-2">
                        <x-textfield id="aci_value_tol"
                                     label="± {{__('Toleranz')}}:"
                                     class="decimal"
                        />
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="aci_value_tol_mod_abs"
                                   name="aci_value_tol_mod"
                                   class="custom-control-input"
                                   value="abs"
                                {{ old('aci_value_tol_mod') === 'abs'? ' checked ' :'' }}
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
                                {{ old('aci_value_tol_mod') === 'pro'? ' checked ' :'' }}
                            >
                            <label class="custom-control-label"
                                   for="aci_value_tol_mod_pro"
                            >%
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card p-3 my-4">
                    {!! __('<p>Die Felder <code>Sollwert</code> und <code>SI-Einheit</code> können leer gelassen werden. In diesem Fall wird ein einfacher Entscheidungsschalter generiert. Dieser speichert, ob die oben beschriebene Aufgabe erfült wurde oder nicht.</p><p>Soll ein Messwert abgelesen werden sind die Angaben <code>Sollwert</code> und <code>SI-Einheit</code> zwingend erforderlich!</p>') !!}
                </div>
                <button type="button"
                        class="btn btn-sm btn-outline-secondary bentBackTab"
                        data-showtab="#nav-cianforderung-tab"
                >{{__('zurück')}}</button>
                <x-btnMain block="1" >{{__('Prüfschritt anlegen')}} <i class="fas fa-download ml-2"></i></x-btnMain>

            </div>

        </div>
    </div>
</form>

<script>

    $('#anforderung_id_modal').change(function () {


        $.ajax({
            type: "get",
            // dataType: 'json',
            url: "{{ route('anforderungcontrolitemlistitems') }}",
            data: {id: $('#anforderung_id_modal').val()},
            success: function (res) {
                console.log(res);

                $('.placeafteritem').remove();
                $('#acilist').append(res);
            }
        });
    });

    $('.placeafteritem').click(function () {
        let sort = $(this).data('sort')*1;
        $('#aci_sort').val(sort +1);
    });


    $('#firma_id').change(function () {
        $('#aci_external').prop('checked', true);
    })

    $('#aci_contact_id').change(function () {
        $('#aci_internal').prop('checked', true);
    })


</script>
