<div class="bg-white border d-flex flex-column my-2 rounded-sm"
     id="msg{{ $notification->id }}"
>
    <div class="d-flex mx-2 justify-content-between small mb-2">
        <span>{{__('Nachricht')}}: {{ $notification->data['header'] }}</span> <span>{{ $notification->created_at->DiffForHumans() }}</span>
    </div>
    <div class="d-flex mx-2 flex-column">
        <span class="small">{{__('Inhalt')}}:</span> <span class="lead"> {{ $notification->data['message'] }}</span>
    </div>
    <div class="align-items-center d-flex flex-row justify-content-between mx-2 mt-2">
        <span class="small">
                {{__('von')}}: <span class="text-info ml-1">{{ ($notification->data['userid']) ? App\User::find($notification->data['userid'])->first()->name : __('System')}}</span>
            </span>
        <a href="{{ route('event.read',['event'=>$notification->data['eventid'],'notification'=>$notification]) }}">{{ __('Details') }}</a>
    </div>

</div>
