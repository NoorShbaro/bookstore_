<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

$get_id = $_GET['post_id'];

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
        <section class="show-post">
            <div class="heading">
                <h1>Your books</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
                $select_products->bind_param("s", $seller_id);
                $select_products->execute();
                $result = $select_products->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_products = $result->fetch_assoc()) {
                ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                            <?php if ($fetch_products['image'] != '') { ?>
                                <img src="../uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                            <?php } ?>
                            <div class="status" style="color: <?php if ($fetch_products['status'] == 'active') {
                                                                    echo "green";
                                                                } else {
                                                                    echo "red";
                                                                } ?>">
                                <?= $fetch_products['status']; ?>
                            </div>
                            <div class="price">
                                <?= $fetch_products['price']; ?> $
                            </div>
                            <div class="content">
                                <div class="title">
                                    <?= $fetch_products['name']; ?>
                                </div>
                                <div class="flex-btn">
                                    <a href="edit_product.php?id=<?= $fetch_products['id']; ?> " class="btn">
                                        edit
                                    </a>
                                    <button type="submit" name="delete" class="btn"
                                        onclick="return confirm('delete this book?');">delete</button>
                                        <a href="read_product.php?product_id=<?= $fetch_products['id']; ?> " class="btn">
                                        info
                                    </a>
                                </div>
                            </div>
                        </form>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No books added yet!<br><a href="add_product.php" class="btn" style="margin-top: 1.5rem; line-height:2;">Add books</a></p>
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