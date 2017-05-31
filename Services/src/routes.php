<?php

use Firebase\JWT\JWT;

$app->post('/api/login', function ($request, $response, $next) {

    $username = $request->getParam('username');
    $password = md5($request->getParam('password'));

    $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch();

    if (empty($row)) $data['message'] = 'Username or password are incorrect!';
    else {
        $data['message']    = 'Login successful!';
        $data['token']      = JWT::encode(compact('username', 'password'), getenv('SECRET_KEY'));
    }

    return $response->withJson($data);
});

$app->get('/api/address', function ($request, $response, $args) {

    $stmt = $this->db->prepare("SELECT * FROM address");
    $stmt->execute();

    $data = $stmt->fetchAll();

    return $response->withJson($data);
});

$app->get('/api/cart/{cartId}', function ($request, $response, $args) {

    $cartId = $request->getAttribute('cartId');

    if (empty($cartId)) $data['message'] = 'CartId is required!';
    else {
        $stmt = $this->db->prepare("
            SELECT * FROM carts t1
            LEFT JOIN items t2 ON t1.item_id = t2.id
            WHERE t1.cart_id = :cartid
        ");
        $stmt->bindParam(':cartid', $cartId, PDO::PARAM_STR);
        $stmt->execute();

        $rows = $stmt->fetchAll();

        if (!empty($rows)) {
            foreach($rows as $row) {
                $results[] = $row;
            }
        }

        $data['CartID'] = $cartId;
        $data['items'] = !empty($results) ? $results : [];
    }

    return $response->withJson($data);
});

$app->get('/api/ping', function ($request, $response, $args) {
    $data = ['status' => 200];
    return $response->withJson($data);
});

$app->post('/api/shipping/fee', function ($request, $response, $args) {

    $cartId = $request->getParam('cart_id');
    $items  = $request->getParam('items');
    $code   = $request->getParam('postal_code');

    $stmt = $this->db->prepare("
        SELECT * FROM supplier_items t1
        LEFT JOIN items t2 ON t1.item_id = t2.id
        LEFT JOIN shipping t3 ON t1.supplier_id = t3.supplier_id
        WHERE t1.item_id IN (".implode(',', $items).") AND t3.delivered_to = :delivered_to
    ");

    $stmt->bindParam(':delivered_to', $code, PDO::PARAM_STR);

    $stmt->execute();

    $rows = $stmt->fetchAll();

    if (!empty($rows)) {

        foreach($rows as $row) {
            $id  = $row['item_id'];
            $key = $row['supplier_id'];
            $products[$id][$key] = $row;
            $filters[$id][$key] = $row['fee'];
        }

        foreach($filters as $itemId => $filter) {
            asort($filter);
            $filtered[$itemId] = $filter;
        }

        foreach($filtered as $itemId => $suppliers) {
            $supplier = key($suppliers);
            $sorted[$itemId] = $supplier;
        }


        foreach($sorted as $itemId => $sort) {

            $product    = $products[$itemId][$sort];
            $flatRate   = $product['fee'];
            $weight     = $product['weight'];
            $extra      = 0;

            if ($weight > 1) {
                for($w=1; $w <= $weight - 1; $w++) { }
                $extra = ($flatRate / 100 * 10) * $w;
            }

            $result[]   = [
                'ItemID'        => $product['item_id'],
                'Location'      => $product['source'],
                'ShippingFee'   => $product['fee'] + $extra
            ];

        }
    }

    if (empty($result)) $data['message'] = 'The postal code was not found!';
    else {
        $data['CartID']     = $cartId;
        $data['SFData']     = $result;
    }

    return $response->withJson($data);
});
