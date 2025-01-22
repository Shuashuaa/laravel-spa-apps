<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth')->group(function(){
    // Route::inertia('/', 'Home', [
    //     'books' => Book::all(),
    //     'carts' => Cart::all(),
    // ])->name('home');

    Route::get('/', function(Request $request){
        return inertia('Home', [
            'books' => Book::all(),
            'carts' => Cart::where('customer_id', $request->user()->id)->get(),
        ]);
    })->name('home');
    
    Route::resource('carts', CartController::class);
    
    Route::post('/carts/increment-decrement', [CartController::class, 'incrementDecrement'])->name('carts.increment_decrement');    

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // running to function as an anchor tag and not a useForm Post
});

Route::middleware('guest')->group(function(){

    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login')->name('login'); // to the vue file
    Route::post('/login', [AuthController::class, 'login']); // running to function as a useForm Post
});