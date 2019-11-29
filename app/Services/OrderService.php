<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Purchase;
use App\Transformers\NewOrderTrasnsformer;
use App\Transformers\NewPrintOrderTransformer;
use DB;
use Spatie\Fractal\FractalFacade;

class OrderService
{
  public function submitNewOrder($request)
  {
    try {
      DB::beginTransaction();

      $purchase = Purchase::findOrFail($request->purchase['id']);

      /**
       * Prepare Data for Order transformer
       */
      $rawData = collect([
        'data' => [
          'request' => $request->all(),
          'user' => $request->user()->load('deliveryDetails')->toArray(),
        ],
      ]);

      /**
       * Order transformer
       */
      $orderContent = FractalFacade::collection($rawData)->transformWith(new NewOrderTrasnsformer())->toArray();

      /**
       * Order Creation
       */
      $order = Order::create($orderContent['data'][0]);

      /**
       * Purchase update Order
       */
      $purchase->update(['order_id' => $order->id]);

      DB::commit();

      return $order;
    } catch (\Exception $e) {
      throw new \Exception($e);
    }
  }

  public function submitPrintOrder($request)
  {
    try {
      DB::beginTransaction();

      /**
       * Prepare Data for Order transformer
       */
      $rawData = collect([
        'data' => [
          'request' => $request->all(),
          'user' => $request->user()->load('deliveryDetails')->toArray(),
        ],
      ]);

      /**
       * Order transformer
       */
      $orderContent = FractalFacade::collection($rawData)->transformWith(new NewPrintOrderTransformer())->toArray();

      /**
       * Order Creation
       */
      $order = Order::create($orderContent['data'][0]);

      /**
       * Purchase update Order
       */
      foreach ($request->purchases as $dataPurchase) {
        $purchase = Purchase::findOrFail($dataPurchase['id']);
        if ($purchase->product->type === 1) {
          $purchase->order_id = $order->id;
          $purchase->save();
        }
      }

      DB::commit();

      return $order;
    } catch (\Exception $e) {
      throw new \Exception($e);
    }
  }
}
