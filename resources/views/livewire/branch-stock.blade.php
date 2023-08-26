@section('title', 'Cabang Stok')

<div>
    <div class="bg-white shadow-md p-10 mb-5 rounded-lg border">
        <div class="flex items-center">
            <div class="w-auto pr-4">
                <x-button rounded outline primary icon="chevron-left" label="Kembali" href="{{ route('cabang') }}"/>
            </div>
            <div class="w-4/12">
                <p class="font-semibold text-base text-gray-600"><span class="font-normal">Kode Cabang:</span> {{ $branch->code }}</p>
            </div>
            <div class="w-6/12">
                <p class="font-semibold text-base text-gray-600"><span class="font-normal">Nama Cabang:</span> {{ $branch->name }}</p>
            </div>
        </div>
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
                        Nama Produk
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Qty
                    </th>
                    <th scope="col" class="px-6 py-3">
                        harga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kategori
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branch->products as $product)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {{ $product->name }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <button wire:click="decrement('{{ $branch->id }}', '{{ $product->id }}')" @if (($product->stocks->where('branch_id', $branch->id)->first()->quantity ?? 0) == 0)
                                disabled
                            @endif
                                class="inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <div>
                                {{-- <p>{{ $product->stocks->where('product_id', $product->id)->first()->quantity ?? 0 }}</p> --}}
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-auto max-w-fit border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="0" required value="{{ $product->stocks->where('branch_id', $branch->id)->first()->quantity ?? 0 }}">
                            </div>
                            <button wire:click="increment('{{ $branch->id }}','{{ $product->id }}')"
                                class="inline-flex items-center justify-center h-6 w-6 p-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {{ $product->harga }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {{ $product->category->name }}
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

        {{-- {{ $branch->products->links() }} --}}
    </div>
</div>
