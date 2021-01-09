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
        'vo_label',
        'vo_name',
        'vo_nummer',
        'vo_stand',
        'vo_name_text',
        ''

    ];


    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }

    public function search($term)
    {
        return Verordnung::where('vo_label', 'like', '%' . $term . '%')
            ->orWhere('vo_name', 'like', '%' . $term . '%')
            ->orWhere('vo_nummer', 'like', '%' . $term . '%')
            ->orWhere('vo_stand', 'like', '%' . $term . '%')
            ->orWhere('vo_name_text', 'like', '%' . $term . '%')
            ->get();
    }
}
