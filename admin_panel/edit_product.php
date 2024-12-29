<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

if (isset($_POST['update'])) {

    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_SPECIAL_CHARS);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);

    $price = filter_var($_POST['price'], FILTER_SANITIZE_SPECIAL_CHARS);

    $description = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS) : '';

    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_SPECIAL_CHARS);

    $status = filter_var($_POST['status'], FILTER_SANITIZE_SPECIAL_CHARS);


    $update_product = $conn->prepare("UPDATE products SET name = ?, price = ?, product_detail = ?, stock = ?, status = ? WHERE id = ? AND seller_id = ?");
    $update_product->bind_param("sdsssss", $name, $price, $description, $stock, $status, $product_id, $seller_id);
    $update_product->execute();

    if ($update_product->affected_rows > 0) {
        $success_msg[] = 'Product updated successfully!';
    } //else {
    // $warning_msg[] = 'No changes made or invalid product.';
    //}

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = '../uploaded_files/' . $image;

    $select_image = $conn->prepare("SELECT * FROM products WHERE image= ? AND seller_id =?");

    //$select_image->execute([$image, $seller_id]);
}

    if (!empty($image)) {
        if ($image_size > 200000000) {
            $warning_msg[] = 'image size is too large';
        } elseif ($select_image->num_rows() > 0) {
            $warning_msg[] = 'please rename your image';
        } else {

            $select_image = $conn->prepare("SELECT id FROM products WHERE image = ? AND seller_id = ?");
            $select_image->bind_param("ss", $image, $seller_id);
            $select_image->execute();
            $select_image->store_result();
            if ($select_image->num_rows > 0) {
                $warning_msg[] = 'Please rename your image.';
            } else {
                $update_image = $conn->prepare("UPDATE products SET image = ? WHERE id = ? AND seller_id = ?");
                $update_image->bind_param("sss", $image, $product_id, $seller_id);
                $update_image->execute();

                if ($update_image->affected_rows > 0) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    if (!empty($old_image) && file_exists('../uploaded_files/' . $old_image)) {
                        unlink('../uploaded_files/' . $old_image);
                    }

                    $success_msg[] = 'Image updated successfully!';
                } else {
                    $warning_msg[] = 'Failed to update image!';
                }
            }
        }
    }
    if (isset($_POST['delete_post'])) {
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_SPECIAL_CHARS);
    
        // Fetch the image to delete it from the file system
        $select_image = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
        $select_image->bind_param("ss", $product_id, $seller_id);
        $select_image->execute();
        $select_image->store_result();
        $select_image->bind_result($image_name);
        $select_image->fetch();
    
        if (!empty($image_name) && file_exists('../uploaded_files/' . $image_name)) {
            unlink('../uploaded_files/' . $image_name); // Delete the image file
        }
    
        // Delete the product from the database
        $delete_product = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
        $delete_product->bind_param("ss", $product_id, $seller_id);
        $delete_product->execute();
    
        if ($delete_product->affected_rows > 0) {
            $success_msg[] = 'Book deleted successfully!';
            header('Location: view_product.php');
            exit;
        } else {
            $warning_msg[] = 'Failed to delete the book!';
        }
        
    }
    
    if (isset($_POST['delete_image'])) {
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_SPECIAL_CHARS);
    
        // Fetch the image to delete it from the file system
        $select_image = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
        $select_image->bind_param("ss", $product_id, $seller_id);
        $select_image->execute();
        $select_image->store_result();
        $select_image->bind_result($image_name);
        $select_image->fetch();
    
        if (!empty($image_name) && file_exists('../uploaded_files/' . $image_name)) {
            unlink('../uploaded_files/' . $image_name); // Delete the image file
        }
    
        // Set the image field to an empty string in the database
        $unset_image = $conn->prepare("UPDATE products SET image = '' WHERE id = ? AND seller_id = ?");
        $unset_image->bind_param("ss", $product_id, $seller_id);
        $unset_image->execute();
    
        if ($unset_image->affected_rows > 0) {
            $success_msg[] = 'Image deleted successfully!';
        } else {
            $warning_msg[] = 'Failed to delete image!';
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
        <section class="post-editor">
            <div class="heading">
                <h1>edit book</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                if (isset($_GET['id'])) {
                    $product_id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

                    // Prepare the query
                    $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
                    $select_product->bind_param("ss", $product_id, $seller_id);
                    $select_product->execute();
                    $result = $select_product->get_result();

                    if ($result->num_rows > 0) {
                        $fetch_product = $result->fetch_assoc();
                ?>
                        <div class="form-container">
                            <form action="" method="post" enctype="multipart/form-data" class="register">
                                <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                                <div class="input-field">
                                    <p>book status <span>*</span></p>
                                    <select name="status" class="box">
                                        <option value="<?= $fetch_product['status']; ?>" selected>
                                            <?= $fetch_product['status']; ?>
                                        </option>
                                        <option value="active">active</option>
                                        <option value="deactive">deactive</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <p>book name <span>*</span></p>
                                    <input type="text" name="name" value="<?= $fetch_product['name']; ?>" class="box">
                                </div>
                                <div class="input-field">
                                    <p>book price <span>*</span></p>
                                    <input type="number" name="price" value="<?= $fetch_product['price']; ?>" class="box">
                                </div>
                                <div class="input-field">
                                    <p>book description <span>*</span></p>
                                    <textarea name="description" class="box"><?= $fetch_product['product_detail']; ?></textarea>
                                </div>
                                <div class="input-field">
                                    <p>book stock <span>*</span></p>
                                    <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>" class="box" min="0" max="99999999" maxlength="10">
                                </div>
                                <div class="input-field">
                                    <p>book image <span>*</span></p>
                                    <input type="file" name="image" accept="image/*" class="box">
                                    <?php
                                    if ($fetch_product['image'] != '') { ?>
                                        <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                                        <div class="flex-btn">
                                            <input type="submit" name="delete_image" class="btn" value="delete image">
                                            <a href="view_product.php" class="btn" style="width: 100%; text-align: center; height: 3rem; margin-top: .7rem;">back</a>
                                        </div>
                                    <?php } ?>
                                    <div class="flex-btn">
                                        <input type="submit" name="update" value="update book" class="btn">
                                        <input type="submit" name="delete_post" value="delete book" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>no products added yet!</p>
                        </div>
                    ';

                    ?>
                    <br><br>
                    <div class="flex-btn">
                        <a href="view_product.php" class="btn">view books</a>
                        <a href="add_product.php" class="btn">add book</a>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>

</html>
