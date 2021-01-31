@props([
    'title' => '',
    'methode' => 'GET',
    'modalId' => 'modal',
    'modalRoute' => '#',
    'btnClose' => __('Abbruch'),
    'btnSubmit' => __('Senden'),
    'modalType' => 'sd',
     'typeGBColor'=>[
            'warning' => 'bg-warning',
            'danger' => 'bg-danger text-white',
            'info' => 'bg-info',
    ],
    'typeBtnColor'=>[
            'warning' => 'btn-warning',
            'danger' => 'btn-danger',
            'info' => 'btn-info',
    ],
    'modalSize' => 'sd',
    'sizeClass' =>[
        'sm' => 'modal-sm',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        'sd' => '',
    ]
])


<div class="modal fade"
     id="{{$modalId}}"
     tabindex="-1"
     aria-labelledby="{{$modalId}}Label"
     aria-hidden="true"
>
    <div class="modal-dialog {{ $sizeClass[$modalSize] }}">
        <div class="modal-content">
            <form action="{{ $modalRoute }}"
                  method="{{$methode==='GET'?'GET':'POST'}}"
            >
                @if($methode!=='GET')  @method($methode) @endif
                @csrf
                <div class="modal-header  {{ $typeGBColor[$modalType] }}">
                    <h5 class="modal-title"
                        id="{{$modalId}}Label"
                    >
                        {{ $title }}
                    </h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-dismiss="modal"
                    >{{ $btnClose }}</button>
                    <button type="submit"
                            class="btn {{ $typeBtnColor[$modalType] }}"
                    >{{ $btnSubmit }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
