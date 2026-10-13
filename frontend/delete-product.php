<?php
include "connect.php";
$id = $_GET['id'];

$sql = "DELETE FROM PRODUCT WHERE id = $id";
$result = $con->query($sql);


header("Location: my-product.php");
