<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AddCategory extends Component
{
    use Actions;
    use WithFileUploads;

    protected $listeners = [
        'refresh' => '$refresh'
    ];
    public $openModal = false;

    public $name;

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
            'name' => 'required'
        ]);

        $category = Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name, '-'),
        ]);

        $this->validate([
            'images.image.*' => 'image|max:2048',
        ]);

        foreach ($this->images as $image) {
            $imageName = Str::random(20) . '.' . $image['image']->getClientOriginalExtension();
            $image['image']->storeAs('public/category', $imageName);

            $category->images()->create([
                'image' => env('APP_URL').'/storage/category/'.$imageName
            ]);
        }

        if ($category) {
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dibuat'
            );

            $this->reset('name');
            $this->emit('refresh');
            $this->openModal = false;
        }
    }

    public function render()
    {
        return view('livewire.category.add-category');
    }
}
