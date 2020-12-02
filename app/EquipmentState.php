<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class EquipmentState extends Model
{
    use Sortable, SoftDeletes;

    public function Equipment()
    {
        return $this->hasMany(Equipment::class);
    }


}
