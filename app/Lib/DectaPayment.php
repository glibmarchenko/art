<?php

    namespace App\Lib;

    use Illuminate\Support\Facades\Log;

    Class DectaPayment
    {
        /**
         *  Module Version
         */
        const SWIPE_MODULE_VERSION = 'v2.0';

        /**
         * Root URL
         */
        const ROOT_URL = 'https://gate.decta.com';

        /**
         * Private Key
         *
         * @var
         */
        protected $private_key;

        /**
         * Public Key
         *
         * @var
         */
        protected $public_key;

        /**
         * DectaPayment constructor.
         *
         * @param $private_key
         * @param $public_key
         */
        public function __construct()
        {
            $this->logger = new Log();
        }

        /**
         * Set Credentials
         *
         * @param \App\Lib\string $public
         * @param \App\Lib\string $secret
         */
        public function setCredentials(string $public, string $secret): void
        {
            $this->private_key = $secret;
            $this->public_key = $public;
        }

        /**
         * @param $params
         * @return mixed|null
         */
        public function create_payment($params)
        {
            $result = $this->call('POST', '/api/v0.6/orders/', $params);
            if ($result == null) {
                return null;
            }

            if (isset($result['full_page_checkout']) && isset($result['id'])) {

                return $result;
            } else {
                return null;
            }
        }


        public function capture_order($order_id, $params = [])
        {
            $result = $this->call('POST', '/api/v0.6/orders/' . $order_id . '/capture/', $params);

            return $result;
        }

        public function cancel_order($order_id, $params = [])
        {

            $result = $this->call('POST', '/api/v0.6/orders/' . $order_id . '/cancel/', $params);

            return $result;
        }

        /**
         * Get User
         *
         * @param $filter_email
         * @param $filter_phone
         * @return null
         */
        public function getUser($filter_email, $filter_phone)
        {
            $params['filter_email'] = $filter_email;
            $params['filter_phone'] = $filter_phone;
            $users = $this->call('GET', '/api/v0.6/clients/', $params);

            return $users['results'][0] ?: null;
        }

        /**
         * Create User
         *
         * @param $params
         * @return mixed|null
         */
        public function createUser($params)
        {
            return $this->call('POST', '/api/v0.6/clients/', $params);
        }

        /**
         * Was Payment Successful
         *
         * @param $order_id
         * @param $payment_id
         * @return bool
         */
        public function was_payment_successful($order_id, $payment_id)
        {


            $order_id = (string)$order_id;
            $result = $this->call('GET', sprintf('/api/v0.6/orders/%s/', $payment_id));

            if ($result == null) {
                return false;
            }

            $payment_has_matching_order_id = $order_id == (string)$result['number'];
            if (!$payment_has_matching_order_id) {
                dd('Payment object has a wrong order id');
            }

            if ($result && $payment_has_matching_order_id && ($result['status'] == 'paid' || $result['status'] == 'withdrawn')) {
                dd("Validated order #%s, payment #%s", $order_id, $payment_id);

                return true;
            } else {
                dd('Could not validate payment');

                return false;
            }
        }

        /**
         * Call
         *
         * @param $method
         * @param $route
         * @param array $params
         * @return mixed|null
         */
        public function call($method, $route, $params = [])
        {
            $private_key = $this->private_key;
            $original_params = $params;
            if (!empty($params)) {
                $params = json_encode($params);
            }

            $authorization_header = "Bearer " . $private_key;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, self::ROOT_URL . $route);

            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
            }

            if ($method == 'PUT') {
                curl_setopt($ch, CURLOPT_PUT, 1);
            }

            if ($method == 'PUT' or $method == 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }

            if ($method == 'GET') {
                $get_params = '';
                foreach ($original_params as $key => $value) {
                    $get_params .= $key . '=' . urlencode($value) . '&';
                }
                $get_params = trim($get_params, '&');
                curl_setopt($ch, CURLOPT_URL, self::ROOT_URL . $route . '?' . $get_params);
            }

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-type: application/json',
                'Authorization: ' . $authorization_header,
            ]);

            $response = curl_exec($ch);

            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if (!$result) {
                return null;
            }

            if ($code >= 400 && $code < 500) {
                dd('API Errors', print_r($result, true));

                return null;
            }

            return $result;
        }
    }
