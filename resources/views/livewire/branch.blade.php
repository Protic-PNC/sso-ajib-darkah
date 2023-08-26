@section('title', 'Cabang')

<div>
    <div class="mb-6">
        <livewire:branch.add-branch />
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border bg-white">
        <div class="flex items-center justify-between p-4">
            <div>
                {{-- dropdown --}}
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for items">
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Kode cabang
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama cabang
                    </th>
                    <th scope="col" class="px-6 py-3">
                         Produk
                    </th>
                    <th scope="col" class="px-6 py-3 text-end">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branches as $branch)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $branch->code }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $branch->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ implode(', ', collect($branch->products()->pluck('name'))->toArray())}}
                    </td>
                    <td class="px-6 py-4 flex flex-grow justify-end gap-1">

                        <x-button icon="pencil" positive label="Stock" href="{{ route('cabang.stock', ['code' => Str::lower($branch->code)]) }}"/>
                        <x-button icon="pencil" primary class="pb-2 pt-2.5" label="" wire:click="edit('{{ $branch->id }}')"/>
                        <x-button icon="trash" negative class="pb-2 pt-2.5"  label="" wire:click="confirmDelete('{{ $branch->id }}')"/>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center">
                        No Data Found
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

        {{ $branches->links() }}
    </div>

    <x-modal.card align="center" title="Edit Cabang" wire:model="openModal">
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
                    wire:model.defer="productSelected"
                />
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="save('{{ $branchId }}')" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
