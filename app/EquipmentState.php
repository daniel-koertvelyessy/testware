<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class EquipmentState extends Model
{
    use SoftDeletes, Sortable;

    protected $guarded = [];

    public function Equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
