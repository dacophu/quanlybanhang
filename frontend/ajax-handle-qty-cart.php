<?php
session_start();
include "connect.php";
$data = json_decode(file_get_contents("php://input"), true);

$cart = [];

if ($_SESSION['cart']) {
    $cart = $_SESSION['cart'];
}

foreach ($cart as $key => $value) {
    if ($value['id'] == $data['id']) {
        $cart[$key]['qty'] = $data['qty'];
        break;
    }
}


$_SESSION['cart'] = $cart;
