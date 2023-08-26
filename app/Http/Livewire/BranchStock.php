<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class BranchStock extends Component
{
    use WithPagination;
    public $branchCode;
    public $valStocks;

    public function mount(Request $request)
    {
        $this->branchCode = $request->code;
    }

    public function decrement($branchId, $productId)
    {
        $stock = Stock::where([
            'branch_id' => $branchId,
            'product_id' => $productId
        ])->first();

        if ($stock) {
            if ($stock->quantity != 0) {
                $stock->update([
                    'quantity' => $stock->quantity - 1
                ]);
            }
        }

    }

    public function increment($branchId, $productId)
    {
        $stock = Stock::where([
            'branch_id' => $branchId,
            'product_id' => $productId
        ])->first();

        if ($stock) {
            $stock->update([
                'quantity' => $stock->quantity + 1
            ]);
        } else {
            Stock::create([
                'branch_id' => $branchId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
    }

    public function updatedValStocks()
    {
        dd($this->valStocks);
        $this->validate([
            'valStocks' => 'required|numeric'
        ]);
    }

    public function render()
    {
        $brachCode = Str::upper($this->branchCode);
        $branch = Branch::where('code', $brachCode)->first();

        return view('livewire.branch-stock', [
            'branch' => $branch,
        ])->extends('layouts.app');
    }
}
