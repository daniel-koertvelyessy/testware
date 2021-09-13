<dl class="row">
    <dt class="col-sm-3 d-flex flex-column border-right">
        <span class="d-flex align-items-center justify-content-between">
            <strong>{{__('eröffnet')}}:</strong>
            <span class="lead">{{ $equipmentEvent->created_at->DiffForhumans() }}</span>
        </span>
        <span class="d-flex align-items-center justify-content-between mt-md-4 mt-2">
             <strong>{{__('geschlossen')}}:</strong>
        @if ($equipmentEvent->deleted_at)
                {{ $equipmentEvent->deleted_at->DiffForhumans() }}
            @else
                -
            @endif
        </span>

        @if ($equipmentEvent->deleted_at)
            <form action="{{ route('event.restore') }}"
                  method="post"
            >
                @csrf
                <input type="hidden"
                       name="id"
                       id="id_equipment_event_{{ $equipmentEvent->id }}"
                       value="{{ $equipmentEvent->id }}"
                >
                <button class="btn btn-sm btn-outline-primary mt-2">{{__('wiederherstellen')}}</button>
            </form>
        @else
            <a href="{{ route('event.show',$equipmentEvent) }}"
               class="btn btn-sm btn-outline-primary mt-md-4 mt-2"
            >{{__('Ereignis öffnen')}}
            </a>
        @endif

    </dt>
    <dd class="col-sm-9">
        <span class="lead">{{ __('Meldung:') }}</span><br>
        {{ $equipmentEvent->equipment_event_text??__('keine Information übermittelt') }}
    </dd>
</dl>
@if (!$loop->last)
    <div class="dropdown-divider my-2"></div>
@endif
