<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddCategory extends Component
{
    use Actions;
    public $openModal = false;

    public $name;

    public function openModal()
    {
        $this->openModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $category = Category::create([
            'name' => $this->name
        ]);

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
