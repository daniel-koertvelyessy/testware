<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Anforderung extends Model
{
    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
        'an_name_kurz',
        'an_name_lang',
        'an_name_text',
    ];
    protected $guarded = [];

    public function search($term)
    {
        return Anforderung::where('an_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('an_name_lang', 'like', '%' . $term . '%')
            ->orWhere('an_name_text', 'like', '%' . $term . '%')
            ->get();
    }

    public function ProduktAnforderung()
    {
        return $this->hasMany(ProduktAnforderung::class);
    }

    public function LocationAnforderung()
    {
        return $this->hasMany(LocationAnforderung::class);
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
        return ($isInComplete) ? ['msg' => '<span class="fas fa-exclamation-triangle text-warning" title="Mindestens eine Bedingung für die Prüfung in der Anforderung ist nicht erfüllt. Bitte kontrollieren!"></span><span class="sr-only">Mindestens eine Bedingung für die Prüfung in der Anforderung ist nicht erfüllt. Bitte kontrollieren! </span>' . $msg, 'list' => $msg] : false;


    }
}
