@php
    $status = '';
@endphp
@auth
    @php
        $systemStatus = new \App\Http\Controllers\SystemStatusController();

        $dbstatus = $systemStatus->getBrokenDBLinks();
        $objects = $systemStatus->getObjectStatus();


        if ($dbstatus['totalBrokenLinks']>0){
            $status .= '<a href="'.route('admin.index').'"
           class="text-danger mr-2"
           title="'. __('Mindestens :num verwaiste Einträge gefunden',['num'=>$dbstatus['totalBrokenLinks']]).'"
        ><i class="fas fa-database"></i></a>';
        }

        $issueCounter = 0;
        if ($objects['equipment_qualified_user'] === 0 && $objects['equipment']>0) $issueCounter++;
        if ($objects['product_qualified_user'] === 0) $issueCounter++;
        if ($objects['regulations'] === 0) $issueCounter++;
        if ($objects['requirements'] === 0) $issueCounter++;
        if ($objects['requirements_items'] === 0) $issueCounter++;
        if ($objects['products'] === 0) $issueCounter++;
        if ($objects['control_products'] === 0) $issueCounter++;
        if ($objects['storages'] === 0) $issueCounter++;
        if ($objects['incomplete_equipment']>0 && $objects['equipment']>0 ) $issueCounter++;
        if ($objects['incomplete_requirement']>0 && $objects['requirements']>0 ) $issueCounter++;

        if($issueCounter>0){
            $statusMsg = ($issueCounter===1) ? __('Problem beheben') : __('Probleme beheben');

            if (
                $objects['incomplete_equipment']>0 && $objects['equipment']>0 ||
                $objects['incomplete_requirement']>0 && $objects['requirements']>0 ||
                $objects['equipment_qualified_user'] === 0 ||
                $objects['product_qualified_user'] === 0 ||
                $objects['regulations'] === 0 ||
                $objects['requirements'] === 0 ||
                $objects['requirements_items'] === 0 ||
                $objects['products'] === 0 ||
                $objects['control_products']===0 &&
                $objects['storages'] === 0
                )
                $status .= '<a href="'.route('admin.index').'" class="btn-warning p-1"><span class="font-bold mx-2">'
                . $issueCounter.'</span>'. $statusMsg .'</a>';

            if (
                $objects['storages']===0||
                $objects['products']===0
                )
                $status .= '<a href="'.route('admin.index').'" class="btn-danger p-1"><span class="font-bold mx-2">'.
                 $issueCounter.'</span>'. $statusMsg .'</a>';

        }
    @endphp
@endauth

<footer class="page-footer bg-light d-flex fixed-bottom align-items-center justify-content-between small">
    <div class="p-1">
        <span class="text-dark">
            © 2020 - {{ date('Y') }}
        <a href="https://bitpack.io/"
           title="bitpack.io"
           target="_blank"
        >
            <span style="color: #000000;">bitpack</span>
                <span style="color: #c7d301;">.io</span>
        </a>
        &nbsp; GmbH
        </span>
    </div>

    <div>
        {!! $status !!}
        <a href="{{ route('imprint') }}" class="mr-2">{{ __('Impressum') }}</a>
    </div>
</footer>
