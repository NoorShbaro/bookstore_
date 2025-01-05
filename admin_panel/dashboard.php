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
    <!--link got from font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>

<body>

    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>dashboard</h1>
                <img src="../image/seperator-img.png">
            </div>

            <div class="box-container">
                <div class="box">
                    <h3>welcome !</h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="update.php" class="btn">update profile</a>
                </div>
                <div class="box">
                    <?php
                    $select_message = $conn->prepare("SELECT * FROM `message`");
                    $select_message->execute();

                    $result = $select_message->get_result();
                    $number_of_msg = $result->num_rows;
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>Messages</p>
                    <a href="admin_message.php" class="btn">See Messages</a>
                </div>
                <div class="box">
                    <?php
                    $select_sellers = $conn->prepare("SELECT * FROM `sellers`");
                    $select_sellers->execute();

                    $result = $select_sellers->get_result();
                    $number_of_sellers = $result->num_rows;
                    ?>
                    <h3><?= $number_of_sellers; ?></h3>
                    <p>sellers accounts</p>
                    <a href="sellers_accounts.php" class="btn">See sellers</a>
                </div>
                <div class="box">
                    <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id=?");
                    $select_orders->bind_param("s", $seller_id);
                    $select_orders->execute();

                    $result = $select_orders->get_result();
                    $number_of_orders = $result->num_rows;
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>total orders placed</p>
                    <a href="admin_order.php" class="btn">total orders</a>
                </div>
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