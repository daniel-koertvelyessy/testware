<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.organisation.contact.index', [
            'contacts' => Contact::with('firma')->sortable()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $company_id = (isset($request->c)) ? $request->c : '';

        return view('admin.organisation.contact.create', ['company_id' => $company_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $contact = Contact::create($this->validateContact());
        $request->session()->flash('status', __('Kontakt wurde erstellt'));

        return redirect(route('contact.show', compact('contact')));
    }

    public function validateContact(): array
    {
        return request()->validate([
            'con_label' => [
                'bail',
                'max:100',
                'required',
                Rule::unique('contacts')->ignore(request('id')),
            ],
            'con_name' => [
                'bail',
                'max:100',
                'required',
                Rule::unique('contacts')->ignore(request('id')),
            ],
            'con_name_2' => '',
            'con_vorname' => '',
            'con_position' => '',
            'con_email' => 'email',
            'con_telefon' => '',
            'con_mobil' => '',
            'con_fax' => '',
            'con_com_1' => '',
            'con_com_2' => '',
            'firma_id' => 'required',
            'anrede_id' => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     *
     * @return Application|Factory|Response|View
     */
    public function show(Contact $contact)
    {
        return view('admin.organisation.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Contact $contact, Request $request): RedirectResponse
    {
        $contact->update($this->validateContact());
        $request->session()->flash('status', __('Kontakt wurde aktualisiert'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        request()->session()->flash('status', __('Der Kontakt <strong>:label</strong> wurde gelöscht!', ['label' => $contact->con_name]));
        $contact->delete();

        return redirect()->route('contact.index');

    }
}
