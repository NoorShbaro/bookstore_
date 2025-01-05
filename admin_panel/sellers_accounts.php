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
                <h1>sellers</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_sellers = $conn->prepare("SELECT * FROM `sellers`");
                $select_sellers->execute();
                $result = $select_sellers->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_sellers = $result->fetch_assoc()) {
                        $sellers_id = $fetch_sellers['id'];

                ?>
                        <div class="box">
                            <img src="../uploaded_files/<?= $fetch_sellers['image']; ?>">
                            <p>seller id: <span><?= $sellers_id; ?></span></p>
                            <p>seller name: <span><?= $fetch_sellers['name']; ?></span></p>
                            <p>seller email: <span><?= $fetch_sellers['email']; ?></span></p>
                        </div>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>no sellers yet!</p>
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