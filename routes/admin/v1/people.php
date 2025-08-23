<?php

declare(strict_types = 1);

use App\Livewire\Admin\People;
use App\Models;
use Illuminate\Support\Facades\Route;

Route::get('/users', People\Users\Index::class)->name('users.index')->can('viewAny', Models\User::class);
Route::get('/users/{user_hash}/permissions', People\Users\Permission::class)->name('users.permissions');
Route::get('/user/profile', People\User\Profile::class)->name('user.profile');

Route::get('/employees', People\Employees\Index::class)->name('employees.index')->can('viewEmployeeAny', Models\User::class);

Route::get('/customers', People\Customers\Index::class)->name('customers.index')->can('viewAny', Models\Customer::class);
Route::get('/customers/birthday', People\Customers\Birthday::class)->name('customers.birthday')->can('birthday', Models\Customer::class);
