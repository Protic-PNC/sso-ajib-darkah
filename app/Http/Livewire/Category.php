<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category as Categories;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Category extends Component
{
    use Actions;
    use WithPagination;

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $openModal = false;

    public $name;

    public $categoryId;

    public function edit($id)
    {
        $this->openModal = true;

        $category = Categories::find($id);

        $this->categoryId = $category->id;
        $this->name = $category->name;
    }

    public function save($id)
    {
        $this->validate([
            'name' => 'required'
        ]);

        $category = Categories::find($id);

        if ($category) {
            $category->update([
                'name' => $this->name
            ]);

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diubah'
            );

            $this->reset('name');
            $this->emit('refresh');
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
        $category = Categories::find($id);

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
        $categories = Categories::query()->orderBy('id', 'DESC');

        return view('livewire.category', [
            'categories' => $categories->paginate(10),
        ])->extends('layouts.app');
    }
}
