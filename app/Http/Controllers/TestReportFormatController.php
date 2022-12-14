<?php

namespace App\Http\Controllers;

use App\TestReportFormat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestReportFormatController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        $msg = (new TestReportFormat)->add($request) ?  __('Erfolgreich angelegt') : __('Fehler beim Anlegen');
        $request->session()->flash('status', $msg);
        return redirect()->route('systems');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request          $request
     * @param  TestReportFormat $testreportformat
     *
     * @return RedirectResponse
     */
    public function update(Request $request, TestReportFormat $testreportformat)
    : RedirectResponse
    {
        $msg = ($testreportformat->update($this->validateTestReportFormat())) ? __('Erfolgreich aktualisiert') : __('Fehler bei der Aktualisierung');

        $request->session()->flash('status', $msg);
        return redirect()->route('systems');
    }

    /**
     * @return array
     */
    public function validateTestReportFormat()
    : array
    {
        return request()->validate([
            'digits'  => 'numeric',
            'prefix'  => '',
            'postfix' => '',
        ]);
    }

}
