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

$app->get('/api/shipping/fee/{code}', function ($request, $response, $args) {

    $code = $request->getAttribute('code');

    $stmt = $this->db->prepare("SELECT * FROM shipping_fee WHERE postal_code = :code");
    $stmt->bindParam(':code', $code, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch();

    if (empty($row)) $data['message'] = 'The postal code was not found!';
    else {
        $data['CartID']     = 'Cart12334';
        $data['SFData']     = $row;
    }

    return $response->withJson($data);
});
