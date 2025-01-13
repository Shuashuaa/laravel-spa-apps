<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function(Request $request){
    return inertia('Home', [
        "users" => User::when($request->search, function($query) use ($request ){
            $query
            ->where('name', 'like', '%' . $request->search . '%')
            // this
            ->orWhere();
        })->paginate(5)->withQueryString(),

        "searchTerm" => $request->search
    ]);
})->name('home');

Route::middleware('auth')->group(function(){
    
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // running to function as an anchor tag and not a useForm Post
});

Route::middleware('guest')->group(function(){

    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login')->name('login'); // to the vue file
    Route::post('/login', [AuthController::class, 'login']); // running to function as a useForm Post
});


