<?php

namespace App\Transformers;

use App\Models\Purchase;
use League\Fractal\TransformerAbstract;

class NewOrderTrasnsformer extends TransformerAbstract
{
  protected $purchase;

  /**
   * Transform Checkout
   *
   * @param $customer
   * @return array
   *
   * request[request] - request
   * request[user] - user
   */
  public function transform($request)
  {
    $this->purchase = Purchase::findOrFail($request['request']['purchase']['id']);

    return [
      'buyer_id' => $request['user']['id'],
      'uid' => $this->generateOrderUniqueId(),
      'type' => $this->purchase->product->alias_name,
      'delivery_amount' => 0,
      'products_amount' => $this->purchase->product->price,
      'package_amount' => 0,
      'currency' => 'EUR',
      'sandbox' => true,

      'delivery_service' => 'Новая Почта',
      'delivery_country' => $request['user']['delivery_details']['country'],
      'delivery_city' => $request['user']['delivery_details']['city'],
      'delivery_street' => $request['user']['delivery_details']['street'],
      'delivery_house' => $request['user']['delivery_details']['house'],
      'delivery_postcode' => '65001',
      'delivery_name' => $request['user']['delivery_details']['name'],
      'delivery_phone' => $request['user']['delivery_details']['phone'],
      'delivery_description' => $request['user']['delivery_details']['details'],
      'delivery_id' => '00000000000',
    ];
  }

  private function generateOrderUniqueId() : string
  {
    $sandbox = 1;
    return  'I000'.$sandbox.'010'.$this->purchase->id;
  }
}
