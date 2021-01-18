
<div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="loc_id_{{$item->id}}">
    <div class="card" style="height:20em;">
        <div class="card-body">
            <h5 class="card-title">{{ $item->r_label }}</h5>
            <h6 class="card-subtitletext-muted">{{ $item->r_name }}</h6>
            <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
            <p class="mt-0" style="height:6em;">{{ Illuminate\Support\Str::limit($item->r_description,300) }}</p>
        </div>
        <div class="card-footer">
            <a href="{{$item->path()}}" class="card-link"><i class="fas fa-chalkboard"></i> Übersicht</a>
        </div>
    </div>
</div>
