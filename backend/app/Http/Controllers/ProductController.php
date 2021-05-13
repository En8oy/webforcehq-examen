<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where("status", true)->get();
        return response()->json([
            'products' => $product
        ], 200);
    }

    public function create()
    {
        //
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = Str::title($request->name);
        $product->slug = Str::slug($product->name);
        $product->description = Str::ucfirst($request->description);
        $product->price = $request->price;
        $product->total_quantity = $request->total_quantity;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->save();

        return response()->json([
            "data" => $product,
            "message" => "Product created"
        ], 200);
    }

    public function show(Product $product)
    {
        $product->getFirstMedia();
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->name = Str::title($request->name);
        $product->slug = Str::slug($product->name);
        $product->description = Str::ucfirst($request->description);
        $product->price = $request->price;
        $product->total_quantity = $request->total_quantity;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->save();
        return response()->json([
            "data" => $product,
            "message" => "Product updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $oldProduct = $product;
        $product->delete();
        return response()->json([
            'data' => $oldProduct,
            'message' => "Product deleted"
        ], 200);
    }

    public function image(Request $request){
        $product = Product::find($request->id);
        $product->addMedia($request->file('image'))->toMediaCollection();
        $product->save();
        return response()->json([
            "message" => "Image uploaded"
        ], 200);
    }
}
