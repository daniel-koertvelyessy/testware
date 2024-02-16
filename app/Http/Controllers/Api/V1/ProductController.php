<?php

namespace App\Http\Controllers\Api\V1;

use App\Equipment;
use App\EquipmentQualifiedUser;
use App\Firma;
use App\FirmaProdukt;
use App\Http\Controllers\Controller;
use App\Http\Resources\products\Product as ProductResource;
use App\Http\Resources\products\ProductFull as ProductFullResource;
use App\Http\Resources\products\ProductShow as ProductShowResource;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktKategorie;
use App\ProduktState;
use App\Profile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return ProductResource::collection(Produkt::with('ProduktKategorie', 'ProduktState', 'ProduktParam', 'ProduktAnforderung', 'firma', 'Equipment', 'ControlProdukt')->paginate($request->input('per_page')));
        }
        return ProductResource::collection(Produkt::with('ProduktKategorie', 'ProduktState', 'ProduktParam', 'ProduktAnforderung', 'firma', 'Equipment', 'ControlProdukt')->get());
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function full(Request $request)
    {
        if ($request->input('per_page')) {
            return ProductFullResource::collection(Produkt::with('ProduktKategorie', 'ProduktState', 'ProduktParam', 'ProduktAnforderung', 'firma', 'Equipment', 'ControlProdukt')->paginate($request->input('per_page')));
        }
        return ProductFullResource::collection(Produkt::with('ProduktKategorie', 'ProduktState', 'ProduktParam', 'ProduktAnforderung', 'firma', 'Equipment', 'ControlProdukt')->get());
    }

    public function storemany(Request $request)
    {
        $jsondata = (object)$request->json()->all();
        if (isset($jsondata->label)) {
            return $this->store($request);
        } else {
            $idList = [];
            $skippedObjectIdList = [];
            $countNew = 0;
            $countUpdate = 0;
            $countSkipped = 0;
            foreach ($jsondata as $data) {
                /**
                 *    label is a required field. Skipp this dataset
                 */
                if (!isset($data['label'])) {
                    $skippedObjectIdList[] = ['error' => 'no required items found in given dataset (missing item [label])'];
                    $countSkipped++;
                    continue;
                }

                /**
                 *  Check given category data and
                 *  assign to $product->produkt_kategorie_id
                 */
                if (isset($data['category']['label'])) {
                    if (ProduktKategorie::where('pk_label', $data['category']['label'])->count() === 0) {
                        $produkt_kategorie_id = (new ProduktKategorie)->apiAdd($data['category']);

                    } else {
                        $category = ProduktKategorie::where('pk_label', $data['category']['label'])->first();
                        $produkt_kategorie_id = $category->id;
                    }
                    $produkt_kategorie_id_list[] = ['produkt_kategorie_id' => $produkt_kategorie_id];

                } elseif (isset($data['produkt_kategorie_id'])) {
                    if (ProduktKategorie::find($data['produkt_kategorie_id'])) {
                        $produkt_kategorie_id = $data['produkt_kategorie_id'];
                        $produkt_kategorie_id_list[] = ['produkt_kategorie_id' => $produkt_kategorie_id];
                    } else {
                        $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (invalid item [produkt_kategorie_id])'];
                        $countSkipped++;
                        continue;
                    }
                } else {
                    $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (missing item [category])'];
                    $countSkipped++;
                    continue;
                }

                /**
                 *  Check given product state data and
                 *  assign to $product->produkt_state_id
                 */
                if (isset($data['status']['label'])) {
                    if (ProduktState::where('ps_label', $data['status']['label'])->count() === 0) {
                        $produkt_state_id = (new ProduktState)->apiAdd($data['status']);

                    } else {
                        $produkt_state_id = ProduktState::where('ps_label', $data['status']['label'])->first();
                        $produkt_state_id = $produkt_state_id->id;
                    }
                    $produkt_state_id_list[] = ['produkt_state_id' => $produkt_state_id];

                } elseif (isset($data['produkt_state_id'])) {
                    if (ProduktState::find($data['produkt_state_id'])) {
                        $produkt_state_id = $data['produkt_state_id'];
                        $produkt_state_id_list[] = ['produkt_state_id' => $produkt_state_id];
                    } else {
                        $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (invalid item [produkt_state_id])'];
                        $countSkipped++;
                        continue;
                    }
                } else {
                    $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (missing item [category])'];
                    $countSkipped++;
                    continue;
                }


                if ($this->checkProductExists($data['number'])){
                    $skippedObjectIdList[] = ['error' => 'skipp ' . $data['number'] . ' dataset already existent in database'];
                    $countSkipped++;
                    continue;
                }


                /**
                 *  Check if given product exists in database and decide to
                 *  update or create new one
                 */
                if (Produkt::where('prod_label', $data['label'])->count() > 0) {
                    $product = Produkt::where('prod_label', $data['label'])->first();
                    $updateDataset = true;
                    $countUpdate++;
                } elseif (isset($data['id']) && Produkt::find($data['id'])) {
                    $product = Produkt::find($data['id']);
                    $updateDataset = true;
                    $countUpdate++;
                } else {
                    $product = new Produkt();
                    $updateDataset = false;
                }

                $product->produkt_kategorie_id = $produkt_kategorie_id;
                $product->produkt_state_id = $produkt_state_id;
                $product->prod_label = $data['label'];
                $product->prod_name = $data['name'];
                $product->prod_description = $data['description'];
                $product->prod_nummer = $data['number'];
                $product->prod_active = $data['active'];

                if ($product->save()) {
                    $msg = $updateDataset ? 'updated' : 'new';
                    Log::info($msg . ' product ' . $data['label'] . ' via API/V1');
                } else {
                    Log::error('Faild to add/update product ' . $data['label']);
                }

                $idList[] = [
                    'product' => $product->id
                ];

            }
            return response()->json([
                'updated_objects' => $countUpdate,
                'skipped_objects' => [
                    'total'   => $countSkipped,
                    'id_list' => $skippedObjectIdList
                ],
                'new_objects'     => [
                    'total'      => $countNew,
                    'product_id' => $idList
                ],
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return ProductResource|JsonResponse
     */
    public function store(Request $request)
    {

        dd($request->number);
        if ($this->checkProductExists($request->number))
            return response()->json([
                'error'=>'',
                'product' => new ProductResource(Produkt::where('prod_nummer',$request->number)->first())
            ], 422);


        $request->validate([
            'label'          => 'required',
            'number'         => 'required',
            'active'         => 'required',
            'uid'            => '',
            'name'           => '',
            'description'    => '',
            'category_id'    => 'exclude_unless:category.label,true|required',
            'category.label' => 'exclude_unless:category_id,true|required',
            'status_id'      => 'exclude_unless:status.label,true|required',
            'status.label'   => 'exclude_unless:status_id,true|required',
        ]);

        $error = false;

        $product = new Produkt();

        $product->prod_label = $request->label;
        $product->prod_name = $request->name;
        $product->prod_description = $request->description;
        $product->prod_nummer = $request->number;
        $product->prod_active = isset($request->active) ? $request->active : 1;
        $product->prod_price = $request->price;

        if (isset($request->category['label'])) {
            $category_id = (new ProduktKategorie)->apiAdd($request->category);
        } elseif (isset($request->category_id)) {
            $category_id = (new ProduktKategorie)->apiCheck($request->category_id);
            if ($category_id === 0) $error['error'] = [
                'category' => 'Referenced category could not be found'
            ];
        } else {
            $category_id = 0;
        }

        $product->produkt_kategorie_id = $category_id;

        if (isset($request->status)) {
            if (isset($request->status['label'])) {
                $status_id = (new ProduktState)->apiAdd($request->status);
            } else {
                $error['error'] = [
                    'status' => 'No data was submitted for product status. Object expected.'
                ];
                $status_id = 0;
            }
        } elseif (isset($request->status_id)) {
            $status_id = (new ProduktKategorie)->apiCheck($request->status_id);
            if ($status_id === 0) $error['error'] = [
                'status' => 'Referenced product state could not be found'
            ];
        } else {
            $status_id = 0;
        }

        $product->produkt_state_id = $status_id;

        if ($error) return response()->json($error, 422);

        $product->save();

        return new ProductResource($product);

    }

    /**
     * Display the specified resource.
     *
     * @param  Produkt $product
     *
     * @return ProductResource
     */
    public function show(Produkt $product)
    : ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *a
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Produkt $produkt
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Produkt $produkt)
    : JsonResponse
    {
        $produkt->delete();
        return response()->json([
            'status' => 'product deleted'
        ]);
    }

    /**
     * Bind a company to a given product.
     *
     * @param  Request $request
     *
     * @return ProductResource|JsonResponse
     */
    public function addCompany(Request $request)
    : JsonResponse
    {
        dd($request->product);

        $address_id = false;
        $firma_id = false;

        $st = [];

        $st['request'] = $request;

        if (isset($request->ckAddNewAddress)) {

            $this->validateAdresse();
            $addresse = new Adresse();
            $addresse->ad_label = $request->ad_label;
            $addresse->ad_anschrift_strasse = $request->ad_anschrift_strasse;
            $addresse->ad_anschrift_plz = $request->ad_anschrift_plz;
            $addresse->ad_anschrift_ort = $request->ad_anschrift_ort;
            $addresse->ad_anschrift_hausnummer = $request->ad_anschrift_hausnummer;
            $addresse->land_id = $request->land_id;
            $addresse->address_type_id = $request->address_type_id;
            $addresse->ad_name_firma = $request->fa_name;
            $addresse->save();

            $address_id = $addresse->id;
            $st['add'][] = 'Neue Adresse anlegen';
            //            $address_id = 12;
        }

        if (isset($request->ckAddNewFirma)) {
            $st['firma'][] = 'Neue Firma anlegen';
            //            $firma_id = 59;
            if ($address_id !== false) {
                $st['firma'][] = '$address_id -> ' . $address_id;
                $this->validateFirma();
                $fa = new Firma();
                $fa->fa_label = $request->fa_label;
                $fa->fa_name = $request->fa_name;
                $fa->fa_kreditor_nr = $request->fa_kreditor_nr;
                $fa->fa_debitor_nr = $request->fa_debitor_nr;
                $fa->fa_vat = $request->fa_vat;
                $fa->adresse_id = $address_id;
                $fa->save();
                $firma_id = $fa->id;
            } else {
                $st['firma'][] = '$address_id wird übernommen ->' . $request->adress_id;
                $firma = Firma::create($this->validateFirma());
                $firma_id = $firma->id;
            }

            $st['FirmaProdukt'][] = 'Baue neues FirmaProdukt aus neuer Firma';
            $faprod = new FirmaProdukt();
            $faprod->firma_id = $firma_id;
            $faprod->produkt_id = $request->produkt_id;
            $faprod->save();
        } else {
            $st['FirmaProdukt'][] = 'Baue neue FirmaProdukt aus bestehender Firma';

        }

        if (isset($request->ckAddNewContact)) {
            if ($firma_id) {
                $st['contact'] = 'Baue neuen Kontakt mit neuer Firma';
                $this->validateContact();

                $con = new Contact();

                $con->con_label = $request->con_label;
                $con->con_vorname = $request->con_vorname;
                $con->con_name = $request->con_name;
                $con->con_telefon = $request->con_telefon;
                $con->con_email = $request->con_email;
                $con->anrede_id = $request->anrede_id;
                $con->firma_id = $firma_id;
                $con->save();
            } else {
                $st['contact'] = 'Baue neuen Kontakt mit bestehender Firma';
                Contact::create($this->validateContact());
            }
        }


        FirmaProdukt::updateOrInsert([
            'firma_id'   => $company_id,
            'produkt_id' => $product_id
        ]);

        return response()->json([
            'status' => __('Das Produkt wurde der Firma :name zugeordnet!', ['name' => $request->fa_name])
        ]);
    }


    /**
     * Set an employee/user as qualified for a product.
     *  Expected json data schema:
     *  {
     *       "product_label": "STRING",
     *       "product_number": "STRING",
     *       "qualified_at": "DATE[YYYY-MM-DD]",
     *       "company": {
     *           "id" : INTEGER,
     *           "label": "STRING",
     *           "name": "STRING"
     *       },
     *       "employee": {
     *           "id": INTEGER,
     *           "last_name": "STRING",
     *           "first_name": "STRING"
     *       }
     *   }
     *
     * @param  Request $request
     *
     * @return ProductResource|JsonResponse
     */
    public function addQualifiedEmployee(Request $request)
    : JsonResponse
    {

        /**
         *   Check if an equivalent dataset exists
         */
        if ((new ProductQualifiedUser)->checkEntry([
            'product_label'  => $request->product_label,
            'product_number' => $request->product_number,
            'qualified_at'   => $request->qualified_at,
            'company'        => $request->company,
            'employee'       => $request->employee,
        ])) return response()->json(__('Der Eintrag existiert bereits. Vorgang wird abgebrochen.'), 422);

        $msg = '';
        $productFound = false;
        $employeeFound = false;
        $companyFound = false;

        /**
         * Check if product number was submitted and if it exists in DB
         */
        $getProduct = Produkt::where('prod_nummer', $request->product_number);
        if ($getProduct->count() > 0) {
            $product = $getProduct->get()->first();
            $product_id = $product->id;
            $productFound = true;
        } else {
            $msg = __('Das Produkt wurde nicht gefunden!');
        }

        /**
         * Check if an employee was submitted and if it exists in DB
         */
        if (isset($request->employee['last_name'])) {
            $getEmployee = Profile::where([
                [
                    'ma_name',
                    $request->employee['last_name']
                ],
                [
                    'ma_vorname',
                    $request->employee['first_name']
                ],
            ]);

            if ($getEmployee->count() > 0) {
                $employee = $getEmployee->get()->first();
                $employee_id = $employee->id;
                $employeeFound = true;
            } else {
                $msg = __('Mitarbeiter konnte nicht zugeordnet werden!');
            }
        } else {
            $msg = __('Es wurde kein Mitarbeiter übergeben!');
        }


        /**
         * Check if an employee was submitted and if it exists in DB
         */
        if (isset($request->company['id'])) {
            $getCompany = Firma::find($request->company['id']);
        } else {
            $getCompany = Firma::where('fa_label', $request->company);
        }

        if ($getCompany->count() > 0) {
            $company = $getCompany->get()->first();
            $company_id = $company->id;
            $companyFound = true;
        } else {
            $msg .= __('Die angegebene Firma wurde nicht gefunden!');
        }

        if ($productFound && $employeeFound && $companyFound) {
            if ((new ProductQualifiedUser)->addApi([
                'product_qualified_firma' => $company_id,
                'product_qualified_date'  => $request->qualified_at,
                'user_id'                 => $employee_id,
                'produkt_id'              => $product_id,
            ])) {
                $msg .= $request->employee['last_name'] . ' ' . __('wurde als befähigte Person hinzugefügt.', ['name' => $request->employee['last_name']]);
                Log::info($msg);
            } else {
                $msg .= __('Es gab einen Fehler bei der Verarbeitung');
                Log::error(__('API Fehler beim Anlegen ProductQualifiedUser '));
            }
            return response()->json(['status' => $msg]);
        } else {
            return response()->json($msg, 422);
        }
    }

    protected function checkProductExists(string $product_number)
    {
        return (Produkt::where('prod_nummer', $product_number)->count() > 0) ;
    }
}
