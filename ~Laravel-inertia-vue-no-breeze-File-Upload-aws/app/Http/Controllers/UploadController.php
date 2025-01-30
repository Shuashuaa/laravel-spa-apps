<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //
    public function upload(Request $request){

        $request->validate([
            'avatar' => 'file|nullable|max:3000',
        ]);
        
        if($request->hasFile('avatar')){
            Storage::disk('public')->put('avatars', $request->avatar);
        }
    }
}
