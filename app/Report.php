<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Report extends Model
{
    use SoftDeletes, Sortable;

    protected $guarded = [];

    public function types()
    {
        return $this->hasOne(ReportType::class, 'id', 'report_type_id');
    }
}
