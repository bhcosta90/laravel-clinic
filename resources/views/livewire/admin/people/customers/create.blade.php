<div>
    @if($this->showButton)
        <x-button :text="__('Create New Patient')" wire:click="$toggle('slide')" outline />
    @endif

    <x-ui.action size="3xl" :title="__('Create New Customer')">
        <form id="customer-create-{{ $id = str()->uuid() }}" wire:submit="save" class="space-y-4">
            <x-admin.people.customers.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="customer-create-{{ $id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
