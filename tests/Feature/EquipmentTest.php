<?php

namespace Tests\Feature;

use App\ControlProdukt;
use App\Equipment;
use App\EquipmentQualifiedUser;
use App\Produkt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    private Equipment $equipment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\InitialValueSeeder::class);

        $this->equipment = Equipment::factory()->create();
    }

    public function test_equipment_can_be_created(): void
    {
        $equipment = Equipment::factory()->create();

        $this->assertInstanceOf(Equipment::class, $equipment);
        $this->assertNotNull($equipment->id);
    }

    public function test_equipment_clears_cache_when_saving(): void
    {
        Cache::shouldReceive('forget')->with('app-get-current-amount-Equipment')->twice();
        Cache::shouldReceive('forget')->with('system-status-database')->times(3);
        Cache::shouldReceive('forget')->with('system-status-objects')->times(3);
        Cache::shouldReceive('forget')->with('equipment.count')->twice();
        Cache::shouldReceive('forget')->with('app-get-current-amount-Location')->once();
        Cache::shouldReceive('forget')->with('countTotalEquipmentInLocation')->once();

        $equipment = Equipment::factory()->create();
        $equipment->save();

    }

    public function test_is_control_produkt_returns_false_when_produkt_id_is_null(): void
    {
        $equipment = Equipment::factory()->create([
            'produkt_id' => null,
        ]);

        $this->assertFalse($equipment->isControlProdukt());
    }

    public function test_price_tag_formats_price_correctly(): void
    {
        $equipment = Equipment::factory()->create([
            'eq_price' => 1234.56,
        ]);

        $this->assertEquals('1234.56', $equipment->priceTag());
    }

    public function test_control_product_icon_returns_correct_icon(): void
    {
        $equipment = Equipment::factory()->create();

        // Test when no control product exists
        $this->assertEquals('<i class="fas fa-times text-muted"></i>', $equipment->controlProductIcon());

        // Test when control product exists
        $produkt = Produkt::factory()->create();
        $equipment->produkt_id = $produkt->id;
        $equipment->save();

        ControlProdukt::create([
            'produkt_id' => $produkt->id,
        ]);

        $this->assertEquals('<i class="fas fa-check text-success"></i>', $equipment->controlProductIcon());
    }

    public function test_equipment_relationships_are_correct_type(): void
    {
        $equipment = Equipment::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $equipment->Produkt());

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $equipment->EquipmentParam());

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $equipment->storage());

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $equipment->control());
    }

    public function test_equipment_can_be_locked(): void
    {
        $equipment = Equipment::factory()->create();

        $equipment->lockEquipment($equipment);

        $this->assertEquals(4, $equipment->equipment_state_id);
        $this->assertEquals(4, $equipment->fresh()->equipment_state_id);
    }

    public function test_count_qualified_users(): void
    {
        $equipment = Equipment::factory()->create();

        EquipmentQualifiedUser::factory()
            ->count(3)
            ->create([
                'equipment_id' => $equipment->id,
            ]);

        $this->assertEquals(3, $equipment->countQualifiedUser());
    }

    public function test_has_function_test(): void
    {
        $equipment = Equipment::factory()->create();

        $this->assertFalse($equipment->hasFunctionTest());
    }

    public function test_count_instances(): void
    {
        $produkt = Produkt::factory()->create();

        // Create multiple equipment with same produkt_id
        Equipment::factory()->count(3)->create([
            'produkt_id' => $produkt->id,
        ]);

        $equipment = Equipment::factory()->create([
            'produkt_id' => $produkt->id,
        ]);

        $this->assertEquals(4, Equipment::countInstances($equipment));
    }
}
