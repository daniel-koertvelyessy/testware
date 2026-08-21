<?php

namespace Tests\Feature;

use App\Anforderung;
use App\ControlInterval;
use App\DocumentType;
use App\Equipment;
use App\EquipmentQualifiedUser;
use App\Firma;
use App\Http\Services\Equipment\EquipmentDocumentService;
use App\Http\Services\Equipment\EquipmentService;
use App\Storage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use seeders\InitialValueSeeder;
use Tests\TestCase;

class EquipmentShowTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Equipment $equipment;

    private EquipmentService $equipmentService;

    private EquipmentDocumentService $documentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialValueSeeder::class);

        $this->user = User::factory()->create();
        $this->equipment = Equipment::factory()->create();

        // Erstellen echter Service-Instanzen statt Mocks
        $this->equipmentService = new EquipmentService;
        $this->documentService = new EquipmentDocumentService;

        // Dienste im Container registrieren
        $this->app->instance(EquipmentService::class, $this->equipmentService);
        $this->app->instance(EquipmentDocumentService::class, $this->documentService);
    }

    public function test_unauthenticated_user_cannot_access_equipment_show(): void
    {
        $response = $this->get(route('equipment.show', $this->equipment));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_equipment_show(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('equipment.show', $this->equipment));

        $response->assertStatus(200);
        $response->assertViewIs('testware.equipment.show');
    }

    public function test_view_contains_required_data(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('equipment.show', $this->equipment));

        $response->assertViewHas([
            'userList',
            'productDocuments',
            'controlIntervalList',
            'qualifiedUserList',
            'loggedInUserIsQualified',
            'upcomingControlList',
            'onetimeControlList',
            'controlList',
            'instructedPersonList',
            'equipmentRequirementList',
            'requirementList',
            'recentControlList',
            'euqipmentDocumentList',
            'functionDocumentList',
            'newFileList',
            'companyString',
            'equipment',
            'parameterListItems',
            'locationpath',
            'isSysadmin',
            'documentTypes',
        ]);
    }

    public function test_storage_location_path_is_shown_correctly(): void
    {
        // Erzeuge Speicherort für den Test
        $storage = Storage::factory()->create([
            'storage_label' => 'Test Storage',
        ]);

        // Mock für Storage-Klasse erstellen
        $storageMock = Mockery::mock(Storage::find($storage->id))->makePartial();
        $storageMock->shouldReceive('getStoragePath')->andReturn('Test/Storage/Path');

        // Binde Mock ans Storage-Modell
        $this->app->instance(Storage::class, $storageMock);

        // Erzeuge Gerät mit dem Speicherort
        $equipment = Equipment::factory()->create([
            'storage_id' => $storage->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('equipment.show', $equipment));

        $this->assertEquals('Test Storage', $response->viewData('locationpath'));
    }

    public function test_non_existing_storage_shows_not_assigned_message(): void
    {
        // Erzeuge Gerät ohne Speicherort
        $equipment = Equipment::factory()->create([
            'storage_id' => null,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('equipment.show', $equipment));

        $this->assertEquals('nicht zugeordnet', $response->viewData('locationpath'));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_cleanup_actions_are_performed(): void
    {
        // Verwende Mockery's Alias-Feature für statische Methoden
        $mock = Mockery::mock('alias:App\Http\Actions\Equipment\EquipmentAction');

        // Erwartungen für statische Methoden setzen
        $mock->shouldReceive('deleteLoseEquipmentDocumentEntries')
            ->once()
            ->with(Mockery::type(Equipment::class));

        $mock->shouldReceive('deleteLoseProductDocumentEntries')
            ->once()
            ->with(Mockery::type(Equipment::class));

        $mock->shouldReceive('deleteLoseRequirementEntries')
            ->once()
            ->with(Mockery::type(Equipment::class));

        // Test durchführen
        $response = $this->actingAs($this->user)
            ->get(route('equipment.show', $this->equipment));

        $response->assertStatus(200);
    }

    public function test_equipment_service_methods_are_called_correctly(): void
    {
        // Erstelle Testdaten in der Datenbank
        $controlInterval = ControlInterval::create(['ci_label' => 'TestInter', 'ci_si' => 'test3', 'id' => 999]);
        $requirement = new Anforderung;
        $requirement->an_label = 'Test Requirement';
        $requirement->an_name = 'Test Requirement Name';
        $requirement->control_interval_id = $controlInterval->id;
        $requirement->id = 999;
        $requirement->save();

        $firma = Firma::first();

        // Füge Benutzerberechtigungen hinzu
        $qualifiedUser = new EquipmentQualifiedUser;
        $qualifiedUser->equipment_qualified_firma = $firma->id ?? null;
        $qualifiedUser->equipment_qualified_date = now();
        $qualifiedUser->user_id = $this->user->id;
        $qualifiedUser->equipment_id = $this->equipment->id;
        $qualifiedUser->save();

        // Erstelle Dokumenttypen
        $documentType = DocumentType::create([
            'doctyp_label' => 'Test Document Type',
            'doctyp_name' => 'Test Document Type',
        ]);

        // Führe den Test aus
        $response = $this->actingAs($this->user)
            ->get(route('equipment.show', $this->equipment));

        $response->assertStatus(200);

        // Überprüfe, ob die relevanten Daten da sind
        $this->assertNotNull($response->viewData('userList'));
        $this->assertNotNull($response->viewData('controlIntervalList'));
        $this->assertNotNull($response->viewData('documentTypes'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
