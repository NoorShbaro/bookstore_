<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

if (isset($_POST['publish'])) {
    $id = unique_id();
    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_SPECIAL_CHARS);
    $status = 'active';

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image;

    $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
    $select_image->bind_param("ss", $image, $seller_id);
    $select_image->execute();

    $result = $select_image->get_result();
    if (isset($image)) {
        if ($result->num_rows > 0) {
            $warning_msg[] = 'Image name repeated';
        } elseif ($_FILES['image']['size'] > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    } else {
        $image = '';
    }

    if ($result->num_rows > 0 && $image != '') {
        $warning_msg[] = 'Please rename your image';
    } else {
        $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->bind_param("ssssssss", $id, $seller_id, $name, $price, $image, $stock, $description, $status);
        $insert_product->execute();
        $success_msg[] = 'Product inserted successfully';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <!--link got from font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>

<body>

    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>add book</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>book name<span>*</span></p>
                        <input type="text" name="name" maxlength="100" placeholder="add book name"
                            required class="box">
                    </div>
                    <div class="input-field">
                        <p>book price<span>*</span></p>
                        <input type="number" name="price" maxlength="100" placeholder="add book price"
                            required class="box">
                    </div>
                    <div class="input-field">
                        <p>book detail<span>*</span></p>
                        <textarea name="description" required maxlength="1000" placeholder="add book details" class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>book stock<span>*</span></p>
                        <input type="number" name="stock" maxlength="10" min="0" max="999999999" placeholder="add book stock"
                            required class="box">
                    </div>
                    <div class="input-field">
                        <p>book image<span>*</span></p>
                        <input type="file" name="image" accept="image/*"
                            required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="add book" class="btn">
                        <input type="submit" name="draft" value="save as draft" class="btn">
                    </div>
                </form>
            </div>
        </section>
    </div>



    <!--link got from sweet alert cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!--my javascript code-->
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>

</html>