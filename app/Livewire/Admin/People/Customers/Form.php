<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\Customers;

use App\Models\Customer;

final class Form extends \Livewire\Form
{
    public ?Customer $model = null;

    public $name;
    public $birthday;
    public $document;

    public function setModel(Customer $model): void
    {
        $this->model    = $model;
        $this->name     = $model->name;
        $this->birthday = $model->birthday;
        $this->document = $model->document;
    }

    public function save(): Customer
    {
        $data = $this->validate();

        if ($this->model?->id) {
            $this->model->update($data);

            return $this->model;
        }

        return Customer::create($data);
    }

    public function rules(): array
    {
        return [
            'name'     => ['required',  'string',  'max:255'],
            'birthday' => ['required', 'date', 'before_or_equal:today'],
            'document' => ['required', 'string'],
        ];
    }
}
