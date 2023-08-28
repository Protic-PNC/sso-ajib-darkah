<div>
    <x-button icon="plus" primary label="Tambah User" wire:click="openModal" />

    <x-modal.card align="center" title="Tambah User" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nama" placeholder="" wire:model="name"/>
            <x-input label="Email" placeholder="" wire:model="email"/>

            <div class="col-span-1 sm:col-span-2 grid grid-cols-1 gap-y-3">

                <x-inputs.password label="Password" placeholder="" wire:model="password" hint="default '12345678'"/>

                <x-select
                    label="Pilih Cabang"
                    placeholder="Cabang"
                    multiselect
                    :options="$branches"
                    option-label="name"
                    option-value="id"
                    wire:model.defer="branchSelected"
                />

                <x-select
                    label="Pilih Role"
                    placeholder="Role"
                    multiselect
                    :options="$roles"
                    option-label="name"
                    option-value="id"
                    wire:model.defer="roleSelected"
                />

                <x-select
                    label="Pilih Permission"
                    placeholder="Permission"
                    multiselect
                    :options="$permissions"
                    option-label="name"
                    option-value="id"
                    wire:model.defer="permissionSelected"
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
