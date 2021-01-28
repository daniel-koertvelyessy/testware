<?php

namespace App\Http\Controllers;

use App\ProductInstructedUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductInstructedUserController extends Controller
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
        ProductInstructedUser::create($this->validateProductInstructedUser());
        $request->session()->flash('status', __('Die Unterweisung wurde angelegt!'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    : RedirectResponse
    {
        $request->session()->flash('status', __('Die Unterweisung wurde gelöscht!'));
        ProductInstructedUser::find($request->id)->delete();
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateProductInstructedUser()
    : array {
        return request()->validate([
            'product_instruction_date'                  => 'bail|required|date',
            'product_instruction_instructor_signature'  => '',
            'product_instruction_instructor_profile_id' => '',
            'product_instruction_instructor_firma_id'   => '',
            'product_instruction_trainee_signature'     => '',
            'product_instruction_trainee_id'            => 'required',
            'product_id'                                => 'required'
        ]);
    }
}
