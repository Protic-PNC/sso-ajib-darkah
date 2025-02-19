<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Models\Product as ModelsProduct;

class Product extends Component
{
    use Actions;
    use WithPagination;

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $openModal = false;

    public $name;
    public $description;
    public $price;
    public $category;
    public $productId;

    public function edit($id)
    {
        $this->openModal = true;

        $product = ModelsProduct::find($id);

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->harga;
        $this->category = $product->category_id;
    }

    public function save($id)
    {

        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);

        $product = ModelsProduct::find($id);

        if ($product) {
            $product->update([
                'name' => $this->name,
                'description' => $this->description,
                'harga' => $this->price,
                'category_id' => $this->category
            ]);

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diubah'
            );

            $this->reset('name', 'description', 'price', 'category');
            $this->openModal = false;
        }
    }

    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title'       => 'Kamu Yakin?',
            'description' => 'Hapus data ini?',
            'acceptLabel' => 'Ya, Hapus',
            'method'      => 'delete',
            'params'      => $id,
        ]);
    }

    public function delete($id)
    {
        $category = ModelsProduct::find($id);

        if ($category) {
            $category->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dihapus'
            );
        }
    }


    public function render()
    {
        $products = ModelsProduct::query()->orderBy('id', 'DESC');
        $categories = Category::all();
        return view('livewire.product', [
            'products' => $products->paginate(10),
            'categories' => $categories,
        ])->extends('layouts.app');
    }
}
