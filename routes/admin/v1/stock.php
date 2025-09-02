<?php

declare(strict_types = 1);

use App\Livewire\Admin\Stock;
use App\Models;
use Illuminate\Support\Facades\Route;

Route::get('/locations', Stock\Location\Index::class)->name('locations.index')->can('viewAny', Models\Location::class);
