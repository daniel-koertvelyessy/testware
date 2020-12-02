<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Verordnung extends Model
{
    use SoftDeletes, Sortable;

    protected $guarded = [];

    public $sortable = [
        'id',
        'vo_name_kurz',
        'vo_name_lang',
        'vo_nummer',
        'vo_stand',
        'vo_name_text',
        ''

        ];


    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }

    public function search($term) {
        return Verordnung::where('vo_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('vo_name_lang', 'like', '%' . $term . '%')
            ->orWhere('vo_nummer', 'like', '%' . $term . '%')
            ->orWhere('vo_stand', 'like', '%' . $term . '%')
            ->orWhere('vo_name_text', 'like', '%' . $term . '%')
            ->get();
    }

}
