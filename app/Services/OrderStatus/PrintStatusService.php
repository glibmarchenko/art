<?php

    namespace App\Services\OrderStatus;

    use App\Models\Order;

    class PrintStatusService extends OrderStatusService
    {
        protected $statesMap = [
            'payment',
            'preparation',
            'production',
            'packing',
            'delivery',
            'completed',

            'cancelled'
        ];

        protected $statuses = [
            'paid',
            'prepared',
            'produced',
            'packed',
            'shipped',
            'completed',

            'cancelled'
        ];

        /**
         * Set Paid
         *
         */
        public function setPaid()
        {
            $this->order->paid = 1;
            $this->order->state = 'preparation';
            $this->order->save();

            $this->fireModelEvent('paid', false);
        }

        /**
         * Set Prepared
         *
         */
        public function setPrepared()
        {
            $this->order->prepared = 1;
            $this->order->state = 'production';

            $this->order->save();

            $this->fireModelEvent('prepared', false);
        }

        /**
         * Set Produced
         *
         */
        public function setProduced()
        {
            $this->order->prepared = 1;
            $this->order->produced = 1;
            $this->order->packed = 0;
            $this->order->state = 'packing';
            $this->order->save();

            $this->fireModelEvent('produced');
        }

        /**
         * Set Packed
         *
         */
        public function setPacked()
        {
            $this->order->prepared = 1;
            $this->order->produced = 1;
            $this->order->packed = 1;
            $this->order->state = 'delivery';
            $this->order->save();

            $this->fireModelEvent('packed');
        }

        /**
         * Set Shipped
         *
         * @param string $delivery_id
         */
        public function setShipped(string $delivery_id)
        {
            $this->order->delivery_id = $delivery_id;
            $this->order->prepared = 1;
            $this->order->packed = 1;
            $this->order->produced = 1;
            $this->order->shipped = 1;
            $this->order->state = 'delivery';
            $this->order->save();

            $this->fireModelEvent('shipped');
        }


        /**
         * Set Completed
         */
        public function setCompleted()
        {
            $this->order->completed = 1;
            $this->order->state = 'completed';
            $this->order->save();

            $this->fireModelEvent('completed');
        }


        public function setCancelled()
        {
            $this->order->cancelled = 1;
            $this->order->state = 'cancelled';
            $this->order->save();

            $this->fireModelEvent('cancelled');
        }

    }
