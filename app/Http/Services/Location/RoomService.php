<?php

    namespace App\Http\Services\Location;

    use App\Room;

    class RoomService
    {

        protected function query(string $term)
        {
            return Room::where('r_label','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('r_name','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('r_description','ILIKE', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new RoomService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('room.show', $ret),
                    'label' => '[' . __('Raum') . '] ' . $ret->r_label
                ];
            }

            return $data;
        }

        public static function search(string $term)
        {
            return (new RoomService)->query($term);
        }

    }