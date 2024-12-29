<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

if (isset($_GET['product_id'])) {
    $get_id = filter_var($_GET['product_id'], FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $get_id = ''; 
    echo "<p>Product not found. <a href='view_product.php'>Go back</a></p>";
    exit;
}

if (isset($_POST['delete'])) {
    $p_id = filter_var($_POST['product_id'], FILTER_SANITIZE_SPECIAL_CHARS);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id=? AND seller_id=?");
    $delete_image->bind_param("ss", $p_id, $seller_id);
    $delete_image->execute();

    $result = $delete_image->get_result();
    if ($result->num_rows > 0) {
        $fetch_delete_image = $result->fetch_assoc();

        if (!empty($fetch_delete_image['image'])) {
            $image_path = '../uploaded_files/' . $fetch_delete_image['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id=? AND seller_id=?");
        $delete_product->bind_param("ss", $p_id, $seller_id);
        $delete_product->execute();

        header("location:view_product.php");
        exit;
    } else {
        echo "Product not found or unauthorized access.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>book Detail</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE seller_id=? AND id=?");
                $select_product->bind_param("ss", $seller_id, $get_id);
                $select_product->execute();
                $result = $select_product->get_result();
                if ($result->num_rows > 0) {
                    $fetch_product = $result->fetch_assoc();
                ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                        <div class="status" style="color: <?php if ($fetch_product['status'] == 'active') {
                                                                echo "green";
                                                            } else {
                                                                echo "coral";
                                                            } ?>;">
                            <?= $fetch_product['status']; ?>
                        </div>
                        <?php if (!empty($fetch_product['image'])) { ?>
                            <img src="../uploaded_files/<?= $fetch_product['image']; ?>">
                        <?php } ?>
                        <div class="price">
                            <?= $fetch_product['price']; ?> $
                        </div>
                        <div class="title"><?= $fetch_product['name']; ?></div>
                        <div class="content"><?= $fetch_product['product_detail']; ?></div>
                        <div class="flex-btn">
                            <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product?')">delete</button>
                            <a href="view_product.php" class="btn">go back</a>
                        </div>
                    </form>
                <?php
                } else {
                    echo '
                        <div class="empty">
                            <p>Product not found or unauthorized access.<br><a href="view_product.php" class="btn" style="margin-top: 1.5rem; line-height:2; ">Go back</a></p>
                        </div>
                    ';
                }
                ?>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>

</html>
