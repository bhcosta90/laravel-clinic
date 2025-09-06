<?php

declare(strict_types = 1);

use App\Livewire\Admin\Stock\Catalog;
use App\Models;

use Illuminate\Support\Facades\Route;

Route::get('/', Catalog\Index::class)->name('index')->can('viewAny', Models\Catalog::class);
Route::get('/{catalog_hash}/update', Catalog\Update::class)->name('update');
