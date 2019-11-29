<?php

namespace App\Transformers;

use App\Models\Purchase;
use App\Models\Settings;
use League\Fractal\TransformerAbstract;

class NewPrintOrderTransformer extends TransformerAbstract
{
  protected $purchase;

  protected $prices = [

  ];

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
    $this->calculatePrices($request['request']);

    return [
      'buyer_id' => $request['user']['id'],
      'uid' => $this->generateOrderUniqueId(),
      'type' => 'print',

      'delivery_amount' => $this->prices['delivery_amount'],
      'products_amount' => $this->prices['products_amount'],
      'package_amount' => $this->prices['package_amount'],

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

  private function generateOrderUniqueId(): string
  {
    $sandbox = 1;

    return 'P000'.$sandbox.'010'.rand(1,1000);
  }

  private function calculatePrices($request)
  {
    $smallPrintDelivery = Settings::getSmallPrintDeliveryPrice();
    $bigPrintDelivery = Settings::getBigPrintDeliveryPrice();
    $smallPrintPackage = Settings::getSmallPrintPackagePrice();
    $bigPrintPackage = Settings::getBigPrintPackagePrice();

    $clean_amount = 0;
    $delivery = 0;
    $package = 0;

    foreach ($request['purchases'] as $purchase) {
      $purchase = Purchase::findOrFail($purchase['id']);
      if ($purchase->product->type === 1) {
        $purchase = Purchase::findOrFail($purchase['id']);
        $clean_amount += $purchase->product->final_price;
        if ($purchase->product->width < 1000 && $purchase->product->height < 1000) {
          $delivery += $smallPrintDelivery;
          $package += $smallPrintPackage;
        } else {
          $delivery += $bigPrintDelivery;
          $package += $bigPrintPackage;
        }
      }
    }
    $this->prices['amount'] = $clean_amount + $delivery + $package;

    $this->prices['delivery_amount'] = $delivery;
    $this->prices['package_amount'] = $package;
    $this->prices['products_amount'] = $clean_amount;
  }
}
