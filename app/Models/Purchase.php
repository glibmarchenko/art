<?php

namespace App\Models;

use App\Lib\NovaPoshta;
use App\Models\Products\Product;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'order_id'
    ];

    protected $with = ['product', 'details'];
    
    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
