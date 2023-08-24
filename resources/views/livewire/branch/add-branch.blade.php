<div>
    <x-button icon="plus" primary label="Tambah Cabang" wire:click="openModal" />

    <x-modal.card align="center" title="Tambah Cabang" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Kode Cabang" placeholder="CA0001" wire:model="code"/>
            <x-input label="Nama Cabang" placeholder="Cabang 1" wire:model="name"/>

            <div class="col-span-1 sm:col-span-2">
                <x-select
                    label="Produk"
                    placeholder="Pilih beberapa produk"
                    multiselect
                    :options="$products"
                    option-value="id"
                    option-label="name"
                    wire:model="productSelected"
                />
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="save" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
