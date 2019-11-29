<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function paid(Order $order)
    {
        $this->createNewCommission($order);
    }

    public function produced(Order $order)
    {

    }

    public function reserved(Order $order)
    {

    }

    public function packed(Order $order)
    {

    }

    public function shipped(Order $order)
    {

    }

    public function completed(Order $order)
    {

    }

    private function createNewCommission(Order $order)
    {
        foreach ($order->products as $product) {
            $commissionOwner = $product->author->gallery ? $product->author->gallery->owner : $product->author;
            $commissionOwner->commissions()->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_type' => $product->type,
                'amount' => $product->price,
                'currency' => 'EUR',
            ]);
        }

    }
}
