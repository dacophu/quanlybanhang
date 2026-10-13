<?php
session_start();
include "connect.php";

$titleErr = $priceErr = $imageErr = "";
$valid = true;
if (isset($_POST['submit'])) {
    if (empty($_POST['title'])) {
        $titleErr = "Vui lòng nhập tiêu đề sản phẩm";
        $valid = false;
    }
    if (empty($_POST['price'])) {
        $priceErr = "Vui lòng nhập giá sản phẩm";
        $valid = false;
    }
    if (empty($_FILES['image']['name'])) {
        $imageErr = "Vui lòng chọn hình ảnh sản phẩm";
        $valid = false;
    }

    if (!empty($_FILES['image']['name'])) {

        if ($_FILES['image']['error'] > 0) {
            $imageErr =  'File bị lỗi';
        } else {

            echo '<pre>';
            var_dump($_FILES);

            $name = explode('.', $_FILES['image']['name']);
            $imgArr = ['png', 'jpg', 'jpeg'];

            if (!in_array($name[1], $imgArr)) {
                $imageErr =  "File không phải là hình ảnh";
                $valid = false;
            }
        }
    }

    if ($valid) {
        $sql = "INSERT INTO PRODUCT (title,price,image,id_user) VALUES ('" . $_POST['title'] . "',
                                                                '" . $_POST['price'] . "',
                                                                '" .  $_FILES['image']['name'] . "',
                                                                '" . $_SESSION['auth'] . "')";
        if ($result = $con->query($sql)) {
            echo "Insert Product suscess";
        } else {
            echo "ERROR";
        }

        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $_FILES['image']['name']);

        header("Location: account.php");
        exit;
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="nhập tên sản phẩm" name="title" />
        <p><?php echo $titleErr ?></p>
        <input type="text" placeholder="Nhập giá sản phẩm" name="price" />
        <p><?php echo $priceErr ?></p>
        <input type="file" placeholder="Chọn hình ảnh sản phẩm" name="image">
        <p><?php echo $imageErr ?></p>
        <button name="submit" type="submit" class="btn btn-default">Add new product</button>
    </form>
</body>

</html>