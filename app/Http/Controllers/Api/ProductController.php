<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if (isset($request->branch) && !isset($request->id) && !isset($request->slug)) {
                $products = Product::with('category', 'images')
                            ->whereHas('branches', function ($query) use ($request) {
                                $query->where('id', $request->branch);
                            })->withWhereHas('stocks', function ($query) use ($request) {
                                $query->where('branch_id', $request->branch);
                            })->get();

            }elseif(isset($request->branch) && isset($request->id) || isset($request->slug)) {

                $products = Product::with('category', 'images')
                            ->where('id', $request->id)
                            ->orWhere('slug', $request->slug);

                $request = $request->all();
                $request['product_id'] = $products->first()->id;

                $products = $products->withWhereHas('stocks', function ($query) use ($request) {
                                $query->where('branch_id', $request['branch'])
                                    ->where('product_id', $request['product_id']);
                            })->get();
            }else {
                $products = Product::with('category', 'images')
                            ->withWhereHas('stocks', function ($query) use ($request) {
                                $query->where('branch_id', $request->branch);
                            })->get();
            }

            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function byCategory(Request $request)
    {
        try{
            $products = Product::with('category', 'images')
                            ->whereHas('branches', function ($query) use ($request) {
                                $query->where('id', $request->branch);
                            })->WhereHas('category', function ($query) use ($request) {
                                $query->where('slug', $request->slug);
                            })->withWhereHas('stocks', function ($query) use ($request) {
                                $query->where('branch_id', $request->branch);
                            })->get();

            return response()->json([
                'status' => 'success',
                'data' => $products
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
