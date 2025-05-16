<?php

namespace App\Http\Services\Product;

use App\Equipment;
use App\FirmaProdukt;
use App\ProductInstructedUser;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktAnforderung;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public static function getSearchResults(string $term): array
    {

        $data = [];
        foreach ((new ProductService)->query($term) as $ret) {
            $data[] = [
                'link' => route('produkt.show', $ret),
                'label' => '['.__('Produkt').'] '.$ret->prod_label.' '.$ret->prod_nummer,
            ];
        }

        return $data;
    }

    protected function query(string $term)
    {
        return Produkt::where('prod_label', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('prod_name', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('prod_description', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('prod_nummer', 'ILIKE', '%'.strtolower($term).'%')
            ->get();
    }

    public static function search(string $term)
    {
        return (new ProductService)->query($term);
    }

    public function hasQualifiedUsers(Produkt $produkt): bool
    {
        return ProductQualifiedUser::select('id', 'user_id')->where('produkt_id', $produkt->id)->count() > 0;
    }

    public function hasExternalSupplier(Produkt $produkt): bool
    {
        return FirmaProdukt::select('id')->where('produkt_id', $produkt->id)->count() > 0;
    }

    public function deleteEmptyStorageDBItems(Produkt $produkt)
    {
        foreach ($produkt->ProduktDoc as $produktDoc) {
            if (Storage::disk('local')->missing($produktDoc->proddoc_name_pfad)) {
                Log::warning('Dateireferenz ('.$produktDoc->proddoc_name_pfad.') aus DB ProduktDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
                //                dump(' delete ' . $produktDoc->proddoc_name_pfad);
                $produktDoc->delete();
            }
        }
    }

    public function getChildEquipmentList(Produkt $produkt, int $itemsPerPage = 10)
    {
        return Equipment::where('produkt_id',
            $produkt->id)->with('EquipmentState',
                'produktDetails')->sortable()->paginate($itemsPerPage);
    }

    public function getProductQualifiedUserList(Produkt $produkt)
    {
        return ProductQualifiedUser::where('produkt_id', $produkt->id)->with('user', 'firma')->get();
    }

    public function getRequirementList(Produkt $produkt)
    {
        return ProduktAnforderung::with('Produkt', 'Anforderung')->where('produkt_id', $produkt->id)->get();
    }

    public function getInstructedUserList(Produkt $produkt)
    {
        return ProductInstructedUser::with('Profile', 'Firma')->where('produkt_id', $produkt->id)->get();
    }

    public function setuuid()
    {

        $counter = Produkt::withTrashed()->where('prod_uuid', null)->get()->map(function ($product) {
            $product->prod_uuid = Str::uuid();

            return $product->save();
        });

        $msg = ($counter->sum() == 1) ? __('Es wurde ein Produkt mit einer neuen UUID vershen.') : __('Es wurden :num Produkte mit einer UUID versehen.', ['num' => $counter->sum()]);

        request()->session()->flash('status', $msg);

        return back();
    }
}
