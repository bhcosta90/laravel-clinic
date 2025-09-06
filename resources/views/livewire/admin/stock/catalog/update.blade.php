<div>
    <form id="catalog-update-{{ $this->form->model?->hash_code }}" wire:submit="save" class="space-y-4">
        <x-admin.stock.catalog.form :updated="true" />
    </form>
</div>
