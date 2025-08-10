<div class="bg-amber-500 w-full px-2 py-4 text-2xl text-center cursor-pointer" wire:click="exec">
    @lang('Você esta personando como <b>:name</b>', ['name' => auth()->user()->name])
</div>
