<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Triage;

use App\Enums\Models\Triage\RiskClassification;
use App\Models\Customer;
use App\Models\Triage;
use App\Services\TriageService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Triage $model = null;

    public $customer_id;
    public $risk_classification;
    public $description;
    public $mmhg;
    public $bpm;
    public $irpm;
    public $allergy;
    public $current_medication;
    public $history_diseases;
    public $time_symptom_onset;
    public $general_condition;
    public $temperature;
    public $saturation;
    public $eva;

    public function setModel(Triage $model): void
    {
        $this->model               = $model;
        $this->customer_id         = $model->customer_id;
        $this->risk_classification = $model->risk_classification;
        $this->description         = $model->description;
        $this->mmhg                = $model->mmhg;
        $this->bpm                 = $model->bpm;
        $this->irpm                = $model->irpm;
        $this->allergy             = $model->allergy;
        $this->current_medication  = $model->current_medication;
        $this->history_diseases    = $model->history_diseases;
        $this->time_symptom_onset  = $model->time_symptom_onset;
        $this->general_condition   = $model->general_condition;
        $this->temperature         = $model->temperature;
        $this->saturation          = $model->saturation;
        $this->eva                 = $model->eva;
    }

    public function save(): Triage
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(TriageService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(TriageService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'customer_id'         => ['nullable', Rule::exists(Customer::class, 'id')],
            'risk_classification' => ['required', Rule::enum(RiskClassification::class)],
            'description'         => ['required', 'string', 'max:240'],
            'mmhg'                => ['nullable', 'string', 'max:240'],
            'bpm'                 => ['nullable', 'string', 'max:240'],
            'irpm'                => ['nullable', 'string', 'max:240'],
            'allergy'             => ['nullable', 'string', 'max:240'],
            'current_medication'  => ['nullable', 'string', 'max:240'],
            'history_diseases'    => ['nullable', 'string', 'max:240'],
            'time_symptom_onset'  => ['nullable', 'string', 'max:240'],
            'general_condition'   => ['nullable', 'string', 'max:240'],
            'temperature'         => ['nullable', 'integer', 'min:0'],
            'saturation'          => ['nullable', 'integer', 'min:0', 'max:100'],
            'eva'                 => ['nullable', 'integer', 'min:0', 'max:10'],
        ];
    }
}
