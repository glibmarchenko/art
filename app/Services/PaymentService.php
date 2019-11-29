<?php

    namespace App\Services;

    use App\Facades\Decta;
    use App\Lib\LiqPay;
    use App\Transformers\DectaPaymentRequestTransformer;
    use App\Transformers\DectaPrintPaymentRequestTransformer;
    use Spatie\Fractal\FractalFacade;

    class PaymentService
    {
        /**
         * Generate LiqPay Signature
         *
         * @param $order
         * @return false|string
         */
        public function generateLiqpaySignature($order)
        {
            $liqPay = new LiqPay(env('LIQPAY_PUBLIC_KEY', 'i70164659351'), env('LIQPAY_PRIVATE_KEY', 'u9A72525I3HZdxYHFgzke26widHaY9FMuIIdSAsw'));

            $signature = $liqPay->getHashedJson([
                'action'      => 'pay',
                'amount'      => $order->total_amount,
                'currency'    => 'EUR',
                'description' => 'Покупка принтов',
                'orderId'     => 1,
                'version'     => 3,
                'sandbox'     => 1,
                'result_url'  => route('order.active'),
                'server_url'  => route('order.payment', $order->uid),
                'delivery'    => $order->delivery_amount,
                'package'     => $order->package_amount,
                'clean'       => $order->product_amount,
            ]);

            return $signature;
        }

        /**
         * Generate Decta Payment Signature & Redirect URL
         *
         * @param $order
         * @return mixed
         */
        public function prepareDectaPayment($order)
        {
            $dectaRequest = FractalFacade::collection(['order' => $order->load('buyer', 'products')->toArray()])->transformWith(new DectaPaymentRequestTransformer())->toArray();

            $dectaResponse = Decta::sendPayment($dectaRequest['data'][0]);

            return $dectaResponse;
        }

        /**
         * Capture Holded Funds
         *
         * @param $order
         * @return mixed
         */
        public function captureDectaPayment($order)
        {
            $dectaResponse = Decta::captureOrder($order);

            return $dectaResponse;
        }

        public function cancelDectaPayment($order)
        {
            $dectaResponse = Decta::cancelOrder($order);

            return $dectaResponse;
        }


        /**
         * Generate Decta Payment Signature & Redirect URL
         *
         * @param $order
         * @return mixed
         */
        public function prepareDectaPrintPayment($order)
        {
            $dectaRequest = FractalFacade::collection(['order' => $order->load('buyer', 'products')->toArray()])->transformWith(new DectaPrintPaymentRequestTransformer())->toArray();

            $dectaResponse = Decta::sendPayment($dectaRequest['data'][0]);

            return $dectaResponse;
        }
    }
