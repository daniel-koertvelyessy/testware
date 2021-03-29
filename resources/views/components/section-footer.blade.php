@php
    $status = '';
@endphp
@auth
    @php
        $system = \App\Http\Controllers\AdminController::getSystemStatus();
        $issueCounter = 0;
        if ($system['equipment_qualified_user'] === 0 && $system['equipment']>0) $issueCounter++;
        if ($system['product_qualified_user'] === 0) $issueCounter++;
        if ($system['regulations'] === 0) $issueCounter++;
        if ($system['requirements'] === 0) $issueCounter++;
        if ($system['requirements_items'] === 0) $issueCounter++;
        if ($system['products'] === 0) $issueCounter++;
        if ($system['control_products'] === 0) $issueCounter++;
        if ($system['storages'] === 0) $issueCounter++;
        if ($system['incomplete_equipment']>0 && $system['equipment']>0 ) $issueCounter++;
        if ($system['incomplete_requirement']>0 && $system['requirements']>0 ) $issueCounter++;

        if($issueCounter>0){
            $statusMsg = ($issueCounter===1) ? __('Problem beheben') : __('Probleme beheben');

            if (
                $system['incomplete_equipment']>0 && $system['equipment']>0 ||
                $system['incomplete_requirement']>0 && $system['requirements']>0 ||
                $system['equipment_qualified_user'] === 0 ||
                $system['product_qualified_user'] === 0 ||
                $system['regulations'] === 0 ||
                $system['requirements'] === 0 ||
                $system['requirements_items'] === 0 ||
                $system['products'] === 0 ||
                $system['control_products']===0 &&
                $system['storages'] === 0
                )
                $status = '<a href="'.route('admin.index').'" class="btn-warning p-1"><span class="font-bold mx-2">'. $issueCounter.'</span>'. $statusMsg .'</a>';

            if (
                $system['storages']===0||
                $system['products']===0
                )
                $status = '<a href="'.route('admin.index').'" class="btn-danger p-1"><span class="font-bold mx-2">'. $issueCounter.'</span>'. $statusMsg .'</a>';

        }
    @endphp
@endauth

<footer class="page-footer d-flex fixed-bottom align-items-center justify-content-between small">
    <div class="p-1">
        <span class="text-dark">
            © 2020
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
    </div>
</footer>
