<?php

define('CART_TPL',  'cart.tpl');
define('CART_ID',   'cart1234');
define('API_URL',   'http://localhost:8080/api/');
define('API_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicGFzc3dvcmQiOiIwMzAyNGRmYmM0M2M5ZDNjMWRjYTI4OGQ4N2Q2NzE3YiJ9.CwEOIwiX1LVvNIAbz8Ud3jXKc5nZLGJTBciJnEcFdnM');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

abstract class CartMethod {
    abstract function connect();
    abstract function loadAddress();
    abstract function loadItems();
    abstract function loadTotal();
    abstract function loadTemplate($args);
    abstract function run();
}

abstract class ApiMethod {
    abstract function get($param);
    abstract function request($url, $params, $method);
}

class Service extends ApiMethod {

    /**
     * [request description]
     * @author vothaianh
     * @date   2017-05-30T21:07:29+070
     * @param  [type]                  $url    [description]
     * @param  array                   $params [description]
     * @param  string                  $method [description]
     * @return [type]                          [description]
     */
    public function request($url, $params = [], $method = 'GET') {

        $authorization = "Authorization: Bearer ".API_TOKEN;

        $ch = curl_init();

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_URL, API_URL . $url);
        }
        if ($method == 'GET') {
            $url = !empty($params) ? $url . '?' . http_build_query($params) : $url;
            curl_setopt($ch,CURLOPT_URL, API_URL . $url);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array( $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result);
    }

    /**
     * [get description]
     * @author vothaianh
     * @date   2017-05-31T11:06:59+070
     * @param  [type]                  $param [description]
     * @return [type]                         [description]
     */
    public function get($param = null) {
        if (!empty($_GET[$param])) return $_GET[$param];
        if (empty($param)) return $_GET;
    }

}

class CartFactory extends CartMethod {

    /**
     * [__construct description]
     * @author vothaianh
     * @date   2017-05-30T21:09:59+070
     */
    public function __construct() {
        $this->Service = new Service;
    }

    public function handler() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->isAjax = true;
        }
    }

    /**
     * [connect description]
     * @author vothaianh
     * @date   2017-05-30T20:40:36+070
     * @return [type]                  [description]
     */
    public function connect() {
        $result = $this->Service->request('ping');
        if ($result->status == 200) return $this;
        else throw new Exception('Cannot connect to API Service');
    }

    public function loadAddress() {
        $result = $this->Service->request('address');
        if (!empty($result)) {
            $this->address = $result;
        }
        return $this;
    }

    /**
     * [loadItems description]
     * @author vothaianh
     * @date   2017-05-30T21:14:47+070
     * @return [type]                  [description]
     */
    public function loadItems() {
        $result = $this->Service->request('cart/' . CART_ID);
        if (!empty($result->items)) {
            $this->items = $result->items;
        }
        return $this;
    }

    /**
     * [loadTotal description]
     * @author vothaianh
     * @date   2017-05-30T22:16:12+070
     * @param  [type]                  $code [Postal Code]
     * @return [type]                        [description]
     */
    public function loadTotal() {

        $items  = [];
        $cartId = CART_ID;

        if (!empty($this->isAjax)) $code = $this->Service->get('code');

        if (empty($code) && !empty($this->address)) {
            foreach($this->address as $addr) {
                if ($addr->is_default == 1) $code = $addr->postal_code;
            }
        }

        if (!empty($this->items)) {
            $totalItemCost = 0;
            foreach($this->items as $item) {
                $items[] = $item->item_id;
                $totalItemCost += $item->price;
            }
            $this->totalItemCost = $totalItemCost;
        }

        $params = [
            'cart_id'       => $cartId,
            'items'         => $items,
            'postal_code'   => $code
        ];

        $results = $this->Service->request('shipping/fee', $params, 'POST');

        if (!empty($results->SFData)) {
            $totalShippingFee = 0;
            foreach($results->SFData as $item) {
                $totalShippingFee += $item->ShippingFee;
                $deliveredFrom[$item->ItemID] = $item->Location;
            }
            $this->deliveredFrom    = $deliveredFrom;
            $this->totalShippingFee = $totalShippingFee;
        }
    }

    /**
     * [loadTemplate description]
     * @author vothaianh
     * @date   2017-05-30T20:38:01+070
     * @return [type]                  [description]
     */
    public function loadTemplate($args) {
        if (!empty($args)) {
            foreach($args as $key => $param) {
                eval("\$$key = \$param;");
            }
        }
        include CART_TPL;
    }

    /**
     * [run description]
     * @author vothaianh
     * @date   2017-05-30T20:38:07+070
     * @return [type]                  [description]
     */
    public function run() {

        $items          = !empty($this->items) ? $this->items : [];
        $address        = !empty($this->address) ? $this->address : [];
        $deliveredFrom  = !empty($this->deliveredFrom) ? $this->deliveredFrom : [];
        $shippingFee    = $this->totalItemCost > 100 ? 0 : $this->totalShippingFee ;
        $totalItemCost  = number_format($this->totalItemCost + $shippingFee);

        $response = compact('items', 'address', 'shippingFee', 'totalItemCost', 'deliveredFrom');

        if (!empty($this->isAjax)) {
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        else $this->loadTemplate($response);

    }

}

function test($object) {
    print '<pre>';
    print_r($object);
    exit;
}


$myCart = new CartFactory;

$myCart->handler();

$myCart->connect()->loadAddress()->loadItems()->loadTotal();

$myCart->run();
