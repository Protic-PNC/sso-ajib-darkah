<div>
    <div class="mb-6">
        <livewire:user.add-user />
    </div>

    <div>

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
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User Cabang
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User Role
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User Permission
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->branches()->pluck('name')->implode(', ') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ implode(', ', collect($user->getRoleNames())->toArray())}}
                        </td>
                        <td class="px-6 py-4">
                            {{ implode(', ', collect($user->getPermissionNames())->toArray()) }}
                        </td>
                        <td class="px-6 py-4">
                            <x-button icon="pencil" primary label="" wire:click="edit('{{ $user->id }}')"/>
                            <x-button icon="trash" negative  label="" wire:click="confirmDelete('{{ $user->id }}')"/>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">
                            No Data Found
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

            {{ $users->links() }}
    </div>

    <x-modal.card align="center" title="Tambah User" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nama" placeholder="" wire:model="name"/>
            <x-input label="Email" placeholder="" wire:model="email"/>

            <div class="col-span-1 sm:col-span-2 grid grid-cols-1 gap-y-3">

                <x-inputs.password label="Password" placeholder="" wire:model="password" hint="kosongkan jika tidak ingin di ubah"/>

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
                    <x-button primary label="Save" wire:click="save('{{ $userId }}')" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
