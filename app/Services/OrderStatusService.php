<?php

    namespace App\Services;


    use App\Models\Order;

    class OrderStatusService
    {

        /**
         * @var Order
         */
        protected $order;

        protected $printStatesMap = [
            'payment',
            'preparation',
            'production',
            'packing',
            'delivery',
            'completed',
        ];


        protected $printStatuses = [
            'paid',
            'prepared',
            'produced',
            'packed',
            'shipped',
            'completed',
            'archived',
        ];

        protected $otherStatuses = [
            'paid',
            'prepared',
            'produced',
            'packed',
            'shipped',
            'completed',
            'archived',
        ];

        /**
         * OrderStatusService constructor.
         *
         * @param Order $order
         */
        public function __construct(Order $order)
        {
            $this->order = $order;
        }


        /**
         *
         */
        public function setPaid()
        {
            $this->order->paid = 1;
            $this->order->state = 'production';
            $this->order->save();

            $this->fireModelEvent('paid', false);

            //$this->order->notifyAdministratorsViaEmail();
        }

        /**
         *
         */
        public function setProduced()
        {
            $this->order->produced = 1;
            $this->order->state = 'packing';
            $this->order->save();

            $this->fireModelEvent('produced');
        }

        /**
         *
         */
        public function setReserved()
        {
            $this->order->available = 1;
            $this->order->reserved = 1;
            $this->order->state = 'reserved';
            $this->order->save();

            $this->fireModelEvent('reserved');
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


        /**
         * Fire Order Event
         *
         * @param $eventName
         */
        private function fireModelEvent($eventName): void
        {
            $this->order->fireEvent($eventName);
        }


    }
