<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\products\Product as ProductResource;
use App\Http\Resources\products\ProductFull as ProductFullResource;
use App\Http\Resources\products\ProductShow as ProductShowResource;
use App\Produkt;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request) {
        if ($request->input('per_page')){
            return ProductResource::collection(Produkt::with(
                'ProduktKategorie',
                'ProduktState',
                'ProduktParam',
                'ProduktAnforderung',
                'firma',
                'Equipment',
                'ControlProdukt')
                ->paginate($request->input('per_page')));
        }
        return ProductResource::collection(Produkt::with(
            'ProduktKategorie',
            'ProduktState',
            'ProduktParam',
            'ProduktAnforderung',
            'firma',
            'Equipment',
            'ControlProdukt'
        )->get());
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return AnonymousResourceCollection
     */
    public function full(Request $request)
    {
        if ($request->input('per_page')){
            return ProductFullResource::collection(Produkt::with(
                'ProduktKategorie',
                'ProduktState',
                'ProduktParam',
                'ProduktAnforderung',
                'firma',
                'Equipment',
                'ControlProdukt'
            )->paginate($request->input('per_page')));
        }
        return ProductFullResource::collection(Produkt::with(
            'ProduktKategorie',
            'ProduktState',
            'ProduktParam',
            'ProduktAnforderung',
            'firma',
            'Equipment',
            'ControlProdukt'
        )->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Produkt $product
     * @return ProductFullResource
     */
    public function show(Produkt $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *a
     * @param  Request $request
     * @param  int     $id
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
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Produkt $produkt)
    {
        $produkt->delete();
        return response()->json([
            'status' => 'product deleted'
        ]);
    }
}
