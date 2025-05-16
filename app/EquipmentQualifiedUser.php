<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EquipmentQualifiedUser extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'equipment_id',
        'equipment_qualified_date',
        'equipment_qualified_firma',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function firma()
    {
        return $this->belongsTo(Firma::class, 'equipment_qualified_firma');
    }

    public function addQualifiedUser($request, Equipment $equipment): bool
    {
        $this->user_id = $request->user_id;
        $this->equipment_id = $equipment->id;
        $this->equipment_qualified_date = $request->product_qualified_date;
        $this->equipment_qualified_firma = $request->product_qualified_firma;

        return $this->save();
    }

    public function removeQualifiedUser($userid, Equipment $equipment)
    {
        return EquipmentQualifiedUser::where([
            [
                'user_id',
                $userid,
            ],
            [
                'equipment_id',
                $equipment->id,
            ],
        ])->delete();
    }

    public function addEquipment(ProductQualifiedUser $productQualifiedUser, $equipment_id): bool
    {
        $this->user_id = $productQualifiedUser->user_id;
        $this->equipment_id = $equipment_id;
        $this->equipment_qualified_date = $productQualifiedUser->product_qualified_date;
        $this->equipment_qualified_firma = $productQualifiedUser->product_qualified_firma;

        return $this->save();
    }
}
