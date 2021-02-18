<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use App\AnforderungControlItem;

class Anforderung extends Model
{
    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
        'an_label',
        'an_name',
        'an_description',
    ];
    protected $guarded = [];

    public function search($term)
    {
        return Anforderung::where('an_label', 'like', '%' . $term . '%')
            ->orWhere('an_name', 'like', '%' . $term . '%')
            ->orWhere('an_description', 'like', '%' . $term . '%')
            ->get();
    }

    public function checkControlItemListe(Anforderung $anforderung)
    {
        return (AnforderungControlItem::where('anforderung_id', $anforderung->id)->count() == 0)
            ?
            '
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ' . $anforderung->an_name . '
                        <span class="badge badge-primary badge-pill">' . AnforderungControlItem::where('anforderung_id', $anforderung->id)->count() . '</span>
                    </li>
                '
            : '';
    }

    public function ProduktAnforderung()
    {
        return $this->hasMany(ProduktAnforderung::class);
    }


    public function Equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function Verordnung()
    {
        return $this->belongsTo(Verordnung::class);
    }


    public function AnforderungControlItem()
    {
        return $this->hasMany(AnforderungControlItem::class);
    }

    public function ControlInterval()
    {
        return $this->belongsTo(ControlInterval::class);
    }

    public function AnforderungType()
    {
        return $this->hasMany(AnforderungType::class);
    }

    public function isInComplete(Anforderung $anforderung)
    {
        $msg = '<ul class="list-unstyled text-warning">';
        $msgAci = '';
        $isInComplete = false;
        foreach (AnforderungControlItem::where('anforderung_id', $anforderung->id)->get() as $aci) {
            $msgAci = $aci->isIncomplete($aci);
            $isInComplete = $msgAci;
        }

        $msg .= $msgAci . '</ul>';
        return ($isInComplete)
            ? ['msg' => '<span class="fas fa-exclamation-triangle text-warning" title="Mindestens eine Bedingung für die Prüfung in der Anforderung ist nicht erfüllt. Bitte kontrollieren!"></span><span class="sr-only">Mindestens eine Bedingung für die Prüfung in der Anforderung ist nicht erfüllt. Bitte kontrollieren! </span>' . $msg, 'list' => $msg]
            : false;
    }
}
