<?php

declare(strict_types = 1);

namespace App\Livewire\Error;

use App\Services\ErrorService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

final class Index extends Component
{
    public int $type;
    public ?Collection $messageErrors = null;

    public function mount(): void
    {
        $this->updatedMessageError();
    }

    public function render(): View
    {
        return view('livewire.error.index');
    }

    public function updatedMessageError(): void
    {
        $this->messageErrors = app(ErrorService::class)->index(null, [
            '(user_id)' => $this->getUserIdProperty(),
        ])->get();
    }

    public function getUserIdProperty(): int
    {
        return (int) auth()->id();
    }

    public function getTypeProperty(): int
    {
        return $this->type;
    }

    public function getListeners(): array
    {
        return [
            'echo-private:App.Models.LocationError.{userId}.{type},Location\\LocationErrorEvent' => 'updatedMessageError',
        ];
    }
}
