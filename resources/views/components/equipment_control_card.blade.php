<div class="border rounded p-1 mb-1 d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column">
        <span class="small text-muted pl-2">
            {{$cei->deleted_at->diffForHumans()}}
        </span> <span class="p-2">
            {{ str_limit($cei->Anforderung->an_name,20) }}
        </span>
    </div>
    <div class="pr-2">
        <button type="button"
                class="btn btn-sm btn-outline-primary btnOpenControlEventModal"
                data-control-event-id="{{ \App\ControlEvent::where('control_equipment_id',$cei->id)->first()->id  }}"
        ><i class="far fa-folder-open"></i></button>
        <a href="{{ route('makePDFEquipmentControlReport',\App\ControlEvent::where('control_equipment_id',$cei->id)->first()->id ) }}"
           class="btn btn-sm btn-outline-primary"
           target="_blank"
        ><i class="far fa-file-pdf"></i></a>
    </div>
</div>
