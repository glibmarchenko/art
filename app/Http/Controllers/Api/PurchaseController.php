<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\CreatePrintOrderRequest;
    use App\Models\Products\Product;
    use App\Models\Purchase;
    use App\Models\PurchaseDetail;
    use App\Services\OrderService;
    use App\Services\PaymentService;
    use Illuminate\Http\Request;

    class PurchaseController extends Controller
    {
        /**
         * Get User Orders
         *
         * @param \Illuminate\Http\Request $request
         * @return mixed
         */
        public function index(Request $request)
        {
            return $request->user()->purchases()->whereNull('order_id')->orderBy('created_at', 'DESC')->get();
        }

        /**
         * Store Order
         *
         * @param \Illuminate\Http\Request $request
         * @return \App\Models\Purchase|string
         */
        public function store(Request $request)
        {
            if ($request->product_type !== 1) {
                if (Purchase::where('user_id', $request->user()->id)->where('product_id', $request->product_id)->first()) {
                    return 'Duplicate non poster';
                };
            }

            $product = Product::findOrFail($request->product_id);

            $purchase = new Purchase();
            $purchase->fill($request->all());
            $purchase->user_id = $request->user()->id;
            $purchase->price = $product->final_price;
            $purchase->save();

            foreach ($request->details as $key => $value) {
                $detail = new PurchaseDetail();
                $detail->purchase_id = $purchase->id;
                $detail->name = $key;
                $detail->value = is_array($value) ? $value['value'] : $value;
                $detail->save();
            }

            return $purchase;
        }

        /**
         * Calculate Price
         *
         * @param $product
         * @return float|int
         */
        private function calculatePrice($product)
        {
            $width = $product->width;
            $height = $product->height;

            $craftPrice = $width * $height / 1000000 * 25;
            $backGroundPrice = ($width + $height) * 2 / 1000;

            return $craftPrice + $backGroundPrice + 1;
        }

        /**
         * Delete Order
         *
         * @param $id
         * @param \Illuminate\Http\Request $request
         * @return mixed
         */
        public function delete($id, Request $request)
        {
            $purchase = Purchase::findOrFail($id);
            $purchase->delete();

            return $purchase;
        }

        /**
         * Create Print Order
         * LiqPay Payment Provider
         *
         * @param \App\Http\Requests\CreatePrintOrderRequest $request
         * @return false|string
         * @throws \Exception
         */
        public function createPrintOrder(CreatePrintOrderRequest $request)
        {
            $order = (new OrderService())->submitPrintOrder($request);

            $signature = (new PaymentService())->generateLiqpaySignature($order);

            return $signature;
        }

        /**
         * Create Non Print Order
         * LiqPay payment Provider
         *
         * @param \Illuminate\Http\Request $request
         * @return mixed
         * @throws \Exception
         */
        public function createOtherOrder(Request $request)
        {
            $order = (new OrderService())->submitNewOrder($request);

            return $order;
        }

        /**
         * Create Non Print Order
         * Decta Payment Provider
         *
         * @param \Illuminate\Http\Request $request
         */
        public function createOtherOrderDecta(Request $request)
        {
            $order = (new OrderService())->submitNewOrder($request);

            $dectaResponse = (new PaymentService())->prepareDectaPayment($order);

            $order->update(['signature' => $dectaResponse['id'], 'sandbox' => $dectaResponse['is_test']]);

            return $dectaResponse['full_page_checkout'];
        }

        /**
         * Create Print Order
         * Decta Provider
         *
         * @param \Illuminate\Http\Request $request
         * @return mixed
         * @throws \Exception
         */
        public function createPrintOrderDecta(Request $request)
        {
            $order = (new OrderService())->submitPrintOrder($request);

            $dectaResponse = (new PaymentService())->prepareDectaPrintPayment($order);

            $order->update(['signature' => $dectaResponse['id'], 'sandbox' => $dectaResponse['is_test']]);

            return $dectaResponse['full_page_checkout'];
        }

        public function createOtherOrderManual(Request $request)
        {
            $order = (new OrderService())->submitNewOrder($request);
            return $order;
        }

        public function createPrintOrderManual(Request $request)
        {
            $order = (new OrderService())->submitPrintOrder($request);
            return $order;
        }
    }
