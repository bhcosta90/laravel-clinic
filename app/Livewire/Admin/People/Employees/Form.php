<?php

declare(strict_types=1);

namespace App\Livewire\Admin\People\Employees;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class Form extends \Livewire\Form
{
    public ?User $model = null;

    public $name;
    public $email;
    public $cellphone;
    public $address;
    public $commission;
    public $payment_data;
    public $role_id;
    public $password;
    public $password_confirmation;

    public function setModel(User $model): void
    {
        $this->model        = $model;
        $this->name         = $model->name;
        $this->email        = $model->email;
        $this->cellphone    = $model->cellphone;
        $this->address      = $model->address;
        $this->commission   = $model->commission;
        $this->payment_data = $model->payment_data;
        $this->role_id      = $model->role_id;
    }

    public function save(): User
    {
        $data = $this->validate();

        if ($this->model?->id) {
            $this->model->update($data);

            return $this->model;
        }

        return User::create($data + ['is_employee' => true]);
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($this->model?->id),
            ],
            'cellphone'    => ['nullable', 'max:255'],
            'address'      => ['nullable', 'max:255'],
            'commission'   => ['nullable', 'numeric'],
            'payment_data' => ['nullable', 'string'],
            'role_id'      => ['nullable', Rule::exists(Role::class, 'id')],
            'password'     => [
                'nullable',
                Rule::requiredIf(blank($this->model?->id)),
                Password::default(),
                'confirmed',
            ],
        ];
    }
}
