<div>
    <x-dropdown>
        <x-slot:action>
            <x-button :text="__('Sort column')" x-on:click="show = !show" icon="bars-3" outline color="secondary" />
        </x-slot:action>
        <x-dropdown.items wire:click="confirm('odd_even')" :text="__('Column by odd and even')" />
        <x-dropdown.items wire:click="confirm('even_odd')" :text="__('Column by even and odd')" />
        <x-dropdown.items wire:click="confirm('sequence')"  :text="__('Column sequence')" />
    </x-dropdown>
</div>
