<div>
    <x-button icon="plus" primary label="Tambah Category" wire:click="openModal" />

    <x-modal.card align="center" title="Tambah category" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="col-span-1 sm:col-span-2">
                <x-input label="Nama" placeholder="cth Galon" wire:model="name"/>
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
