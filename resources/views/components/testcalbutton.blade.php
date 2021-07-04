<?php
$n = \App\ControlEquipment::where('qe_control_date_due',$date)->count();
?>
@if($n>0)
<button class="btn btn-sm btn-outline-primary">
    <span class="fas fa-stethoscope"></span>
    <span class="badge badge-info ml-2">{{ $n }}</span>
</button>
@endif
