<?php

    namespace App\Http\Client;


    Class DectaApiAccessor
    {
        /**
         * Api Adapter
         *
         * @var
         */
        protected $api;

        protected $isCollectionResponse = true;

        /**
         * Class Initialization
         *
         * @throws \Exception
         */
        public function boot()
        {
            $this->api = new \App\Lib\DectaPayment();

            $this->validateConfiguration();

            $this->api->setCredentials(env('DECTA_PUBLIC_KEY'), env('DECTA_PRIVATE_KEY'));
        }

        /**
         * Shopify credentials check
         *
         * @throws \Exception
         */
        private function validateConfiguration()
        {
            if (!env('DECTA_PUBLIC_KEY') || !env('DECTA_PRIVATE_KEY')) {
                throw new \Exception('Decta configuration env is not set');
            }
        }

        /**
         * Response
         *
         * @param array $data
         * @return array|\Illuminate\Support\Collection
         */
        private function response(Array $data)
        {
            return $this->isCollectionResponse ? collect($data) : $data;
        }

        /**
         * Create Order
         *
         * @param $data
         * @return mixed
         */
        public function sendPayment($data)
        {
            return $this->api->create_payment($data);
        }

        /**
         * Capture Holded Order
         *
         * @param $order
         * @return mixed
         */
        public function captureOrder($order)
        {
            return $this->api->capture_order($order->signature);
        }

        /**
         * Cancel Holded Order
         *
         * @param $order
         * @return mixed
         */
        public function cancelOrder($order)
        {
            return $this->api->cancel_order($order->signature);
        }
    }
