<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AddProduct extends Component
{
    use Actions;
    use WithFileUploads;
    public $openModal = false;
    public $name;
    public $description;
    public $price;
    public $category;
    public $images = [];
    public $image;

    public function openModal()
    {
        $this->openModal = true;
    }

    public function updatedImage()
    {
        $this->images[] = [
            'image' => $this->image
        ];

        $this->image = null;
    }

    public function delImg($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);

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
            'slug' => Str::slug($this->name, '-'),
            'description' => $this->description,
            'harga' => $this->price,
            'category_id' => $this->category
        ]);

        $this->validate([
            'images.image.*' => 'image|max:2048',
        ]);

        foreach ($this->images as $image) {
            $imageName = Str::random(20) . '.' . $image['image']->getClientOriginalExtension();
            $image['image']->storeAs('public/product', $imageName);

            $product->images()->create([
                'image' => env('APP_URL').'/storage/product/'.$imageName
            ]);
        }

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
