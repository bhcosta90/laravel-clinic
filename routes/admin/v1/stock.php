<?php

declare(strict_types = 1);

use App\Livewire\Admin\Stock;
use App\Models;
use Illuminate\Support\Facades\Route;

Route::prefix('location')->group(function () {
    Route::get('/locations', Stock\Location\Index::class)->name('locations.index')->can('viewAny', Models\Location::class);
    Route::get('/location-modules', Stock\LocationModule\Index::class)->name('location-modules.index')->can('viewAny', Models\LocationModule::class);
});
