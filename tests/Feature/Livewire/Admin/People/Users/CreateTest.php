<?php

declare(strict_types = 1);

use App\Livewire\Admin\People\Users\Create;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(fn () => User::query()->delete());

it('renders the create user component', function (): void {
    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.admin.people.users.create');
});

it('initializes with a new user', function (): void {
    Livewire::test(Create::class)
        ->assertSet('form.password', null)
        ->assertSet('form.password_confirmation', null);
});

it('validates user creation with valid data', function (): void {
    makeUser();

    $data = [
        'form.name'                  => 'John Doe',
        'form.email'                 => 'john@example.com',
        'form.password'              => 'password123',
        'form.password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('users', [
        'name'  => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('requires name', function (): void {
    Livewire::test(Create::class)
        ->set('form.name', '')
        ->set('form.email', 'john@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['form.name' => 'required']);
});

it('requires unique email', function (): void {
    Auth::login(User::factory()->createTenant()->create());
    User::create([
        'name'     => 'Existing User',
        'email'    => 'existing@example.com',
        'password' => bcrypt('password123'),
    ]);

    Livewire::test(Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'existing@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['form.email' => 'unique']);
});

it('validates email format', function (): void {
    Livewire::test(Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'invalid-email')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['form.email' => 'email']);
});

it('requires password confirmation', function (): void {
    Livewire::test(Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'different-password')
        ->call('save')
        ->assertHasErrors(['form.password' => 'confirmed']);
});

it('sets email verified at when creating user', function (): void {
    Auth::login(User::factory()->createTenant()->create());
    $data = [
        'form.name'                  => 'John Doe',
        'form.email'                 => 'john@example.com',
        'form.password'              => 'password123',
        'form.password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save');

    $user = User::where('email', 'john@example.com')->first();

    expect($user->email_verified_at)->toBeNull();
});

it('resets form after successful creation', function (): void {
    Auth::login(User::factory()->createTenant()->create());
    $data = [
        'form.name'                  => 'John Doe',
        'form.email'                 => 'john@example.com',
        'form.password'              => 'password123',
        'form.password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save')
        ->assertSet('form.password', null)
        ->assertSet('form.password_confirmation', null);
});

it('dispatches created event', function (): void {
    Auth::login(User::factory()->createTenant()->create());
    $data = [
        'form.name'                  => 'John Doe',
        'form.email'                 => 'john@example.com',
        'form.password'              => 'password123',
        'form.password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save')
        ->assertDispatched('created');
});
