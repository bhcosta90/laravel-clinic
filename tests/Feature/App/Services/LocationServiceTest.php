<?php

declare(strict_types = 1);

use App\Enums\Models\Location\Status;
use App\Enums\Models\Location\Type;
use App\Enums\Models\Location\Zone;
use App\Models\Location;
use App\Models\LocationModule;
use App\Models\Sector;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    makeUser();

    $this->service = app(App\Services\LocationService::class);
    $this->data    = [
        'location_module_id' => ($this->locationModule = LocationModule::factory()->create())->id,
        'sector_id'          => Sector::factory()->create()->id,
        'type'               => Type::Picking->value,
        'zone'               => Zone::A->value,
        'column_initial'     => 0,
        'column_final'       => 1,
        'level_initial'      => 0,
        'level_final'        => 1,
        'position_initial'   => 0,
        'position_final'     => 1,
        'status'             => Status::Enabled->value,
    ];
});

test('it stores locations with buck and validates database state', function () {
    $this->service->handle('storeWithBuck', $this->data);
    assertDatabaseCount(Location::class, 8);

    $this->service->handle('storeWithBuck', [
        'column_initial'   => 2,
        'column_final'     => 2,
        'level_initial'    => 0,
        'level_final'      => 0,
        'position_initial' => 0,
        'position_final'   => 0,
    ] + $this->data);

    assertDatabaseCount(Location::class, 9);
    assertDatabaseHas(Location::class, [
        'aisle'    => $this->locationModule->acronym,
        'column'   => 2,
        'level'    => 0,
        'position' => 0,
        'sequence' => 900,
    ]);
});
