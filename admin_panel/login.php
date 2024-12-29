<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];

    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ? AND password = ?");
    $select_seller->bind_param('ss', $email, $pass);
    $select_seller->execute();

    $result = $select_seller->get_result();

    if ($row = $result->fetch_assoc()) {
        setcookie('seller_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('location: dashboard.php');
    } else {
        $warning_msg[] = 'Incorrect email or password';
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
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Login Now!</h3>
            <div class="input-field">
                <p>your email<span>*</span></p>
                <input type="email" name="email" placeholder="enter your email"
                    maxlength="50" required class="box">
            </div>
            <div class="input-field">
                <p>your password<span>*</span></p>
                <input type="password" name="pass" placeholder="enter your password"
                    maxlength="50" required class="box">
            </div>
            <p class="link">do you have an account?<a href="register.php">register now</a></p>
            <input type="submit" name="submit" value="login now" class="btn">
        </form>
    </div>

    <!--link got from sweet alert cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!--my javascript code-->
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>

</html>