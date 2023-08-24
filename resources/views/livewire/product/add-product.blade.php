<div>
    <x-button icon="plus" primary label="Tambah Produk"  wire:click="openModal"/>

    <x-modal.card align="center" title="Tambah Produk" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nama Produk" placeholder="Galon RO" wire:model="name"/>

            <x-inputs.currency
                label="Harga Produk"
                placeholder="Harga"
                thousands="."
                decimal=","
                precision="4"
                wire:model="price"
            />

            <div class="col-span-1 sm:col-span-2 grid gap-y-4">
                <x-textarea label="Deskripsi Produk" placeholder="write your annotations" wire:model="description"/>

                <x-select
                    label="Pilih Category"
                    placeholder="Pilih Kategori"
                    :options="$categories"
                    option-label="name"
                    option-value="id"
                    wire:model="category"
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
