@section('title', 'Category')

<div>
    <div class="mb-6">
        <livewire:category.add-category />
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
                    <th scope="col" class="px-6 py-3 w-10">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Categori
                    </th>
                    <th scope="col" class="px-6 py-3">
                         Created At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Updated At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}
                    </th>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        <img src="{{ $category->images->first()->image }}" class="w-16" alt="">
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $category->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $category->created_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $category->updated_at }}
                    </td>
                    <td class="px-6 py-4">
                        <x-button icon="pencil" primary label="" wire:click="edit('{{ $category->id }}')"/>
                        <x-button icon="trash" negative  label="" wire:click="confirmDelete('{{ $category->id }}')"/>
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

        <div class="px-5 py-7">
        {{ $categories->links() }}
        </div>
    </div>

    <x-modal.card align="center" title="Edit category" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="col-span-1 sm:col-span-2">
                <x-input label="Nama" placeholder="cth Galon" wire:model="name"/>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="save('{{ $categoryId }}')" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
