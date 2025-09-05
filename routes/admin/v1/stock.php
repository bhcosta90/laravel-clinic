<?php

declare(strict_types = 1);

use App\Livewire\Admin\Stock;
use App\Models;
use Illuminate\Support\Facades\Route;

Route::get('sectors', Stock\Sector\Index::class)->name('sector.index')->can('viewAny', Models\Sector::class);

Route::prefix('catalogs')->as('catalog.')->group(base_path('routes/admin/v1/stock/catalog.php'));
Route::prefix('location')->as('location.')->group(base_path('routes/admin/v1/stock/location.php'));
