<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Models\Branch as ModelsBranch;
use App\Models\Stock;

class Branch extends Component
{
    use Actions;
    use WithPagination;

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $openModal = false;
    public $code;
    public $name;
    public $branchId;
    public $products;
    public $productSelected;

    public function edit($id)
    {
        $branch = ModelsBranch::find($id);
        $this->products = Product::all();
        $this->productSelected = $branch->products->pluck('id')->toArray();

        if ($branch) {
            $this->branchId = $branch->id;
            $this->code = $branch->code;
            $this->name = $branch->name;
            $this->openModal = true;
        } else {
            $this->notification()->error(
                $title = 'Gagal',
                $description = 'Data tidak ditemukan'
            );
        }
    }

    public function save($id)
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'productSelected' => 'required',
        ]);

        $branch = ModelsBranch::find($id);

        $branch->products()->sync($this->productSelected);

        if ($branch) {
            $branch->update([
                'code' => $this->code,
                'name' => $this->name,
            ]);

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diubah'
            );

            $this->reset('code', 'name');
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
        $branch = ModelsBranch::find($id);

        if ($branch) {
            $branch->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dihapus'
            );

            $this->emit('mount');
        }
    }

    public function render()
    {
        $branches = ModelsBranch::query()->orderBy('id', 'ASC');
        return view('livewire.branch', [
            'branches' => $branches->paginate(10),
        ])->extends('layouts.app');
    }
}
