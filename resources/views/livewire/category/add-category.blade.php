<div>
    <x-button icon="plus" primary label="Tambah Category" wire:click="openModal" />

    <x-modal.card align="center" title="Tambah category" wire:model="openModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="col-span-1 sm:col-span-2">
                <x-input label="Nama" placeholder="cth Galon" wire:model="name" />

                <div class="grid gap-4 mt-4">
                    <div class="grid grid-cols-3 gap-4">
                        @if ($images)
                            @foreach ($images as $key => $image)
                            <div class="max-h-44 overflow-hidden flex justify-center items-center relative">
                                <div class="absolute w-full h-full hover:bg-[#00000031] flex justify-center items-center hover:opacity-100 opacity-0 ease-in-out duration-300">
                                    <span class="px-3 py-1 bg-red-600 text-white rounded-lg cursor-pointer" wire:click="delImg('{{ $key }}')">hapus</span>
                                </div>
                                <img src="{{ $image['image']->temporaryUrl() }}" class="" alt="{{ $image['image']->getClientOriginalName() }}">
                            </div>
                            @endforeach
                        @endif
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span><br> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input wire:model="image" id="dropzone-file" type="file" class="hidden" />
                            </label>
                        </div>
                    </div>
                </div>
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
