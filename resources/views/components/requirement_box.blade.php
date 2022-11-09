@if($requirement)

    <div class="d-flex align-items-center justify-content-between px-2 mt-3">
        @if($requirement->AnforderungControlItem->count()>0)
            <span>{{ $requirement->an_label }}</span>
        @else
            <span class="text-warning"><span class="fas fa-fw fa-exclamation-triangle"></span> {{ $requirement->an_label }} </span>
        @endif
        <a data-toggle="collapse"
           href="#rbox-id-{{ $requirement->id }}"
           role="button"
           aria-expanded="false"
           aria-controls="rbox-id-{{ $requirement->id }}"
        >{{ __('Details') }}<span class="fas fa-angle-down ml-2"></span></a>
    </div>

    <div class="card p-2 mb-2 collapse"
         id="rbox-id-{{ $requirement->id }}"
    >
        <dl class="row lead">
            <dt class="col-md-5 col-lg-4">{{ __('Verordnung')}}</dt>
            <dd class="col-md-7 col-lg-8">{{ $requirement->Verordnung->vo_label }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-md-5 col-lg-4">{{__('Anforderung')}}</dt>
            <dd class="col-md-7 col-lg-8 ">
                {{ $requirement->an_label }}
            </dd>
        </dl>
        <dl class="row">
            <dt class="col-md-5 col-lg-4">{{ __('Bezeichnung')}}</dt>
            <dd class="col-md-7 col-lg-8">{{ $requirement->an_name }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-md-5 col-lg-4">{{ __('Intervall')}}</dt>
            <dd class="col-md-7 col-lg-8">
                {{ $requirement->an_control_interval }}
                {{ $requirement->ControlInterval->ci_label }}
            </dd>
        </dl>
        <dl class="row">
            <dt class="col-md-5 col-lg-4">{{ __('Beschreibung')}}</dt>
            <dd class="col-md-7 col-lg-8">{{ $requirement->an_description ?? '-' }}</dd>
        </dl>

        <x-rbox_control_items :requirement="$requirement"/>

        <nav class="border-top mt-2 pt-2 d-flex justify-content-end">
            <a href="{{ route('anforderung.show',$requirement) }}"
               class="btn btn-sm btn-outline-primary mr-2"
            >{{__('öffnen')}} <span class="fas fa-folder-open"></span>
            </a>
            @if(isset($produkt))
                <form action="{{ route('deleteProduktAnfordrung') }}#productRequirements"
                      method="post"
                >
                    @csrf
                    @method('DELETE')
                    <input type="hidden"
                           name="an_label"
                           id="an_label_delAnf_{{ $requirement->id }}"
                           value="{{ $requirement->an_label }}"
                    >
                    <input type="hidden"
                           name="id"
                           id="id_delAnf_{{ $requirement->id }}"
                           value="{{ $produktAnforderungId }}"
                    >
                    <input type="hidden"
                           name="produkt_id"
                           id="produkt_id_delAnf_{{ $requirement->id }}"
                           value="{{ $produkt->id }}"
                    >
                    <input type="hidden"
                           name="anforderung_id"
                           id="anforderung_id_delete_anforderung_{{ $requirement->id }}"
                           value="{{ $requirement->id }}"
                    >
                    <button
                            class="btn btn-sm btn-outline-primary"
                    >{{__('entfernen')}} <span class="fas fa-trash-alt"></span>
                    </button>
                </form>
            @endif
        </nav>

    </div>
@else

    <div class="alert alert-danger p-2 mb-2 border-danger">
        {{ __('Eine ehenmals verknüpfte Anforderung konnte nicht gefunden werden!') }}
    </div>
@endif