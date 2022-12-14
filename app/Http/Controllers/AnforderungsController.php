<?php

    namespace App\Http\Controllers;

    use App\Anforderung;
    use App\AnforderungControlItem;
    use App\AnforderungObjekt;
    use Exception;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Redirector;
    use Illuminate\View\View;

    class AnforderungsController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth');
        }

        static function getACI($anforderung_id)
        {
            return AnforderungControlItem::where('anforderung_id', $anforderung_id)->get();
        }

        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|Response|View
         */
        public function index()
        {
            return view('admin.verordnung.anforderung.index', [
                'requirements' => Anforderung::with('ControlInterval')->sortable()->paginate(10)
            ]);

        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Application|Factory|Response|View
         */
        public function create()
        {
            return view('admin.verordnung.anforderung.create');
        }

        /**
         *  Speichere neue Anforderung
         *
         * @param Request $request
         *
         * @return Application|RedirectResponse|Response|Redirector
         */
        public function store(Request $request)
        {
            $request->is_initial_test = $request->has('is_initial_test');
            Anforderung::create($this->validateAnforderung());
            $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_label') . '</strong> wurde angelegt!');
            return back();
        }

        /**
         * Display the specified resource.
         *
         * @param Anforderung $anforderung
         *
         * @return Application|Factory|Response|View
         */
        public function show(Anforderung $anforderung)
        {
            return view('admin.verordnung.anforderung.show', ['anforderung' => $anforderung]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param Request $request
         * @param Anforderung $anforderung
         *
         * @return RedirectResponse
         */
        public function update(Request $request, Anforderung $anforderung)
        {
            $anforderung->is_initial_test = $request->has('is_initial_test')?1:0; //?1:0;

            if ($anforderung->update($this->validateAnforderung($request))) {
                session()->flash('status', __('Die Anforderung <strong>:name</strong> wurde aktualisert!', ['name' => $anforderung->an_name]));
            }

            return back();
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Anforderung $anforderung
         *
         * @return RedirectResponse
         * @throws Exception
         */
        public function destroy(Anforderung $anforderung)
        {
            $anforderung->delete();
            session()->flash('status', 'Die Anforderung wurde gel??scht!');
            return redirect()->back();
        }

        /**
         * @return array
         */
        public function validateAnforderung(Request $request): array
        {

           // dd($request);
            return $request->validate([
                'an_label'            => 'bail|required|max:20',
                'an_name'             => 'bail|max:100',
                'an_description'      => '',
                'an_control_interval' => 'integer',
                'control_interval_id' => 'integer',
                'verordnung_id'       => 'integer',
                'an_date_warn'        => '',
                'warn_interval_id'    => 'integer',
           //     'is_initial_test'     => '',
                'anforderung_type_id' => 'bail|required|integer',
            ],
                [
                    'an_label.required' => __('Bitte ein Label f??r die Anforderung vergeben.'),
                    'an_label.max'      => __('Das Label darf maximal 20 Zeichen lang sein.')
                ]);
        }


        /**
         * @return array
         */
        public function validateObjektAnforderung(): array
        {
            return request()->validate([
                'storage_uid'    => 'required',
                'anforderung_id' => 'required',
            ]);
        }


        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function storeAnObjekt(Request $request)
        {
            AnforderungObjekt::create($this->validateObjektAnforderung());
            $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_label') . '</strong> wurde zugewiesen!');
            return back();
        }
    }
