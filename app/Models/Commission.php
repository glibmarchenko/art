<?php

namespace App\Models;

use App\Models\Products\Product;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Commission extends Model
{
    protected $table = 'commissions';

    protected $fillable = ['user_id', 'order_id', 'product_id', 'amount', 'product_type', 'currency'];

    protected $dates = ['paid_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function scopeAwaitConfirmation($query)
    {
        return $query->whereNull('pending_start_at');
    }

    public function scopePending($query)
    {
        return $query->whereNotNull('pending_start_at')->whereNull('paid_at');
    }

    public function scopePendingOver($query)
    {
        return $query->whereNull('paid_at')->where('pending_start_at', '<', Carbon::now()->subWeek());
    }

    public function scopePaid($query)
    {
        return $query->whereNotNull('paid_at');
    }

    public function setAmountAttribute($value)
    {
        if($this->product_type !== 1) {
            $value =  $value - $value / 100 * Settings::getAuthorCommission();
        }
        $this->attributes['amount'] = $value;
    }
}
