<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_details';
    
    protected $fillable = [
        'purchase_id', 
        'name',
        'value'
    ];

    public $timestamps = false;

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }


    
}
