<?php

    namespace App\Services\OrderStatus;

    use App\Models\Order;

    class OrderStatusService
    {

        /**
         * @var Order
         */
        protected $order;


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
         * Fire Order Event
         *
         * @param $eventName
         */
        protected function fireModelEvent($eventName): void
        {
            $this->order->fireEvent($eventName);
        }


    }
