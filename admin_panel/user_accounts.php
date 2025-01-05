<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
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
        <section class="user-container">
            <div class="heading">
                <h1>registred users</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();
                $result = $select_users->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_users = $result->fetch_assoc()) {
                        $user_id = $fetch_users['id'];

                ?>
                        <div class="box">
                            <img src="../uploaded_files/<?= $fetch_users['image']; ?>">
                            <p>user id: <span><?= $user_id; ?></span></p>
                            <p>username: <span><?= $fetch_users['name']; ?></span></p>
                            <p>user email: <span><?= $fetch_users['email']; ?></span></p>
                        </div>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>no users registred yet!</p>
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