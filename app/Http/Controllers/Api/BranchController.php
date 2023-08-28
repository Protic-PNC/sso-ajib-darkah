<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->id) {
                $branches = Branch::with('products')->where('id', $request->id)->get();
            }else {
                $branches = Branch::with('products')->get();
            }
            $dataBranches = [];

            foreach ($branches as $key => $branch) {
                $dataBranches[] = [
                    'id' => $branch->id,
                    'code' => $branch->code,
                    'name' => $branch->name,
                    'products' => $branch->products->map(function($product) use ($branch){
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'category' => $product->category->name,
                            'stocks' => $product->stocks->where('branch_id', $branch->id)->first()->quantity
                        ];
                    })
                ];
            }


            return response()->json([
                'status' => 'success',
                'data' => $dataBranches
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
