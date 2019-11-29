<?php

namespace App\Models;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category_product';

    protected $fillable = [
        'category_type_id',
    ];

    protected $with = [
        'type',
    ];

    public function type()
    {
        return $this->belongsTo(CategoryType::class, 'category_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
