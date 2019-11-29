<?php

    namespace App\Http\Controllers;

    use App\Models\Order;
    use Illuminate\Http\Request;

    class PaymentController extends Controller
    {
        public function onSuccessDectaRedirect(Request $request, $order_hash)
        {
            $order = Order::findOrFail($order_hash);

            $order->statusService()->setPaid();

            session(['dialog-box' => 'print_payment_success']);

            return redirect()->route('order.active');
        }

        public function onFailureDectaRedirect(Request $request, $order_hash)
        {
            session(['dialog-box' => 'print_payment_error']);

            return redirect()->route('order.cancelled');
        }

        public function onCancelDectaRedirect(Request $request, $order_hash)
        {
            session(['dialog-box' => 'print_payment_error']);

            return redirect()->route('order.cancelled');
        }

        public function onInvoiceDectaRedirect(Request $request, $order_hash)
        {

            $order = Order::findOrFail($order_hash);

            $order->statusService()->setCancelled();


            session(['dialog-box' => 'print_payment_error']);

            return redirect()->route('order.cancelled');
        }

        public function onSuccessfullHoldRedirect(Request $request, $order_hash)
        {
            $order = Order::findOrFail($order_hash);

            $order->setReserved();

            session(['dialog-box' => 'other_payment_success']);

            return redirect()->route('order.active');
        }
    }
