<?php

declare(strict_types = 1);

use App\Enums\Models\Location\Status;
use App\Enums\Models\Location\Type;
use App\Enums\Models\Location\Zone;
use App\Jobs\LocationModule\OrderColumnJob;
use App\Livewire\Admin\Stock\LocationModule\Location\Create;
use App\Models\Location;
use App\Models\LocationModule;
use App\Models\Sector;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    makeUser();

    $this->service = app(App\Services\LocationService::class);
    $this->data    = [
        'location_module_id' => ($this->locationModule = LocationModule::factory()->create(['tenant_id' => tenant()->id]))->id,
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

test('it stores locations with buck and validates database state', function (): void {
    $this->service->handle('storeWithBuck', $this->data);
    assertDatabaseCount(Location::class, 8);

    assertDatabaseHas(Location::class, [
        'location_module_id' => $this->locationModule->id,
        'aisle'              => $this->locationModule->acronym,
        'column'             => 1,
        'level'              => 1,
        'position'           => 1,
        'sequence'           => 70,
    ]);

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
        'location_module_id' => $this->locationModule->id,
        'aisle'              => $this->locationModule->acronym,
        'column'             => 2,
        'level'              => 0,
        'position'           => 0,
        'sequence'           => 80,
    ]);
});

test('it orders locations by sequence and validates their attributes', function (): void {
    $data = [
        'column_initial'   => 0,
        'column_final'     => 3,
        'level_initial'    => 0,
        'level_final'      => 3,
        'position_initial' => 0,
        'position_final'   => 3,
    ];
    Livewire::test(Create::class, ['locationModule' => $this->locationModule])
        ->set($data += Illuminate\Support\Arr::except($this->data, 'location_module_id'))
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseCount(Location::class, 64);

    OrderColumnJob::dispatch($this->locationModule->id, 'sequence');
    $location = Location::orderBy('sequence')->get();

    $model = $location->get(0);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0)
        ->and($model->sequence)->toBe(0);

    $model = $location->get(1);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(15);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);

    $model = $location->get(16);
    expect($model->column)->toBe(1)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0)
        ->and($model->sequence)->toBe(160);

    $model = $location->get(17);
    expect($model->column)->toBe(1)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1)
        ->and($model->sequence)->toBe(170);
});

test('it orders locations by even and odd, and validates their attributes', function (): void {
    $data = [
        'column_initial'   => 0,
        'column_final'     => 5,
        'level_initial'    => 0,
        'level_final'      => 3,
        'position_initial' => 0,
        'position_final'   => 3,
    ];
    Livewire::test(Create::class, ['locationModule' => $this->locationModule])
        ->set($data += Illuminate\Support\Arr::except($this->data, 'location_module_id'))
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseCount(Location::class, 96);

    OrderColumnJob::dispatch($this->locationModule->id, 'even_odd');
    $location = Location::orderBy('sequence')->get();

    $model = $location->get(0);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(1);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(15);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);

    $model = $location->get(16);
    expect($model->column)->toBe(2)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(17);
    expect($model->column)->toBe(2)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(47);
    expect($model->column)->toBe(4)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);

    $model = $location->get(48);
    expect($model->column)->toBe(5)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(49);
    expect($model->column)->toBe(5)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(64);
    expect($model->column)->toBe(3)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(95);
    expect($model->column)->toBe(1)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);
});

test('it orders locations by odd and even, and validates their attributes', function (): void {
    $data = [
        'column_initial'   => 0,
        'column_final'     => 5,
        'level_initial'    => 0,
        'level_final'      => 3,
        'position_initial' => 0,
        'position_final'   => 3,
    ];
    Livewire::test(Create::class, ['locationModule' => $this->locationModule])
        ->set($data += Illuminate\Support\Arr::except($this->data, 'location_module_id'))
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseCount(Location::class, 96);

    OrderColumnJob::dispatch($this->locationModule->id, 'odd_even');
    $location = Location::orderBy('sequence')->get();

    $model = $location->get(0);
    expect($model->column)->toBe(1)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(1);
    expect($model->column)->toBe(1)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(15);
    expect($model->column)->toBe(1)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);

    $model = $location->get(16);
    expect($model->column)->toBe(3)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(17);
    expect($model->column)->toBe(3)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(47);
    expect($model->column)->toBe(5)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);

    $model = $location->get(48);
    expect($model->column)->toBe(4)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(49);
    expect($model->column)->toBe(4)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(1);

    $model = $location->get(64);
    expect($model->column)->toBe(2)
        ->and($model->level)->toBe(0)
        ->and($model->position)->toBe(0);

    $model = $location->get(95);
    expect($model->column)->toBe(0)
        ->and($model->level)->toBe(3)
        ->and($model->position)->toBe(3);
});
