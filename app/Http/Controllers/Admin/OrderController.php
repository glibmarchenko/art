<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\Gallery;
    use App\Models\Order;
    use App\Models\Products\Thing;
    use App\Models\Products\Picture;
    use App\Models\Products\Poster;
    use App\Models\Settings;
    use App\Models\Users\User;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
    {

        /**
         * @return mixed
         */
        public function index()
        {
            $orders = Order::with('products')->whereType('print')->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * Get Orders By State & Type
         *
         * @param $type
         * @param $state
         * @return mixed
         */
        public function getOrdersByStateType($state)
        {
            $orders = Order::with('products')->whereType('print')->whereState($state)->get();

            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * Get Orders By State & Type
         *
         * @param $type
         * @param $state
         * @return mixed
         */
        public function getPicturesByState($state)
        {
            $orders = Order::with('products')->whereType('picture')->whereState($state)->get();

            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * Get Orders By State & Type
         *
         * @param $type
         * @param $state
         * @return mixed
         */
        public function getItemsByState($state)
        {
            $orders = Order::with('products')->whereType('item')->whereState($state)->get();

            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPictures()
        {
            $orders = Order::with('products')->whereType('picture')->get();

            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexObjects()
        {
            $orders = Order::with('products')->whereType('object')->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintActive()
        {
            $orders = Order::with('products')->whereType('print')->wherePaid(1)->whereCompleted(0)->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintPrint()
        {
            $orders = Order::with('products')->whereType('print')->whereState('production')->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintPacking()
        {
            $orders = Order::with('products')->whereType('print')->whereState('packing')->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintDelivery()
        {
            $orders = Order::with('products')->whereType('print')->whereState('delivery')->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintCompleted()
        {
            $orders = Order::with('products')->whereType('print')->whereCompleted(1)->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintCalcelled()
        {
            $orders = Order::with('products')->whereType('print')->wherePaid(0)->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPrintArchived()
        {
            $orders = Order::with('products')->whereType('print')->whereArchived(1)->get();
            return view('web.admin.orders.index', compact('orders'));
        }

        /**
         * @param $state
         * @return mixed
         */
        public function indexPictureState($state)
        {
            $orders = Order::with('products')->whereType('picture')->whereState($state)->get();
            return view('web.admin.orders.pictures', compact('orders'));
        }


        /**
         * @return mixed
         */
        public function indexPictureActive()
        {
            $orders = Order::with('products')->whereType('picture')->whereCompleted(0)->get();

            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPictureReserved()
        {
            $orders = Order::with('products')->whereType('picture')->whereState('production')->get();
            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPictureDelivery()
        {
            $orders = Order::with('products')->whereType('picture')->whereState('delivery')->get();
            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPictureCompleted()
        {
            $orders = Order::with('products')->whereType('picture')->whereCompleted(1)->get();
            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPictureCalcelled()
        {
            $orders = Order::with('products')->whereType('picture')->wherePaid(0)->get();
            return view('web.admin.orders.pictures', compact('orders'));
        }

        /**
         * @return mixed
         */
        public function indexPictureArchived()
        {
            $orders = Order::with('products')->whereType('picture')->whereArchived(1)->get();
            return view('web.admin.orders.pictures', compact('orders'));
        }


        /**
         * Set Prepared State
         *
         * @param $order_id
         * @return mixed
         */
        public function setOrderStatePrepared($order_id)
        {
            Order::findOrFail($order_id)->statusService()->setPrepared();

            return redirect()->back();
        }

        /**
         * Set State Produced
         *
         * @param $order_id
         * @return mixed
         */
        public function setOrderStateProduced($order_id)
        {
            Order::findOrFail($order_id)->statusService()->setProduced();

            return redirect()->back();
        }

        /**
         * Set State Reserved
         *
         * @param $order_id
         * @return mixed
         */
        public function setOrderStateReserved($order_id)
        {
            Order::findOrFail($order_id)->statusService()->setReserved();
            return redirect()->back();
        }

        /**
         * Cancel Order
         *
         * @param $order_id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function setOrderStateCancelled($order_id)
        {
            Order::findOrFail($order_id)->statusService()->setCancelled();

            return redirect()->back();
        }

        /**
         * Set State Packed
         *
         * @param $order_id
         * @return mixed
         */
        public function setOrderStatePacked($order_id)
        {
            Order::findOrFail($order_id)->statusService()->setPacked();
            return redirect()->back();
        }

        /**
         * Set State Shipped
         *
         * @param Request $request
         * @return mixed
         */
        public function setOrderStateShipped(Request $request)
        {
            Order::findOrFail($request->order_id)->statusService()->setShipped($request->delivery_id);
            return redirect()->back();
        }

        /**
         * Set State Completed
         *
         * @param $order_id
         * @return mixed
         */
        public function setOrderStateCompleted($order_id)
        {
            Order::findOrFail($order_id)->statusService()->setCompleted();
            return redirect()->back();
        }

        /**
         * Delete Order
         *
         * @param Order $order
         * @return mixed
         */
        public function deleteOrder(Order $order)
        {
            $order->purchases()->delete();

            $order->commission()->delete();

            $order->delete();

            return redirect()->back();
        }


    }
