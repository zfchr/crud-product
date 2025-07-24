<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->get();

        return $this->success(data: $products->toArray());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'max:30', 'unique:products,code'],
            'sku' => ['required', 'max:30', 'unique:products,sku'],
            'name' => ['required', 'max:50'],
            'alias_name' => ['nullable', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'max:150'],
        ]);


        DB::beginTransaction();

        try {
            $product = Product::create($validated);

            DB::commit();

            return $this->success(message: 'The new data has been successfully created.', data: $product->toArray());
        } catch (\Throwable $th) {
            DB::rollBack();
            
            return $this->error(message: $th->getMessage());
        } 
    }

    public function show(Product $product)
    {
        return $this->success(data: $product->toArray());
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'max:30',
                Rule::unique('products', 'code')->ignore($product->id),
            ],
            'sku' => [
                'required',
                'max:30',
                Rule::unique('products', 'sku')->ignore($product->id),
            ],
            'name' => ['required', 'max:50'],
            'alias_name' => ['nullable', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'max:150'],
        ]);

        DB::beginTransaction();

        try {
            $product->update($validated);

            DB::commit();

            return $this->success(message: 'The new data has been successfully saved.', data: $product->toArray());
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->error(message: $th->getMessage());
        } 
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $product->delete();

            DB::commit();

            return $this->error(message: 'The data has been success deleted.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->error(message: $th->getMessage());
        }
    }

    public function success
    (
        string $message = 'Success', 
        array $data = [],
        int $status = 200, 
        string $title = 'Success'
    )
    {
        return response()->json([
            'status' => [
                'error' => true,
                'title' => $title,
                'message' => $message,
            ],
            'data' => $data
        ], $status);
    }

    public function error
    (
        string $message = 'Error', 
        array $data = [], 
        int $status = 422, 
        string $title = 'Failed to process your request'
    )
    {
        return response()->json([
            'status' => [
                'error' => false,
                'title' =>  $title,
                'message' => $message,
            ],
            'data' => $data
        ], $status);
    }
}
