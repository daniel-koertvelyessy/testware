<?php

// database/factories/EquipmentQualifiedUserFactory.php

namespace Database\Factories;

use App\Equipment;
use App\EquipmentQualifiedUser;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentQualifiedUserFactory extends Factory
{
    protected $model = EquipmentQualifiedUser::class;

    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::factory(),
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
