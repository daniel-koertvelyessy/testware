<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\products\Product as ProductResource;
use App\Http\Resources\products\ProductFull as ProductFullResource;
use App\Http\Resources\products\ProductShow as ProductShowResource;
use App\Produkt;
use App\ProduktKategorie;
use App\ProduktState;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return ProductResource|JsonResponse
     */
    public function store(Request $request)
    {
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
}
