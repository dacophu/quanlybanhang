<?php
include "connect.php";
$id = $_GET['id'];

$sql = "SELECT * FROM PRODUCT WHERE id = $id";
$result = $con->query($sql);

$data = [];
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

var_dump($data);
$titleErr = $priceErr = $imageErr = "";
$img = $data['image'];
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

    if (!empty($_FILES['image']['name'])) {

        if ($_FILES['image']['error'] > 0) {
            $imageErr =  'File bị lỗi';
            $valid = false;
        } else {

            echo '<pre>';
            var_dump($_FILES);

            $name = explode('.', $_FILES['image']['name']);
            $imgArr = ['png', 'jpg', 'jpeg'];

            if (!in_array($name[1], $imgArr)) {
                $imageErr =  "File không phải là hình ảnh";
                $valid = false;
            } else {
                $img = $_FILES['image']['name'];
            }
        }
    }

    if ($valid) {
        $sql = "UPDATE PRODUCT SET title = '" . $_POST['title'] . "',
                                    price  = '" . $_POST['price'] . "',
                                    image = '$img' WHERE id = $id";
        echo $sql;
        if ($result = $con->query($sql)) {
            echo "Update Product success";
        } else {
            echo "ERROR";
        }

        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $_FILES['image']['name']);
        }


        header("Location: my-product.php");
        exit;
    }
}
?>

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="nhập tên sản phẩm" name="title" value="<?php echo $data['title'] ?>" />
        <p><?php echo $titleErr ?></p>
        <input type="text" placeholder="Nhập giá sản phẩm" name="price" value="<?php echo $data['price'] ?>" />
        <p><?php echo $priceErr ?></p>
        <img width="85px" src="<?php echo "./uploads/" . $img ?>">
        <input type="file" placeholder="Chọn hình ảnh sản phẩm" name="image">
        <p><?php echo $imageErr ?></p>
        <button name="submit" type="submit" class="btn btn-default">Update</button>
    </form>
</body>

</html>