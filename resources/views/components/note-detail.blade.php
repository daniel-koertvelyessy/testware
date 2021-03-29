<div>
    <div>
        <span class="small mr-2">{{ __('von:') }}<strong> {{$note->user->name}}</strong> </span>
        <span class="small mr-2">{{ __('erstellt:') }} <strong>{{$note->created_at->diffForHumans()}}</strong></span>
        <span class="small">{{ __('geändert:') }} <strong>{{$note->updated_at->diffForHumans()}}</strong></span>
    </div>

    @foreach($note->tags()->get() as $tag)
        <span class="badge badge-{{$tag->color}} mr-1">{{$tag->label}}</span>
    @endforeach

    <h2 class="h4 my-2">{{$note->label}}</h2>
    <p>{{$note->description}}</p>
</div>

@if($note->file_name !==null)
    <a href="/notes/file/{{ $note->id }}" download target="_blank" class="btn btn-sm btn-outline-info">
    <span class="fas fa-file mr-1"></span>
        {{ $note->file_name }}
    </a>
@endif

@if (\Auth::user()->id === $note->user_id)
    <div class="mt-4">
        <form action="{{ route('note.destroy',$note) }}"
              method="post"
        >
            @csrf
            @method('delete')
            <button type="button"
                    class="btn btn-sm btn-outline-primary mr-1 editNote"
                    data-id="{{$note->id}}"
            >
                {{ __('bearbeiten') }}
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger deleteNote"
                    data-id="{{$note->id}}"
            >
                {{ __('löschen') }}
                <i class="far fa-trash-alt"></i>
            </button>
        </form>

    </div>
@endif
