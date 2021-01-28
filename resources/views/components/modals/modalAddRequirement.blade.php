<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"
                id="addQualifiedUserLabel"
            >{{__('Anforderung auswählen')}}</h5>
            <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('addProduktAnforderung') }}#productRequirements"
                  method="post"
            >
                @csrf
                <input type="hidden"
                       name="produkt_id"
                       id="produkt_id_anforderung"
                       value="{{ $produkt->id }}"
                >
                <x-selectfield id="anforderung_id"
                               label="Anforderung wählen"
                >
                    <option value="">{{__('bitte wählen')}}</option>
                    @foreach (App\Anforderung::all() as $anforderung)

                        <option value="{{ $anforderung->id }}"
                                @if($produkt->hasRequirement($anforderung)) disabled @endif
                        >{{ $anforderung->an_label }} @if($produkt->hasRequirement($anforderung)) [{{ __('zugeordnet') }}] @endif </option>

                    @endforeach
                </x-selectfield>
                <button
                        class="btn btn-primary btn-block mt-1"
                >{{__('Anforderung zuordnen')}}</button>
                <div class="card p-2 my-2"
                     id="produktAnforderungText"
                >
                    <x-notifyer>{{__('Details zu Anforderung')}}</x-notifyer>
                </div>
            </form>
            @error('anforderung_id')
            <div class="alert alert-dismissible fade show alert-info mt-5"
                 role="alert"
            >
                {{__('Bitte eine Anforderung auswählen!')}}
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @enderror
        </div>
    </div>
</div>
