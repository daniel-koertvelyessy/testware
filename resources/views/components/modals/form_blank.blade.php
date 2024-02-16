@props([
    'title' => '',
    'method' => 'GET',
    'modalId' => 'modal',
    'modalRoute' => '#',
    'btnClose' => __('Abbruch'),
    'btnSubmit' => __('Senden'),
    'modalType' => 'sd',
     'modalCenter' => '',
     'typeGBColor'=>[
            'warning' => 'text-warning',
            'danger' => 'text-danger',
            'info' => 'text-info',
            'sd'=>'',
    ],
    'typeBtnColor'=>[
            'warning' => 'btn-warning',
            'danger' => 'btn-danger',
            'info' => 'btn-info',
            'sd'=> 'btn-primary',
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
    <div class="modal-dialog {{ $sizeClass[$modalSize] }} {{ $modalCenter ? ' modal-dialog-centered ' :'' }}">
        <div class="modal-content">
            <div class="modal-header {{ $typeGBColor[$modalType] }}">
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
        </div>
    </div>
</div>