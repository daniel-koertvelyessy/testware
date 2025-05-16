<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

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
        'is_external',
    ];

    protected $casts = [
        'is_initial_test' => 'boolean',
        'is_external' => 'boolean',
    ];

    protected $fillable = [
        'an_label',
        'an_name',
        'an_control_interval',
        'control_interval_id',
        'anforderung_type_id',
        'an_description',
        'is_initial_test',
        'verordnung_id',
        'an_date_warn',
        'warn_interval_id',
        'is_external',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-database');
            Cache::forget('system-root-test-requirement');
            Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('system-status-database');
            Cache::forget('system-status-objects');
            Cache::forget('system-root-test-requirement');

        });
    }

    public function checkControlItemListe(Anforderung $anforderung)
    {
        return (AnforderungControlItem::where('anforderung_id', $anforderung->id)->count() == 0)
            ? '
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        '.$anforderung->an_name.'
                        <span class="badge badge-primary badge-pill">'.AnforderungControlItem::where('anforderung_id', $anforderung->id)->count().'</span>
                    </li>
                '
            : '';
    }

    public function ProduktAnforderung()
    {
        return $this->hasMany(ProduktAnforderung::class);
    }

    public function ControlEquipment()
    {
        return $this->hasMany(ControlEquipment::class);
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

    public function isInComplete(Anforderung $anforderung, int $countControlProducts): array|bool
    {
        $msg = '<ul class="list-unstyled text-warning">';
        $msgAci = '';

        $anforderungsControlItemList[] = Cache::remember('system-root-test-requirement', now()->addHours(12), function () use ($anforderung, $countControlProducts) {
            foreach (AnforderungControlItem::select('id')->where('anforderung_id', $anforderung->id)->get() as $aci) {
                return $aci->isIncomplete($aci, $countControlProducts);
            }
        });

        $msg .= $msgAci.'</ul>';

        return (Arr::exists($anforderungsControlItemList, false))
            ? false
            : [
                'msg' => '
<span class="fas fa-exclamation-triangle text-warning" title="Mindestens eine Bedingung für die Prüfung in der Anforderung ist nicht erfüllt. Bitte kontrollieren!"></span>
<span class="sr-only">Mindestens eine Bedingung für die Prüfung in der Anforderung ist nicht erfüllt. Bitte kontrollieren!</span>
'.$msg,
                'list' => $msg,
            ];
    }

    public function isInternal(): bool
    {

        return ! $this->is_external;
    }

    public function countControlItems(): int
    {
        return AnforderungControlItem::where('anforderung_id', $this->id)->count();
    }

    public function getVerordnungLabel(): string
    {
        return Verordnung::where('id', $this->verordnung_id)->first()->vo_label;
    }

    public function getControlIntervalLabel(): string
    {
        return ControlInterval::where('id', $this->control_interval_id)->first()->ci_label;
    }
}
