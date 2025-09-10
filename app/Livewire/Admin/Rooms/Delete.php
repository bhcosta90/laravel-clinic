<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Rooms;

use App\Livewire\Traits\Alert;
use App\Models\Room;
use App\Services\RoomService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Room $room;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-ui.button.circle icon="trash" color="red" wire:click="confirm" />
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {
        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        app(RoomService::class)->delete($this->room);

        $this->dispatch('deleted');

        $this->success();
    }
}
