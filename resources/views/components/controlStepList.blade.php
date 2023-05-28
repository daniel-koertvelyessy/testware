<div class="row">
    <div class="col">

        <table class="table table-responsive-md table-borderless">

            @forelse (App\AnforderungControlItem::where('anforderung_id',$requirement->id)->orderBy('aci_sort')->get() as $aci)

                <tr>
                    <td colspan="4"
                        class="m-0 p-0"
                    >
                        <input type="hidden"
                               name="event_item[]"
                               id="event_item_{{ $aci->id }}"
                               value="{{ $aci->id }}"
                        >
                        <input type="hidden"
                               name="control_item_aci[{{ $aci->id }}][]"
                               id="control_item_aci_{{ $aci->id }}"
                               value="{{ $aci->id }}"
                        >
                        <span class="text-muted small">{{ __('Aufgabe / Ziel') }}:</span>
                        <br>
                        <span class="lead"> {{ $aci->aci_name }}</span>
                        <div class="dropdown d-md-none">
                            <button class="btn btn-sm btn-outline-primary"
                                    data-toggle="collapse"
                                    data-target="#taskDetails_{{ $aci->id }}"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="taskDetails_{{ $aci->id }}"
                            >
                                {{__('Details')}}
                            </button>
                            <div class="collapse"
                                 id="taskDetails_{{ $aci->id }}"
                            >
                                {{ $aci->aci_task }}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col"
                        class="d-none d-md-table-cell"
                    >{{__('Beschreibung der Prüfung')}}
                    </th>
                    <th scope="col"
                        colspan="2"
                    >{{__('Soll')}}
                    </th>
                    <th scope="col">{{__('Ist')}}</th>
                    <th scope="col">{{__('Bestanden')}}</th>
                </tr>
                <tr>
                    <td class="d-none d-md-table-cell">{{ $aci->aci_task }}</td>
                    <td style="min-width: 100px;"
                        class="pt-4"
                    >
                        @if($aci->aci_vaule_soll !== null)
                            <strong>{{ $aci->aci_vaule_soll }}</strong> {{ $aci->aci_value_si }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="pt-4">
                        @if($aci->aci_vaule_soll !== null)
                            <div class="d-flex flex-column">
                                @if($aci->aci_value_target_mode==='gt')
                                    <span class="fas fa-less-than mr-1"></span>
                                @elseif($aci->aci_value_target_mode==='lt')
                                    <span class="fas fa-greater-than mr-1"></span>
                                @elseif($aci->aci_value_target_mode==='eq')
                                    <span class="fas fa-equals mr-1"></span>
                                    <span class="text-nowrap">
                                                                @if($aci->aci_value_target_mode==='eq')
                                            @php
                                                $tol = ($aci->aci_value_tol_mod==='abs') ? $aci->aci_value_tol :  $aci->aci_vaule_soll*$aci->aci_value_tol;
                                            @endphp
                                            <span
                                                class="small">±{{ $tol }}{{ $aci->aci_value_si }}</span>
                                        @endif
                                                            </span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td style="min-width: 95px;"
                        class="px-0"
                    >
                        @if($aci->aci_vaule_soll !== null)
                            <label for="control_item_read_{{ $aci->id }}"
                                   class="sr-only"
                            >{{__('Ist-Wert')}}
                            </label>
                            <input type="text"
                                   placeholder="{{__('Wert')}}"
                                   class="form-control decimal checkSollValue"
                                   id="control_item_read_{{ $aci->id }}"
                                   name="control_item_read[{{ $aci->id }}][]"
                                   data-aci_id="{{ $aci->id }}"
                                   data-aci_vaule_soll="{{ $aci->aci_vaule_soll }}"
                                   data-aci_value_target_mode="{{ $aci->aci_value_target_mode??'' }}"
                                   data-aci_value_tol="{{ $aci->aci_value_tol??'' }}"
                                   data-aci_value_tol_mod="{{ $aci->aci_value_tol_mod??'' }}"
                                   required
                            >
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-toggle"
                             data-toggle="buttons"
                        >
                            <label class="btn btn-outline-success">
                                <input type="radio"
                                       id="aci_Passed_{{ $aci->id }}"
                                       name="control_item_pass[{{ $aci->id }}][]"
                                       value="1"
                                       class="checkControlItem itemPassed"
                                >
                                {{ __('JA')}}
                            </label>
                            <label class="btn btn-outline-danger">
                                <input type="radio"
                                       id="aci_notPassed_{{ $aci->id }}"
                                       name="control_item_pass[{{ $aci->id }}][]"
                                       value="0"
                                       class="checkControlItem itemFailed"
                                >
                                {{ __('NEIN')}}
                            </label>
                        </div>

                    </td>
                </tr>
                @if (!$loop->last)
                    <tr>
                        <td colspan="5"
                            class="m-0 p-0"
                        >
                            <div class="dropdown-divider"></div>
                        </td>
                    </tr>
                @endif
                {{-- @else
                     <tr>
                         <td>
                             <p>{!! __('Zum Ausführen des Vorgangs <span class="badge-info p-md-1">:name</span> fehlt Ihnen die benötigte Berechtigung!', ['name'=>$aci->aci_name]) !!}</p>
                             <p>{{ __('Brechtigte Personen:')}} {{ App\User::with('profile')->find($aci->aci_contact_id)->name }}</p>
                         </td>
                     </tr>
                 @endif--}}
            @empty
                <tr>
                    <td>
                        <x-notifyer>{{ __('Es konnten keine Prüfschritte für diese Anforderun gefunden werden!')
                        }}</x-notifyer>
                    </td>
                </tr>
            @endforelse
        </table>
    </div>
</div>
