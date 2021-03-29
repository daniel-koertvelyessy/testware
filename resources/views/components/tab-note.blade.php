<div class="tab-pane fade p-2"
     id="notes"
     role="tabpanel"
     aria-labelledby="notes-tab"
>
    <div class="row">
        <div class="col-lg-3">

            <div class="list-group">
                @forelse(App\Note::where('uid',$uid)->get() as $note)
                    <x-note-tag-item :note="$note"/>
                @empty
                    <a href="#"
                       class="list-group-item list-group-item-action disabled d-flex align-items-center justify-content-between"
                       tabindex="-1"
                       aria-disabled="true"
                    >
                        <span>{{__('Keine Notizen gefunden')}}</span> <i class="fas fa-info-circle"></i>
                    </a>
                @endforelse
                <button class="btn btn-primary mt-3"
                        data-toggle="modal"
                        data-target="#modalAddNote"
                >
                    {{ __('neu anlegen') }}
                </button>
            </div>
        </div>
        <div class="col-lg-9 pl-2 border-left border-light"
             id="note_details"
        >

        </div>
    </div>

</div>
