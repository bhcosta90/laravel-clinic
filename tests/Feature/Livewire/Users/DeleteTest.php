<?php

declare(strict_types = 1);

use App\Livewire\Admin\Users\Delete;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertSoftDeleted;

beforeEach(fn () => $this->user = User::factory()->create());

it('renders the delete component', function (): void {
    Livewire::test(Delete::class, ['user' => $this->user])
        ->assertOk()
        ->assertSee('svg')
        ->assertSeeHtml('wire:click="confirm"');
});

it('calls confirm method', function (): void {
    Livewire::test(Delete::class, ['user' => $this->user])
        ->call('confirm')
        ->assertDispatched('tallstackui:dialog');
});

it('deletes user successfully', function (): void {
    $component = Livewire::test(Delete::class, ['user' => $this->user]);

    $component->call('delete');

    assertSoftDeleted($this->user);

    $component->assertDispatched('deleted');
});

it('handles deleting non-existent user', function (): void {
    $user = User::factory()->create();
    $user->delete();

    $component = Livewire::test(Delete::class, ['user' => $user]);

    $component->call('delete');

    assertSoftDeleted($user);
});

it('dispatches success after deletion', function (): void {
    Livewire::test(Delete::class, ['user' => $this->user])
        ->call('delete')
        ->assertDispatched('tallstackui:dialog');

    assertSoftDeleted($this->user);
});

it('confirms before deletion via question method', function (): void {
    Livewire::test(Delete::class, ['user' => $this->user])
        ->call('confirm')
        ->assertDispatched('tallstackui:dialog');

    assertModelExists($this->user);
});

it('passes correct user to delete method', function (): void {
    Livewire::test(Delete::class, ['user' => $this->user])->call('delete');

    assertSoftDeleted('users', ['id' => $this->user->id]);
});
