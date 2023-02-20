@props([
    'msg' => '',
     'type'=>'info',
     'labelBtn'=>__('beheben'),
     'icon' => [
         'pass'=>'fas fa-check-circle',
         'warning'=>'fas fa-exclamation-circle',
         'danger'=>'fas fa-exclamation-triangle',
         'info'=>'fas fa-info-circle',
],
     'bgcolor'=>[
            'pass' => 'list-group-item-success',
            'warning' => 'list-group-item-warning',
            'danger' => 'list-group-item-danger',
            'info' => 'list-group-item-info',
    ],
        'btnclass'=>[
            'pass' => 'btn-outline-success',
            'warning' => 'btn-outline-warning',
            'danger' => 'btn-outline-danger',
            'info' => 'btn-outline-info',
    ],

    'link'=>'',
    'counter' => 0
])


<div class="{{ $bgcolor[$type] }} d-flex align-items-center justify-content-between p-1 mb-3">
    <div>
        <span class="{{ $icon[$type] }}  mr-2"></span> <span>{{ $msg }}</span>
    </div>
    @if($counter===0)
        <a href="{{ $link }}"
           class="btn btn-sm ml-1 {{ $btnclass[$type] }}"
        >{{ $labelBtn }}</a>
    @endif
    @if($counter>0)
        <a href="{{ $link }}"
           class="btn btn-sm ml-1 {{ $btnclass[$type] }}"
        >
            <span class="small">{{ $counter }}</span>
        </a>
    @endif
</div>
