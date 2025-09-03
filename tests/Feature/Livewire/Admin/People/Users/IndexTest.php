<?php

declare(strict_types = 1);

use App\Livewire\Admin\People\Users\Index;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->auth = makeUser();

    User::factory()->count(15)->create(['tenant_id' => tenant()->id]);
});

it('renders the users index component', function (): void {
    Livewire::test(Index::class)
        ->assertOk()
        ->assertViewIs('livewire.admin.people.users.index');
});

it('initializes with default settings', function (): void {
    Livewire::test(Index::class)
        ->assertSet('quantity', 5)
        ->assertSet('search', null)
        ->assertSet('sort', [
            'column'    => 'name',
            'direction' => 'asc',
        ]);
});

it('verifies component headers', function (): void {
    $component = Livewire::test(Index::class);

    $headers = [
        ['index' => 'name', 'label' => __('Name')],
        ['index' => 'role.name', 'label' => __('Role')],
        ['index' => 'created_at', 'label' => __('Created')],
        ['index' => 'action', 'sortable' => false],
    ];

    $component->assertSet('headers', $headers);
});

it('fetches paginated users excluding authenticated user', function (): void {
    $rows = Livewire::test(Index::class)->get('rows');

    expect($rows)
        ->toBeInstanceOf(Paginator::class)
        ->and(count($rows))
        ->toBe(5)
        ->and($rows->pluck('id'))->not()->toContain($this->auth->id);

});

it('filters users by search term', function (): void {
    $user = User::factory()->create([
        'tenant_id' => tenant()->id,
        'name'      => 'John Unique Searchable',
        'email'     => 'john.unique@example.com',
    ]);

    $component = Livewire::test(Index::class)
        ->set('search', 'John Unique');

    $rows = $component->get('rows');

    expect(count($rows))
        ->toBe(1)
        ->and($rows->first()->id)
        ->toBe($user->id);
});

it('supports searching by email', function (): void {
    $user = User::factory()->create([
        'tenant_id' => tenant()->id,
        'name'      => 'Unique Search User',
        'email'     => 'unique.searchable@example.com',
    ]);

    $component = Livewire::test(Index::class)->set('search', 'unique.searchable');

    $rows = $component->get('rows');

    expect(count($rows->items()))
        ->toBe(1)
        ->and($rows->first()->id)
        ->toBe($user->id);
});

it('supports changing pagination quantity', function (): void {
    $component = Livewire::test(Index::class)->set('quantity', 5);

    $rows = $component->get('rows');

    expect($rows->perPage())
        ->toBe(5)
        ->and(count($rows))
        ->toBe(5);
});

it('supports sorting by different columns', function (): void {
    $component = Livewire::test(Index::class)
        ->set('sort', [
            'column'    => 'name',
            'direction' => 'asc',
        ]);

    $sort = $component->get('rows')->pluck('name')->toArray();

    expect($sort === array_values(Arr::sort($sort)))->toBeTrue();
});

it('handles empty search results', function (): void {
    $component = Livewire::test(Index::class)->set('search', 'non-existent-user');

    expect(count($component->get('rows')->items()))->toBe(0);
});
