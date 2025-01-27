<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    //
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'carts';
    
    protected $fillable = [
        'name',
        'customer_id',
        'cover_img',
        'pcs',
        'price'
    ];
}
