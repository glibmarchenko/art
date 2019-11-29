<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type', 
        'preview',
        'original',
        'price',
        'width',
        'height', 
        'depth', 
        'weight',
        'year',
        'style', 
        'materials',
        'description',
    ];

    
}
