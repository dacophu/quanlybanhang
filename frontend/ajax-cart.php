<?php
session_start();
include "connect.php";
$data = json_decode(file_get_contents("php://input"), true);

$sql = "SELECT * FROM PRODUCT WHERE ID = '" . $data['id'] . "'";

$result = $con->query($sql);
$product = [];
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
}

$product['qty'] = 1;
$cart = [];
if ($_SESSION['cart']) {
    $cart = $_SESSION['cart'];
}


$in = false;
foreach ($cart as $key => $value) {
    if ($value['id'] == $product['id']) {
        $cart[$key]['qty']++;
        $in = true;
        break;
    }
}

if (!$in) {
    array_push($cart, $product);
}

$_SESSION['cart'] = $cart;

echo count($cart);
