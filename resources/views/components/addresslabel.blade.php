

<section {{ $attributes->merge([ 'class' => "list-group-item d-flex justify-content-between align-items-center"]) }}>
    <div>
        {{ $firma }}<br>
        <span class="small">{{ $address }}</span>
    </div>
    <form action="{{ route('removeFirmaFromProdukt') }}" method="post">
        @csrf
        @method('DELETE')
        <input type="hidden"
               name="firmaid"
               id="firmaid_{{ $firmaid }}"
               value="{{ $firmaid }}"
        >
        <input type="hidden"
               name="produktid"
               id="produktid_{{ $firmaid }}"
               value="{{ $produktid }}"
        >
        <a href="{{ route('firma.show',$firmaid) }}"
           class="btn btn-sm btn-outline-secondary"
        >
            <span class="fas fa-chevron-right"></span>
        </a>
        @can('isAdmin',Auth::user())
    <button class="btn btn-sm btn-outline-secondary btnRemoveFirmaFromProdukt">
        <span class="far fa-trash-alt"></span>
    </button>
            @endcan
    </form>
</section>



