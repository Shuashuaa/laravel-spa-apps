<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    //
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'books';

    protected $fillable = [
        'title',
        'cover_img',
        'price'
    ];
}
