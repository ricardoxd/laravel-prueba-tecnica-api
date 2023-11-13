<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index','show']]);
    }
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);
    
        $product = Product::create($validatedData);
    
        return ProductResource::make($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
    
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);
    
        $product->update($validatedData);
    
        return ProductResource::make($product);
    }

    public function destroy(Product $product)
    {
            $product->delete();
            return ProductResource::make($product);
    }
}
