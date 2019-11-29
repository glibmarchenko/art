<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
  /**
   * @var array
   */
  protected $fillable = [
    'user_id',
    'delivery_id',
    'name',
    'phone',
    'country',
    'city',
    'street',
    'house',
    'postal',
    'details',
  ];

  /**
   * @var array
   */
  protected $attributes = [
    'house' => ' ',
  ];

  /**
   * @var array
   */
  protected $appends = [
    'full_address',
  ];

  /**
   * Find Or Create
   *
   * @param \App\Models\int $user_id
   * @return \App\Models\DeliveryDetail
   */
  public static function findOrCreate(int $user_id)
  {
    $deliveryDetail = self::where('user_id', $user_id)->first();

    return $deliveryDetail ? $deliveryDetail : new DeliveryDetail();
  }

  /**
   * Belongs To User
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Full Address Computed
   *
   * @return string
   */
  public function getFullAddressAttribute()
  {
    return $this->city.' '.$this->street.' '.$this->house.' '.$this->postal;
  }
}
