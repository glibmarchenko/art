<?php

namespace App\Transformers;

use Illuminate\Support\Facades\Crypt;
use League\Fractal\TransformerAbstract;

class DectaPrintPaymentRequestTransformer extends TransformerAbstract
{
  /**
   * Transform Checkout
   *
   * @param $customer
   * @return array
   */
  public function transform($order)
  {
    return [
      'products' => $this->generateProducts($order),
      'client' => [
        'email' => $order['buyer']['email'],
        'phone' => $order['buyer']['phone'],
        'first_name' => $order['buyer']['name'],
        'last_name' => $order['buyer']['surname'],
        'personal_code' => (string) $order['buyer']['id'],
        'brand_name' => 'string',
        'legal_name' => 'string',
        'legal_address' => $order['buyer']['delivery_details']['full_address'],
        'state' => $order['buyer']['delivery_details']['country'],
        'city' => $order['buyer']['delivery_details']['city'],
        'zip_code' => '65001',
        //'bank_account' => 'string',
        //'bank_code' => 'string',
        //'recurring_paused' => true,
        'send_to_email' => true,
        //'send_to_phone' => true,
      ],
      'request_client_info' => [
        0 => 'email',
      ],
      'currency' => 'EUR',
      'number' => 'string',
      'due' => 1606348442,
      'deny_overdue_payment' => false,
      'fee_paid_by' => 'client',
      'skip_capture' => true,
      'language' => 'en',
      'notes' => 'Покупка принтов',
      'is_test' => true,
      'success_redirect' => 'http://art.grebola.com/order/payment/decta/success/'.$this->generateOrderId($order),
      'failure_redirect' => 'http://art.grebola.com/order/payment/decta/failure/'.$this->generateOrderId($order),
      'cancel_redirect' => 'http://art.grebola.com/order/payment/decta/cancel/'.$this->generateOrderId($order),
      'custom_invoice_url' => 'http://art.grebola.com/order/payment/decta/invoice/'. $this->generateOrderId($order),
      'iframe_checkout_send_invoice' => false,
      'subtotal_override' => 0,
      'total_tax_override' => 0,
      'total_discount_override' => 0,
      'total_override' => 0,
    ];
  }

  private function generateProducts($order)
  {
    $products = [];

    foreach ($order['products'] as $product) {
      $products[] = [
        'price' => $product['final_price'] + $product['delivery_price'] + $product['packing_price'],
        'title' => $product['name'],
      ];
    }
    return $products;
  }

  private function generateOrderId($order) : string
  {
    /**
     * ToDO: Change ID to generated signature
     */
    return $order['id'];
    //return hash('crc32', $order['id'], FALSE);
  }
}
