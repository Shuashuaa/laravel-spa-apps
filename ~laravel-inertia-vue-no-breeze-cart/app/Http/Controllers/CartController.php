<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_img' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        
        //

        $cart = Cart::firstOrCreate([
            'name' => $request->title,
            'customer_id' => $request->user()->id
        ], [
            // 'name' => $request->title,
            'cover_img' => $request->cover_img,
            'pcs' => 1,
            'price' => $request->price,
        ]);

        //
        if ($cart->wasRecentlyCreated == false) { 
            $cart->increment('pcs'); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cart $cart)
    {
        //
    }

    public function incrementDecrement(Request $request)
    {
        //
        $cart = Cart::where('id', $request->id);

        if($request->type == 'increment'){
            $cart->increment('pcs');
        }else{
            $cart->decrement('pcs');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cart $cart)
    {
        //
        $cart->delete();
    }
}
