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


<div class="{{ $bgcolor[$type] }} d-flex align-items-center justify-content-between p-2 mb-4">
    <div>
        <span class="{{ $icon[$type] }}  mr-2"></span> <span>{{ $msg }}</span>
    </div>
    @if($link!=='')
        <a href="{{ $link }}"
           class="btn btn-sm {{ $btnclass[$type] }}"
        >{{ $labelBtn }}</a>
    @else
        <span class="btn btn-success btn-sm">{{ $counter }}</span>
    @endif
</div>
