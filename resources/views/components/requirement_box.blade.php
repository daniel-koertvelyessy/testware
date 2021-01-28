<div class="card p-2 mb-2">
    <dl class="row lead">
        <dt class="col-md-5 col-lg-4">{{ __('Verordnung')}}</dt>
        <dd class="col-md-7 col-lg-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_label }}</dd>
    </dl>
    <dl class="row">
        <dt class="col-md-5 col-lg-4">{{__('Anforderung')}}</dt>
        <dd class="col-md-7 col-lg-8 ">
            {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_label }}
        </dd>
    </dl>
    <dl class="row">
        <dt class="col-md-5 col-lg-4">{{ __('Bezeichnung')}}</dt>
        <dd class="col-md-7 col-lg-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name }}</dd>
    </dl>
    <dl class="row">
        <dt class="col-md-5 col-lg-4">{{ __('Intervall')}}</dt>
        <dd class="col-md-7 col-lg-8">
            {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
            {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_label }}
        </dd>
    </dl>
    <dl class="row">
        <dt class="col-md-5 col-lg-4">{{ __('Beschreibung')}}</dt>
        <dd class="col-md-7 col-lg-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_description ?? '-' }}</dd>
    </dl>
    <dl class="row">
        <dt class="col-md-5 col-lg-4">
            {{ (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->count()>1) ? __('Vorgänge') : __('Vorgang') }}
        </dt>
        <dd class="col-md-7 col-lg-8">
            <ul class="list-group">
                @forelse (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->get() as $aci)
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
</div>
