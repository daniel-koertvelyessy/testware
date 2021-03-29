<a href="#"
   class="getNoteData list-group-item list-group-item-action "
   data-note_id="{{ $note->id }}"
>
        <span class="d-flex align-items-center justify-content-between">
            <span class="d-flex flex-column">
            <span>{{ $note->label }}</span>
                <span>
                @foreach($note->tags()->get() as $tag)
                    <span class="badge badge-{{$tag->color}} mr-1">{{$tag->label}}</span>
                @endforeach
                @if($note->file_path!==null)
                    <span class="fas fa-file"></span>
                @endif
                @if($note->is_intern===1)
                    <span class="fas fa-shield-alt text-warning"></span>
                @endif
                </span>
            </span>
    <i class="fas fa-angle-right"></i>
        </span>
</a>

