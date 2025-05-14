<?php

namespace Tests\Feature;

use App\Anforderung;
use App\ControlInterval;
use App\DocumentType;
use App\Equipment;
use App\EquipmentQualifiedUser;
use App\Http\Actions\Equipment\EquipmentAction;
use App\Http\Services\Equipment\EquipmentDocumentService;
use App\Http\Services\Equipment\EquipmentService;
use App\ProduktDoc;
use App\Storage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;
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
        $this->seed(\Database\Seeders\InitialValueSeeder::class);

        $this->user = User::factory()->create();
        $this->equipment = Equipment::factory()->create();

        $this->equipmentService = Mockery::mock(EquipmentService::class);
        $this->documentService = Mockery::mock(EquipmentDocumentService::class);

        $this->app->instance(EquipmentService::class, $this->equipmentService);
        $this->app->instance(EquipmentDocumentService::class, $this->documentService);
    }

    public function test_unauthenticated_user_cannot_access_equipment_show(): void
    {
        $response = $this->get(route('equipment.show', $this->equipment));

        $response->assertRedirect(route('login'));
    }
//
//    public function test_authenticated_user_can_access_equipment_show(): void
//    {
//        // Mock required service methods to prevent actual DB calls
//        $this->mockServiceMethods();
//
//        $response = $this->actingAs($this->user)
//                         ->get(route('equipment.show', $this->equipment));
//
//        $response->assertStatus(200);
//        $response->assertViewIs('testware.equipment.show');
//    }
//
//    public function test_view_contains_required_data(): void
//    {
//        // Mock required service methods
//        $this->mockServiceMethods();
//
//        $response = $this->actingAs($this->user)
//                         ->get(route('equipment.show', $this->equipment));
//
//        $response->assertViewHas([
//            'userList',
//            'productDocuments',
//            'controlIntervalList',
//            'qualifiedUserList',
//            'loggedInUserIsQualified',
//            'upcomingControlList',
//            'onetimeControlList',
//            'controlList',
//            'instructedPersonList',
//            'equipmentRequirementList',
//            'requirementList',
//            'recentControlList',
//            'euqipmentDocumentList',
//            'functionDocumentList',
//            'newFileList',
//            'companyString',
//            'equipment',
//            'parameterListItems',
//            'locationpath',
//            'isSysadmin',
//            'documentTypes'
//        ]);
//    }
//
//    public function test_storage_location_path_is_shown_correctly(): void
//    {
//        // Mock required service methods
//        $this->mockServiceMethods();
//
//        $storage = Storage::factory()->create([
//            'storage_label' => 'Test Storage'
//        ]);
//
//        $equipment = Equipment::factory()->create([
//            'storage_id' => $storage->id
//        ]);
//
//        // Mock the getStoragePath method
//        $storagePath = 'Test/Storage/Path';
//        $storageMock = Mockery::mock(Storage::class)->makePartial();
//        $storageMock->shouldReceive('getStoragePath')->andReturn($storagePath);
//        $storageMock->id = $storage->id;
//
//        $this->app->instance(Storage::class, $storageMock);
//
//        // Make Storage::find return our mock
//        Storage::shouldReceive('find')
//               ->with($equipment->storage_id)
//               ->andReturn($storageMock);
//
//        $response = $this->actingAs($this->user)
//                         ->get(route('equipment.show', $equipment));
//
//        $response->assertViewHas('locationpath', $storagePath);
//    }
//
//    public function test_non_existing_storage_shows_not_assigned_message(): void
//    {
//        // Mock required service methods
//        $this->mockServiceMethods();
//
//        $equipment = Equipment::factory()->create([
//            'storage_id' => null
//        ]);
//
//        // Make Storage::find return null
//        Storage::shouldReceive('find')
//               ->with(null)
//               ->andReturn(null);
//
//        $response = $this->actingAs($this->user)
//                         ->get(route('equipment.show', $equipment));
//
//        $response->assertViewHas('locationpath', 'nicht zugeordnet');
//    }
//
//    public function test_cleanup_actions_are_performed(): void
//    {
//        // Mock required service methods
//        $this->mockServiceMethods();
//
//        // Mock static methods of EquipmentAction
//        $this->mock('alias:App\Http\Actions\Equipment\EquipmentAction', function ($mock) {
//            $mock->shouldReceive('deleteLoseEquipmentDocumentEntries')
//                 ->once()
//                 ->with(Mockery::type(Equipment::class));
//
//            $mock->shouldReceive('deleteLoseProductDocumentEntries')
//                 ->once()
//                 ->with(Mockery::type(Equipment::class));
//
//            $mock->shouldReceive('deleteLoseRequirementEntries')
//                 ->once()
//                 ->with(Mockery::type(Equipment::class));
//        });
//
//        $this->actingAs($this->user)
//             ->get(route('equipment.show', $this->equipment));
//    }
//
//    public function test_equipment_service_methods_are_called_correctly(): void
//    {
//        // Mock Auth facade
//        $userMock = Mockery::mock('stdClass');
//        $userMock->shouldReceive('isSysAdmin')->andReturn(true);
//        Auth::shouldReceive('user')->andReturn($userMock);
//
//        // Mock required document service methods
//        $this->documentService->shouldReceive('getDocumentList')
//                              ->once()
//                              ->with(Mockery::type(Equipment::class))
//                              ->andReturn(collect([]));
//
//        $this->documentService->shouldReceive('checkStorageSyncDB')
//                              ->once()
//                              ->with(Mockery::type(Equipment::class))
//                              ->andReturn(collect([]));
//
//        $this->documentService::shouldReceive('getFunctionTestDocumentList')
//                              ->once()
//                              ->with(Mockery::type(Equipment::class))
//                              ->andReturn(collect([]));
//
//        // Mock all required equipment service methods
//        $this->equipmentService->shouldReceive([
//            'checkUserQualified' => true,
//            'getUpcomingControlItems' => collect([]),
//            'getOneTimeControlItems' => collect([]),
//            'getAllControlItems' => collect([]),
//            'getInstruectedPersonList' => collect([]),
//            'getRequirementList' => collect([]),
//            'getRecentExecutedControls' => collect([]),
//            'makeCompanyString' => 'Test Company',
//            'getParamList' => collect([])
//        ]);
//
//        // Mock other database queries
//        ProduktDoc::shouldReceive('where->get')->andReturn(collect([]));
//        ControlInterval::shouldReceive('select->get')->andReturn(collect([]));
//        EquipmentQualifiedUser::shouldReceive('with->where->get')->andReturn(collect([]));
//        Anforderung::shouldReceive('select->get')->andReturn(collect([]));
//        DocumentType::shouldReceive('all')->andReturn(collect([]));
//        User::shouldReceive('select->get')->andReturn(collect([]));
//
//        // Mock EquipmentAction static methods
//        $this->mock('alias:App\Http\Actions\Equipment\EquipmentAction', function ($mock) {
//            $mock->shouldReceive('deleteLoseEquipmentDocumentEntries')->once();
//            $mock->shouldReceive('deleteLoseProductDocumentEntries')->once();
//            $mock->shouldReceive('deleteLoseRequirementEntries')->once();
//        });
//
//        // Mock Storage::find for null storage case
//        Storage::shouldReceive('find')
//               ->with($this->equipment->storage_id)
//               ->andReturn(null);
//
//        $response = $this->actingAs($this->user)
//                         ->get(route('equipment.show', $this->equipment));
//
//        $response->assertStatus(200);
//    }

    /**
     * Helper method to mock all service methods
     */
    private function mockServiceMethods(): void
    {
        // Mock Auth facade
        $userMock = Mockery::mock('stdClass');
        $userMock->shouldReceive('isSysAdmin')->andReturn(false);
        Auth::shouldReceive('user')->andReturn($userMock);

        // Mock EquipmentAction static methods
        $this->mock('alias:App\Http\Actions\Equipment\EquipmentAction', function ($mock) {
            $mock->shouldReceive('deleteLoseEquipmentDocumentEntries');
            $mock->shouldReceive('deleteLoseProductDocumentEntries');
            $mock->shouldReceive('deleteLoseRequirementEntries');
        });

        // Mock document service methods
        $this->documentService->shouldReceive('getDocumentList')->andReturn(collect([]));
        $this->documentService->shouldReceive('checkStorageSyncDB')->andReturn(collect([]));
        $this->documentService::shouldReceive('getFunctionTestDocumentList')->andReturn(collect([]));

        // Mock equipment service methods
        $this->equipmentService->shouldReceive([
            'checkUserQualified' => false,
            'getUpcomingControlItems' => collect([]),
            'getOneTimeControlItems' => collect([]),
            'getAllControlItems' => collect([]),
            'getInstruectedPersonList' => collect([]),
            'getRequirementList' => collect([]),
            'getRecentExecutedControls' => collect([]),
            'makeCompanyString' => '',
            'getParamList' => collect([])
        ]);

        // Mock database queries
        ProduktDoc::shouldReceive('where->get')->andReturn(collect([]));
        ControlInterval::shouldReceive('select->get')->andReturn(collect([]));
        EquipmentQualifiedUser::shouldReceive('with->where->get')->andReturn(collect([]));
        Anforderung::shouldReceive('select->get')->andReturn(collect([]));
        DocumentType::shouldReceive('all')->andReturn(collect([]));
        User::shouldReceive('select->get')->andReturn(collect([]));

        // Mock Storage::find
        Storage::shouldReceive('find')->andReturn(null);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}