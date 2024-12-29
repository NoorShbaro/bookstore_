<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {
    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");
    $select_seller->bind_param("s", $seller_id);
    $select_seller->execute();
    $result = $select_seller->get_result();

    if ($result->num_rows > 0) {
        $fetch_seller = $result->fetch_assoc();
    }

    $prev_pass = $fetch_seller['password'];  // The hashed password from DB
    $prev_image = $fetch_seller['image'];

    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Update name
    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");
        $update_name->bind_param("ss", $name, $seller_id);
        $update_name->execute();
        $success_msg[] = 'Username updated successfully!';
    }

    // Update email
    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? AND email = ?");
        $select_email->bind_param("ss", $seller_id, $email);
        $select_email->execute();

        $result_email = $select_email->get_result();

        if ($result_email->num_rows > 0) {
            $warning_msg[] = 'Email already exists';
        } else {
            $update_email = $conn->prepare("UPDATE `sellers` SET email = ? WHERE id = ?");
            $update_email->bind_param("ss", $email, $seller_id);
            $update_email->execute();
            $success_msg[] = 'Email updated successfully!';
        }
    }

    // Handling the image upload
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large.';
        } else {
            $update_image = $conn->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
            $update_image->bind_param("ss", $rename, $seller_id);
            $update_image->execute();

            if ($update_image->affected_rows > 0) {
                move_uploaded_file($image_tmp_name, $image_folder);
                if (!empty($prev_image) && file_exists('../uploaded_files/' . $prev_image) && $prev_image != $rename) {
                    unlink('../uploaded_files/' . $prev_image);
                }
                $success_msg[] = 'Image updated successfully!';
            } else {
                $warning_msg[] = 'Failed to update image in the database!';
            }
        }
    }
    // Old password verification and update
    $old_pass = $_POST['old_pass'];  // Raw old password entered
    $new_pass = $_POST['new_pass'];  // New password entered
    $cpass = $_POST['cpass'];        // Confirm new password

    // Check if the entered old password matches the hashed password in DB
    if ($old_pass != $prev_pass) {
        $warning_msg[] = 'Old password does not match';
    } elseif ($new_pass != $cpass) {
        $warning_msg[] = 'New password does not match the confirmation';
    } else {
        $update_pass = $conn->prepare("UPDATE `sellers` SET password = ? WHERE id = ?");
        $update_pass->bind_param("ss", $new_pass, $seller_id);
        $update_pass->execute();
        $success_msg[] = 'Password updated successfully!';
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
        <section class="form-container">
            <div class="heading">
                <h1>update profile</h1>
                <img src="../image/seperator-img.png">
            </div>
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="img-box">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                </div>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p>your name<span>*</span></p>
                            <input type="text" name="name"
                                placeholder="<?= $fetch_profile['name']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>your email<span>*</span></p>
                            <input type="email" name="email"
                                placeholder="<?= $fetch_profile['email']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>select pic<span>*</span></p>
                            <input type="file" name="image"
                                accept="image/*" class="box">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-field">
                            <p>old password<span>*</span></p>
                            <input type="password" name="old_pass"
                                placeholder="enter your old password" class="box">
                        </div>
                        <div class="input-field">
                            <p>new password<span>*</span></p>
                            <input type="password" name="new_pass"
                                placeholder="enter a new password" class="box">
                        </div>
                        <div class="input-field">
                            <p>confirm password<span>*</span></p>
                            <input type="password" name="cpass"
                                placeholder="confirm your password" class="box">
                        </div>
                    </div>
                </div>
                <input type="submit" name="submit" value="update profile" class="btn">
            </form>
        </section>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>

</html>