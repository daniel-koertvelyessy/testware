
<div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="loc_id_{{ $object->id }}">
    <div class="card" style="height:20em;">
        <div class="card-body">
            <h5 class="card-title">{{ $object->l_label }}</h5>
            <h6 class="card-subtitletext-muted">{{ $object->l_name }}</h6>
            <p class="card-text mt-1 mb-0"><small><strong>{{ __('Gebäude') }}:</strong> {{ $object->Building->count() }}</small></p>
            <p class="card-text mt-1 mb-0"><small><strong>{{ __('Geräte') }}:</strong> {{ $object->countTotalEquipmentInLocation() }}</small></p>
            <p class="card-text mt-1 mb-0"><small><strong>{{ __('Beschreibung') }}:</strong></small></p>
            <p class="mt-0" style="height:6em;overflow-y: scroll">{{ $object->l_beschreibung }}</p>

        </div>
        <div class="card-footer d-flex align-items-center">
            <a href="{{ $object->path() }}" class="btn btn-link btn-sm mr-auto"><i class="fas fa-chalkboard"></i> {{ __('Übersicht') }}</a>
        </div>
    </div>
</div>
