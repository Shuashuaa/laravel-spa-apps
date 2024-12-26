<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return Inertia::render('Frontend/Products/Index', [
            'products' => $products
        ]);
    }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Frontend/Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer'
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->to('/products')->with('message', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('Frontend/Products/Show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Frontend/Products/Edit', [
            'product' => $product
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer'
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->to('/products')->with('message', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->to('/products')->with('message', 'Product deleted successfully.');
    }
}
