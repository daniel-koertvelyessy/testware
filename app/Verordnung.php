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
        'vo_description',
        ''

    ];


    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }

    public function search($term)
    {
        $term = strtolower($term);
        return Verordnung::whereRaw('lower(vo_label) like ?', '%' . $term . '%')
            ->orWhereRaw('lower(vo_name) like ?', '%' . $term . '%')
            ->orWhereRaw('lower(vo_nummer) like ?', '%' . $term . '%')
            ->orWhereRaw('lower(vo_stand) like ?', '%' . $term . '%')
            ->orWhereRaw('lower(vo_description) like ?', '%' . $term . '%')
            ->get();
    }
}
