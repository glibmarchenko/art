<?php

    namespace App\Services\OrderStatus;

    use App\Models\Order;
    use App\Services\PaymentService;

    class NonPrintStatusService extends OrderStatusService
    {

        public static $statesMap = [
            'payment',
            'preparation',
            'production',
            'packing',
            'delivery',
            'completed',
        ];

        public static $statuses = [
            /** Redirect After Successfull Payment */
            'hold',
            /** Set Reserved, Funds on Hold, Remove from Catalog,  */
            'reserved',
            /** Proceed with payment */
            'paid',
            /** Ships */
            'shipped',
            /** Completes */
            'completed',
            /** Cancelled */
            'cancelled'
        ];

        /**
         *
         */
        public function setPaid()
        {
            $this->order->paid = 1;
            $this->order->state = 'hold';
            $this->order->save();

            $this->fireModelEvent('paid', false);

            //$this->order->notifyAdministratorsViaEmail();
        }


        /**
         * Set Reserved
         *
         */
        public function setReserved()
        {
            (new PaymentService())->captureDectaPayment($this->order);

            $this->order->available = 1;
            $this->order->reserved = 1;
            $this->order->state = 'reserved';

            foreach ($this->order->products as $product) {
                $product->update(['sold' => true, 'for_sale' => false]);
            }

            $this->order->save();

            $this->fireModelEvent('reserved');
        }


        /**
         * Set Cancelled
         */
        public function setCancelled()
        {
            (new PaymentService())->cancelDectaPayment($this->order);

            $this->order->available = 0;
            $this->order->reserved = 0;
            $this->order->paid = 0;

            $this->order->state = 'cancelled';

            foreach ($this->order->products as $product) {
                $product->update(['sold' => false, 'for_sale' => false]);
            }

            $this->order->save();

            $this->fireModelEvent('cancelled');
        }

        /**
         *
         */
        public function setPacked()
        {
            $this->order->packed = 1;
            $this->order->state = 'delivery';
            $this->order->save();

            $this->fireModelEvent('packed');
        }


        /**
         *
         */
        public function setCompleted()
        {
            $this->order->completed = 1;
            $this->order->state = 'completed';
            $this->order->save();

            $this->fireModelEvent('completed');
        }

        /**
         * @param string $delivery_id
         */
        public function setShipped(string $delivery_id)
        {
            $this->order->delivery_id = $delivery_id;
            $this->order->shipped = 1;
            $this->order->state = 'delivery';
            $this->order->save();

            $this->fireModelEvent('shipped');
        }

    }
