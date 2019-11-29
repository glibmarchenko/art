<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\PosterStoreRequest;
    use App\Lib\LiqPay;
    use App\Models\Order;
    use App\Models\Products\Thing;
    use GuzzleHttp\Client;
    use Illuminate\Http\Request;
    use Auth;
    use Illuminate\Support\Facades\Log;
    use Symfony\Component\HttpKernel\HttpKernelInterface;


    class OrderController extends Controller
    {
        public function index()
        {
            $orders = Auth::user()->orders()->orderBy('created_at','DESC');
            return view('web.pages.orders.index', compact('orders'));
        }

        public function confirmPayment($token, Request $request)
        {
            $liqpayResponse = json_decode(base64_decode($request->data));
            Log::critical('liqpay-test',['liqpay' => $liqpayResponse]);

            if ($liqpayResponse->status === 'success' || $liqpayResponse->status === 'sandbox') {
                Log::critical('liqpay-status',['status' => $liqpayResponse->status]);
                Log::critical('liqpay-signature',['signature' => $request->signature]);
                Order::whereUid($token)->firstOrFail()->statusService()->setPaid();
            }
        }

        public function active()
        {
            $orders = Auth::user()->orders()->wherePaid(1)->whereCompleted(0)->get();
            return view('web.pages.orders.index', compact('orders'));
        }

        public function cancelled()
        {
            $orders = Auth::user()->orders()->wherePaid(0)->get();

            return view('web.pages.orders.index', compact('orders'));
        }

        public function completed()
        {
            $orders = Auth::user()->orders()->whereCompleted(1)->get();
            return view('web.pages.orders.index', compact('orders'));
        }

        public function destroy($id)
        {
            Order::findOrFail($id)->delete();
            return redirect()->back();
        }

    }
