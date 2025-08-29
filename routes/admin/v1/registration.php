<?php

declare(strict_types = 1);

use App\Livewire\Admin\Registration;
use App\Models;
use Illuminate\Support\Facades\Route;

Route::get('/procedures', Registration\Procedures\Index::class)->name('procedures.index')->can('viewAny', Models\Procedure::class);
Route::get('/agreements', Registration\Agreements\Index::class)->name('agreements.index')->can('viewAny', Models\Agreement::class);
Route::get('/payment-methods', Registration\PaymentMethods\Index::class)->name('payment-methods.index')->can('viewAny', Models\PaymentMethod::class);
Route::get('/frequencies', Registration\Frequencies\Index::class)->name('frequencies.index')->can('viewAny', Models\Frequency::class);
Route::get('/triage', Registration\Triage\Index::class)->name('triage.index')->can('viewAny', Models\Triage::class);
Route::get('/remedies', Registration\Remedies\Index::class)->name('remedies.index')->can('viewAny', Models\Remedy::class);
Route::get('/rooms', Registration\Rooms\Index::class)->name('rooms.index')->can('viewAny', Models\Room::class);
Route::get('/anamnesis-group', Registration\AnamnesisGroup\Index::class)->name('anamnesis-group.index')->can('viewAny', Models\AnamnesisGroup::class);
Route::get('/anamnesis-item', Registration\AnamnesisItem\Index::class)->name('anamnesis-item.index')->can('viewAny', Models\AnamnesisItem::class);

Route::get('/roles', Registration\Roles\Index::class)->name('roles.index')->can('viewAny', Models\Role::class);
Route::get('/roles/{role_hash}/permissions', Registration\Roles\Permission::class)->name('roles.permissions');
