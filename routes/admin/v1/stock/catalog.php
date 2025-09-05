<?php

declare(strict_types = 1);

use App\Livewire\Admin\Stock\Catalog;
use App\Models;

use Illuminate\Support\Facades\Route;

Route::get('/', Catalog\Index::class)->name('index')->can('viewAny', Models\Catalog::class);
Route::get('/{id}/ean', Catalog\Index::class)->name('id.ean')->can('viewAny', Models\Catalog::class);
