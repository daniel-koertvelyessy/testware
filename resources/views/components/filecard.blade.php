


<div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
    <div>
    <span class="text-muted small">
        {{ str_limit($name) }}</span> <br> <span class="lead">{{ str_limit($label,50) }}</span><br> <span class="text-muted small">
        {{ App\helpers::fileSizeForHumans(\Illuminate\Support\Facades\Storage::size($path)) }}
    </span>
    </div>
    <div>
        <form action="{{ route('downloadProduktDokuFile') }}#dokumente"
              method="get"
              id="downloadBDA_{{ $id }}"
        >
            @csrf
            <input type="hidden"
                   name="id"
                   id="bda_{{ $id }}"
                   value="{{ $id }}"
            >
        </form>
        <button
            class="btn btn-lg btn-outline-primary"
            onclick="event.preventDefault(); document.getElementById('downloadBDA_{{ $id }}').submit();"
        >
            <span class="fas fa-download"></span>
        </button>
    </div>
</div>
