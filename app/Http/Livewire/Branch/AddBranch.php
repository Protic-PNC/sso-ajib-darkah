<?php

namespace App\Http\Livewire\Branch;

use App\Models\Stock;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\GeneratesUniqueCode;

class AddBranch extends Component
{
    use Actions;
    use GeneratesUniqueCode;

    protected $listeners = [
        'mount' => 'mount'
    ];

    public $openModal = false;
    public $code;
    public $name;
    public $products;
    public $productSelected;

    public function mount()
    {
        $lastBranch = Branch::latest()->first();
        if ($lastBranch){
            $this->code = static::generateUniqueCode($lastBranch->code, 'CA', 4);
        }else{
            $this->code = 'CA0000';
        }
    }

    public function openModal()
    {
        $this->openModal = true;
        $this->products = Product::all();
    }

    public function save()
    {
        // dd($this->productSelected);
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'productSelected' => 'required'
        ]);

        // dd($this->code, $this->name);
        $branch = Branch::create([
            'code' => $this->code,
            'name' => $this->name,
        ]);

        foreach ($this->productSelected as $product) {
            $branch->products()->attach($product);

            $stock = Stock::firstOrCreate([
                'branch_id' => $branch->id,
                'product_id' => $product,
                'quantity' => 1
            ]);
        }

        if ($branch) {
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dibuat'
            );

            $this->reset('code', 'name', 'productSelected');
            $this->mount();
            $this->emit('refresh');
            $this->openModal = false;
        }
    }

    public function render()
    {
        return view('livewire.branch.add-branch');
    }
}
