<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
    
    $id = unique_id();
    
    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    
    if ($pass !== $cpass) {
        $warning_msg[] = 'Confirm password does not match!';
    } else {
        $hashed_pass = sha1($pass);  
        
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/' . $rename;

        $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE `email` = ?");
        $select_seller->execute([$email]);

        if ($select_seller->fetch()) {
            $warning_msg[] = 'Email already exists!';
        } else {
            $insert_seller = $conn->prepare("INSERT INTO `sellers` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
            $insert_seller->execute([$id, $name, $email, $hashed_pass, $rename]);

            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'New seller registered! Please login now.';
        }
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
    <!--link got from font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>


    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Register Now!</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>your name<span>*</span></p>
                        <input type="text" name="name"
                            placeholder="enter your name"
                            maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>your email<span>*</span></p>
                        <input type="email" name="email"
                            placeholder="enter your email"
                            maxlength="50" required class="box">
                    </div>
                </div>

                <div class="col">
                    <div class="input-field">
                        <p>your passsword<span>*</span></p>
                        <input type="password" name="pass"
                            placeholder="enter your password"
                            maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>confirm your password<span>*</span></p>
                        <input type="password" name="cpass"
                            placeholder="confirm your password"
                            maxlength="50" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p>your profile<span>*</span></p>
                <input type="file" name="image"
                    accept="image/*"
                    required class="box">
            </div>

            <p class="link">already have an account?<a href="login.php">Login now</a></p>
            <input type="submit" name="submit" value="register now" class="btn">
        </form>
    </div>



    <!--link got from sweet alert cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!--my javascript code-->
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>

</html>