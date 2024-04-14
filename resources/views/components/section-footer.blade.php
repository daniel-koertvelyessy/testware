@php
    $status = '';
@endphp
@auth
    @php
        $systemStatus = new \App\Http\Controllers\SystemStatusController();

        $dbstatus = $systemStatus->getBrokenDBLinks();
        $objects = $systemStatus->getObjectStatus();

        if (array_sum($dbstatus)>0){
            $status .= '<a href="'.route('admin.index').'"
           class="text-danger mr-2"
           title="'. __('Mindestens :num verwaiste/fehlerhafte Einträge in der Datenbank gefunden',['num'=>array_sum($dbstatus)]).'"
        ><i class="fas fa-database"></i></a>';
        }
        $issueCounter = 0;

        if ($objects['foundExpiredControlEquipment']) $issueCounter++;
        if ($objects['equipment_qualified_user'] === 0 && $objects['equipment']>0) $issueCounter++;
        if ($objects['product_qualified_user'] === 0) $issueCounter++;
        if ($objects['regulations'] === 0) $issueCounter++;
        if ($objects['requirements'] === 0) $issueCounter++;
        if ($objects['requirements_items'] === 0) $issueCounter++;
        if ($objects['products'] === 0) $issueCounter++;
        if ($objects['control_equipment'] == 0) $issueCounter++;
        if ($objects['control_products'] == 0) $issueCounter++;
        if ($objects['storages'] === 0) $issueCounter++;
        if ($objects['incomplete_equipment']>0 && $objects['equipment']>0 ) $issueCounter++;
        if ($objects['incomplete_requirement']>0 && $objects['requirements']>0 ) $issueCounter++;

        if($issueCounter>0){
            $statusMsg = ($issueCounter===1) ? __('Problem beheben') : __('Probleme beheben');
            if (
                $objects['incomplete_equipment']>0 && $objects['equipment']>0
               || $objects['foundExpiredControlEquipment']
               || $objects['incomplete_requirement']>0 && $objects['requirements']>0
               || $objects['equipment_qualified_user'] === 0
               || $objects['product_qualified_user'] === 0
               || $objects['regulations'] === 0
               || $objects['requirements'] === 0
               || $objects['requirements_items'] === 0
               || $objects['products'] === 0
               || $objects['control_equipment'] == 0
               || $objects['control_products']===0
               && $objects['storages'] === 0
                )
                $status .= '<a href="'.route('admin.index').'" title="'. $issueCounter.' '. $statusMsg .'" class="text-warning px-1"><i class="fa fa-exclamation-circle"></i></a>';

            if (
                $objects['storages']===0
                || $objects['products']===0
                )
               $status .= '<a href="'.route('admin.index').'" title="'. $issueCounter.' '. $statusMsg .'" class="text-danger px-1"><i class="fa fa-exclamation-circle"></i></a>';
        }
    @endphp
@endauth
<footer class="page-footer bg-light d-flex fixed-bottom align-items-center justify-content-between small">
    <div class="p-1">
        <span class="text-dark">
            ©
        <a href="https://thermo-control.com"
           title="thermo-control Körtvélyessy GmbH"
           target="_blank"
           class="text-dark"
        >
            thermo-control Körtvélyessy GmbH
        </a>
        </span>
    </div>

    <div>
        {!! $status !!}
        <a href="{{ route('imprint') }}"
           class="mx-1"
        >{{ __('Impressum') }}</a>
        <a href="https://github.com/daniel-koertvelyessy/testware"
           class="mx-1"
           target="_blank"
           title="participate on github"
        >
            <i class="fab fa-github"></i>
        </a>
    </div>
</footer>
