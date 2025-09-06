<div class="space-y-3">
    <x-admin.stock.catalog.nav-bar :code="$this->catalog->hash_code" />

    <livewire:admin.stock.packing.index :model="$this->catalog" />
</div>
