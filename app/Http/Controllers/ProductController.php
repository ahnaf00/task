<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::select('id','title', 'category', 'image')->with('features')->get();
        // return response()->json($products);
        return view('products', [
            'products'=> $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category'=> 'required|string|max:255',
            'image' => 'nullable|image'
        ]);

        $product->title = $request->title;
        $product->category = $request->category;

        if($request->hasFile('image'))
        {
            $image      = $request->file('image');
            $fileName   = $image->getClientOriginalName();
            $time       = time();
            $imageName  = "{$time}-{$fileName}";

            $image->move(public_path('uploads/products'), $imageName);

            $product->image = 'uploads/products/'.$imageName;
        }

        $product->save();

        return response()->json(['success' => 'Product updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
