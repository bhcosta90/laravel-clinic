<?php

declare(strict_types = 1);

use App\Livewire\Admin\People\Users\Update;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->original = User::factory()->createTenant()->create([
        'name'  => 'Original Name',
        'email' => 'original@example.com',
    ]);
});

it('renders the update user component', function (): void {
    Livewire::test(Update::class, ['form.model' => $this->original])
        ->assertOk()
        ->assertViewIs('livewire.admin.people.users.update');
});

it('initializes with existing user data', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->assertSet('form.model.name', 'Original Name')
        ->assertSet('form.model.email', 'original@example.com')
        ->assertSet('form.password', null)
        ->assertSet('form.password_confirmation', null);
});

it('load the correct use', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->assertSet('form.model.name', 'Original Name')
        ->assertSet('form.model.email', 'original@example.com')
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('updates user name and email', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.name', 'Updated Name')
        ->set('form.email', 'updated@example.com')
        ->call('save')
        ->assertHasNoErrors();

    $updated = User::find($this->original->id);

    expect($updated->name)
        ->toBe('Updated Name')
        ->and($updated->email)
        ->toBe('updated@example.com');
});

it('requires name', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.name', '')
        ->set('form.email', 'updated@example.com')
        ->call('save')
        ->assertHasErrors(['form.name' => 'required']);
});

it('validates unique email with ignore', function (): void {
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.email', 'existing@example.com')
        ->call('save')
        ->assertHasErrors(['form.email' => 'unique']);
});

it('updates password when provided', function (): void {
    $old = $this->original->password;

    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.password', 'new-password-123')
        ->set('form.password_confirmation', 'new-password-123')
        ->call('save')
        ->assertHasNoErrors();

    $updated = User::find($this->original->id);

    expect($updated->password)->not()->toBe($old);
});

it('does not update password when not provided', function (): void {
    $old = $this->original->password;

    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.name', 'Updated Name')
        ->call('save')
        ->assertHasNoErrors();

    $updated = User::find($this->original->id);

    expect($updated->password)->toBe($old);
});

it('requires password confirmation', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.password', 'new-password-123')
        ->set('form.password_confirmation', 'different-password')
        ->call('save')
        ->assertHasErrors(['form.password' => 'confirmed']);
});

it('dispatches updated event', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.name', 'Updated Name')
        ->call('save')
        ->assertDispatched('updated');
});

it('resets form after successful update', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.name', 'Updated Name')
        ->set('form.password', 'new-password-123')
        ->set('form.password_confirmation', 'new-password-123')
        ->call('save')
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('validates email format', function (): void {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('form.email', 'invalid-email')
        ->call('save')
        ->assertHasErrors(['form.email' => 'email']);
});
