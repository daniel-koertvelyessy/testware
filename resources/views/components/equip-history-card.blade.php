<dl class="row">
    <dt class="col-md-4 col-xl-3">{{ $logEntry->created_at->DiffForhumans() }}</dt>
    <dd class="col-md-8 col-xl-9">
        <a href="#logEntry{{ $logEntry->id }}"
           class="align-items-center d-flex justify-content-between pr-2 flex-md-row-reverse justify-content-md-end"
           data-toggle="collapse"
           role="button"
           aria-expanded="false"
           aria-controls="logEntry{{ $logEntry->id }}"
        >
            {{ $logEntry->eqh_eintrag_kurz }} <i class="fa-angle-down fas ml-2 ml-md-0 mr-md-2"></i>
        </a>
        <div class="collapse"
             id="logEntry{{ $logEntry->id }}"
        >
            {!! $logEntry->eqh_eintrag_text !!}
        </div>

    </dd>
</dl>
