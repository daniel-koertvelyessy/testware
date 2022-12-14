<?php

    namespace App\Http\Services\Product;

    use App\Equipment;
    use App\FirmaProdukt;
    use App\ProductQualifiedUser;
    use App\Produkt;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;

    class ProductService
    {

        protected function query(string $term)
        {
            return Produkt::whereRaw('LOWER(prod_label) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(prod_name) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(prod_description) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(prod_nummer) LIKE ?', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {

            $data = [];
            foreach ((new ProductService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('produkt.show', $ret),
                    'label' => '[' . __('Produkt') . '] ' . $ret->prod_label . ' ' . $ret->prod_nummer
                ];
            }
            return $data;
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
                    Log::warning('Dateireferenz (' . $produktDoc->proddoc_name_pfad . ') aus DB ProduktDoc existiert nicht auf dem Laufwerk. Datensatz wird gel??scht!');
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
            return ProductQualifiedUser::where('produkt_id', $produkt->id)->with('user')->get();
        }

        public function getRequirementList(Produkt $produkt)
        {
            return \App\ProduktAnforderung::where('produkt_id', $produkt->id)->get();
        }
    }