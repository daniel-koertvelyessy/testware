<dl class="row">
    <dt class="col-md-5 col-lg-4">
        {{ (App\AnforderungControlItem::where('anforderung_id',$anforderung->anforderung_id)->count()>1) ? __('Vorgänge') : __('Vorgang') }}
    </dt>
    <dd class="col-md-7 col-lg-8">
        <ul class="list-group">
            @forelse (App\AnforderungControlItem::where('anforderung_id',$anforderung->anforderung_id)->get() as $aci)
                <li class="list-group-item">
                    {{ $aci->aci_name }}
                </li>
            @empty
                <li class="list-group-item">
                    <x-notifyer>{{__('Keine Daten gefunden!')}}</x-notifyer>
                </li>
            @endforelse
        </ul>
    </dd>
</dl>
