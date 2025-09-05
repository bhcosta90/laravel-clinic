<?php

declare(strict_types = 1);

use App\Livewire\Admin\Stock;
use App\Models;

use Illuminate\Support\Facades\Route;

Route::prefix('/modules')->name('modules.')->group(function (): void {
    Route::get('/', Stock\LocationModule\Index::class)->name('index')->can('viewAny', Models\LocationModule::class);
    Route::get('/{module_location_hash}/location', Stock\LocationModule\Location\Index::class)->name('id.location')->can('viewAny', Models\LocationModule::class);
});

Route::get('/locations', Stock\Location\Index::class)->name('index')->can('viewAny', Models\Location::class);
