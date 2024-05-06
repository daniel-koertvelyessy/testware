@php
$controlEvent = \App\ControlEvent::where('control_equipment_id',$cei->id)->first();
$id = $controlEvent->id;
 @endphp
<div class="border rounded p-1 mb-1 d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column">
        <span class="small text-muted pl-2">
            {{$cei->deleted_at->diffForHumans()}}
        </span>
        <span class="p-2" title="{{ $cei->Anforderung->an_name }}">
            {{ str_limit($cei->Anforderung->an_name,20) }}
        </span>
    </div>
    <div class="pr-2 d-flex justify-content-between align-items-center">
        <button type="button"
                class="btn btn-sm btn-outline-primary btnOpenControlEventModal mr-1"
                data-control-event-id="{{ $id  }}"
        ><i class="far fa-folder-open"></i></button>
        <a href="{{ route('makePDFEquipmentControlReport', $id) }}"
           class="btn btn-sm btn-outline-primary mr-1"
           target="_blank"
        ><i class="far fa-file-pdf"></i></a>
        @if($isSysAdmin)
            <button type="button"
                    class="btn btn-sm btn-outline-danger mr-1"
                    data-toggle="modal"
                    data-target="#deleteControlItemModal{{$cei->id}}"
            ><i class="far fa-trash-alt"></i></button>
        @endcan
    </div>
</div>
@if($isSysAdmin)
    <div class="modal fade"
         id="deleteControlItemModal{{$cei->id}}"
         tabindex="-1"
         aria-labelledby="deleteControlItemModalLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('control.destroy',$cei) }}"
                      method="POST"
                >
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"
                            id="deleteControlItemModalLabel{{$cei->id}}"
                        ><i class="far fa-trash-alt
                    mr-1"
                            ></i>{{ __('Löschen bestätigen') }}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{__('Bitte bestätigen Sie die Löschung der Prüfung. Alle referenzierten Dokumente werden ebenfalls gelöscht.') }}</p>
                        <p class="lead">{{ __('Dieser Vorgang kann nicht wieder rückgängig gemacht werden.') }}</p>
                        @csrf
                        @method('DELETE')
                        <input type="hidden"
                               name="id"
                               id="deleteControlItemid{{$cei->id}}"
                               value="{{$cei->id}}"
                        >


                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                        >{{ __('Abbruch') }}</button>
                        <button class="btn btn-danger"
                        >{{ __('Endgültig löschen') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endif
