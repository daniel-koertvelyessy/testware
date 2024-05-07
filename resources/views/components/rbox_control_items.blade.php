
@php

$requirementControlItems = \App\AnforderungControlItem::where('anforderung_id',$requirement->id)->get();

@endphp
<dl class="row">
    <dt class="col-md-5 col-lg-4">
        {{ ($requirementControlItems->count()>1) ? __('Vorgänge') : __('Vorgang') }}
    </dt>
    <dd class="col-md-7 col-lg-8">
        <ul class="list-group">
            @forelse ($requirementControlItems as $requirementControlItem)
                <li class="list-group-item">
                    {{ $requirementControlItem->aci_name }}
                </li>
            @empty
                <li class="list-group-item list-group-item-warning">
                    <span class="fas fa-exclamation-triangle"></span>
                    {{__('Keine Daten gefunden!')}}
                    <a href="{{ route('anforderungcontrolitem.create',['rid'=>$requirement]) }}">{{ __('erstellen') }}</a>
                </li>
            @endforelse
        </ul>
    </dd>
</dl>
