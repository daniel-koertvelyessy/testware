<?php

namespace App\Http\Controllers;

use App\Lizenz;
use http\Env;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class LizenzController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $liz = Lizenz::where('lizenz_id',$request->lizenz_id)->first();
        $liz->lizenz_max_objects += $request->buyObjectAmount;
        $liz->save();


        Cache::forget('app-get-current-amount-Location');
        Cache::forget('app-get-current-amount-Product');
        Cache::forget('app-get-current-amount-Room');
        Cache::forget('app-get-current-amount-Stellplatz');
        Cache::forget('app-get-current-amount-Equipment');

        return redirect()->back();

    }


}
