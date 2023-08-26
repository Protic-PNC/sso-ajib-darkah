<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branchId = $request->branch;
        $productId = $request->product;


        try{
            $stock = Stock::where([
                'branch_id' => $branchId,
                'product_id' => $productId
            ])->first();

            if ($stock) {

                return response()->json([
                    'status' => 'success',
                    'data' => $stock
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stock not found',
                    'data' => []
                ], 404);
            }

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
    public function update(Request $request)
    {
        $branchId = $request->branch;
        $productId = $request->product;

        $quantity = request('quantity');

        try {
            if ($quantity < 0) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Quantity must be greater than 0'
                ], 405);

            } else {

                $stock = Stock::where([
                    'branch_id' => $branchId,
                    'product_id' => $productId
                ]);

                if ($stock->exists()) {
                    $stock->update([
                        'quantity' => request('quantity')
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'data' => 'Stock updated'
                    ], 200);

                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Stock not found',
                        'data' => []
                    ], 404);
                }

            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
