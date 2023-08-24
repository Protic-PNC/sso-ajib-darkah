<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use WireUi\Traits\Actions;

class AddProduct extends Component
{
    use Actions;
    public $openModal = false;
    public $name;
    public $description;
    public $price;
    public $category;

    public function openModal()
    {
        $this->openModal = true;
    }

    public function save()
    {

        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);

        $product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'harga' => $this->price,
            'category_id' => $this->category
        ]);

        if ($product) {
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dibuat'
            );

            $this->reset('name', 'description', 'price', 'category');
            $this->emit('refresh');
            $this->openModal = false;
        }
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.product.add-product', [
            'categories' => $categories,
        ]);
    }
}
