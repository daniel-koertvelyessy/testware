<div class="col-md-6 col-lg-3">
    <div class="alert alert-{{ $status }} alert-dismissible fade show" role="alert">
        <strong>{{__('Hinweis!')}}</strong>
        <p class="lead">{{ $message }}</p>
        <a href="{{ $link }}" class="btn btn-light text-primary">{{ $linklabel }}</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
