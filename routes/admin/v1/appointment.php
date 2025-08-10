<?php

declare(strict_types=1);

use App\Models;
use Illuminate\Support\Facades\Route;

Route::get('/appointments', App\Livewire\Admin\Appointments\Appointments\Index::class)->name('appointments.index')->can('viewAny', Models\Appointment::class);
