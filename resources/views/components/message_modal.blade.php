<div class="d-flex border p-2 flex-column"
     id="msg{{ $notification->id }}"
>
    <div class="d-flex ml-2 justify-content-between small">
        <span>
            {{__('Nachricht')}}:
             {{ $notification->type === 'App\Notifications\EquipmentEventChanged' ? __('Änderung Ereignis') : __('Neues Ereignis') }}
        </span> <span>{{ $notification->created_at->DiffForHumans() }}</span>
    </div>
    <div class="align-items-center d-flex flex-row justify-content-between ml-2 mt-3">
        <span class="small">
                {{__('von')}}: <span class="text-info ml-1">{{ App\User::find($notification->data['userid'])->first()->name }}</span>
            </span>
        <a href="{{ $link }}">{{ $LinkName??__('Details') }}</a>
    </div>
    <div class="d-flex mt-3 ml-2 flex-column">
        <span class="small">{{__('Inhalt')}}:</span> <span class="lead"> {{ $notification->data['message'] }}</span>
    </div>
</div>