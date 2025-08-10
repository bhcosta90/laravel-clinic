<?php

declare(strict_types=1);

use App\Models;
use Illuminate\Support\Facades\Route;

Route::get('/commissions', App\Livewire\Admin\Financial\Commissions\Index::class)->name('commissions.index')->can('viewAny', Models\Commission::class);
Route::get('/{type}', App\Livewire\Admin\Financial\Transactions\Index::class)->name('transactions.index');
