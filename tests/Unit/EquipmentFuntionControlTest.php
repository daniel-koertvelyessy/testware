<?php

namespace Tests\Unit;

use App\Equipment;
use App\EquipmentFuntionControl;
use App\EquipmentHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class EquipmentFuntionControlTest extends TestCase
{
    use RefreshDatabase;

    private EquipmentFuntionControl $equipmentFunctionControl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\InitialValueSeeder::class);
        Equipment::factory()->create();
        $this->equipmentFunctionControl = new EquipmentFuntionControl;
    }

    public function test_fillable_attributes(): void
    {
        $expectedFillable = [
            'controlled_at',
            'function_control_firma',
            'function_control_profil',
            'function_control_pass',
            'function_control_text',
        ];

        $this->assertEquals($expectedFillable, $this->equipmentFunctionControl->getFillable());
    }

    public function test_firma_relationship(): void
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $this->equipmentFunctionControl->firma());
    }

    public function test_cache_is_cleared_on_save(): void
    {
        Equipment::factory()->create();

        Cache::shouldReceive('forget')->with('system-status-database')->twice();
        Cache::shouldReceive('forget')->with('system-status-objects')->twice();

        $functionControl = EquipmentFuntionControl::factory()->create();
        $functionControl->save();

        $this->assertTrue(true);

    }

    public function test_add_control_event_returns_false_when_equipment_id_not_set(): void
    {
        $request = new Request;

        $result = $this->equipmentFunctionControl->addControlEvent($request, null);

        $this->assertFalse($result);
    }

    public function test_add_control_event_creates_record_successfully(): void
    {
        $equipment = Equipment::factory()->create();

        $request = new Request;
        $request->merge([
            'controlled_at' => '2024-03-20',
            'function_control_firma' => '1',
            'function_control_profil' => null,
            'function_control_pass' => '1',
            'function_control_text' => 'Test Bemerkung',
        ]);

        $result = $this->equipmentFunctionControl->addControlEvent($request, $equipment->id);

        $this->assertIsInt($result);

        $this->assertDatabaseHas('equipment_funtion_controls', [
            'equipment_id' => $equipment->id,
            'controlled_at' => '2024-03-20',
            'function_control_firma' => '1',
            'function_control_profil' => null,
            'function_control_pass' => '1',
        ]);

        $this->assertDatabaseHas('equipment_histories', [
            'equipment_id' => $equipment->id,
            'eqh_eintrag_kurz' => 'Funktionsprüfung erfolgt',
            'eqh_eintrag_text' => 'Das Geräte wurde am  einer Funktionsprüfung unterzogen. Die Prüfung wurde erfolgreich abgeschlossen.Bemerkungen: Test Bemerkung',

        ]);

    }

    public function test_add_control_event_returns_false_when_both_firma_and_profil_are_void(): void
    {
        $request = new Request;
        $request->merge([
            'function_control_firma' => 'void',
            'function_control_profil' => 'void',
        ]);

        $result = $this->equipmentFunctionControl->addControlEvent($request, 1);

        $this->assertFalse($result);
    }

    public function test_add_control_event_handles_null_values(): void
    {
        // Zuerst ein Equipment erstellen
        $equipment = Equipment::factory()->create();

        //        // Mock EquipmentHistory
        //        $historyMock = Mockery::mock(EquipmentHistory::class);
        //        $historyMock->shouldReceive('add')->withArgs(function ($eqh_eintrag_kurz, $eqh_eintrag_text, $equipment_id) use ($equipment) {
        //                return is_string($eqh_eintrag_kurz) && is_string($eqh_eintrag_text) && $equipment_id === $equipment->id;
        //            })->once()->andReturn(true);
        //        app()->instance(EquipmentHistory::class, $historyMock);

        $request = new Request;
        $request->merge([
            'controlled_at' => '2024-03-20',
            'function_control_firma' => 'void',
            'function_control_profil' => null,
            'function_control_pass' => '0',
        ]);

        $result = $this->equipmentFunctionControl->addControlEvent($request, $equipment->id);

        $this->assertIsInt($result);

        $this->assertDatabaseHas('equipment_funtion_controls', [
            'equipment_id' => $equipment->id,
            'controlled_at' => '2024-03-20',
            'function_control_firma' => null,
            'function_control_pass' => '0',
        ]);

        $this->assertDatabaseHas('equipment_histories', [
            'eqh_eintrag_kurz' => 'Funktionsprüfung erfolgt',
            'eqh_eintrag_text' => 'Das Geräte wurde am  einer Funktionsprüfung unterzogen.  Die Prüfung konnte nicht erfolgreich abgeschlossen werden. Gerät wird gesperrt.',
            'equipment_id' => $equipment->id,

        ]);

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
