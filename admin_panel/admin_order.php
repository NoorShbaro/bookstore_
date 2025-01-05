<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

//Update order
if (isset($_POST['update_order'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_SPECIAL_CHARS);
    $update_payment = filter_var($_POST['update_payment'], FILTER_SANITIZE_SPECIAL_CHARS);

    $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_pay->bind_param("ss", $update_payment, $order_id);
    $update_pay->execute();
    $success_msg[] = 'Order payment status has been updated.';
}

// Delete order
if (isset($_POST['delete_order'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_SPECIAL_CHARS);

    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->bind_param("s", $order_id);
    $delete_order->execute();

    if ($delete_order->affected_rows > 0) {
        $success_msg[] = 'Order has been deleted successfully.';
    } else {
        $warning_msg[] = 'Failed to delete the order.';
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
        <section class="order-container">
            <div class="heading">
                <h1>total order placed</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                $select_order->bind_param("s", $seller_id);
                $select_order->execute();
                $result = $select_order->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_order = $result->fetch_assoc()) { ?>
                        <div class="box">
                            <div class="status" style="color: <?php if ($fetch_order['status'] == 'in progress') {
                                                                    echo "green";
                                                                } else {
                                                                    echo "red";
                                                                } ?>;">
                                <?= $fetch_order['status']; ?>
                            </div>
                            <div class="details">
                                <p>username: <span><?= $fetch_order['name']; ?></span></p>
                                <p>user id: <span><?= $fetch_order['user_id']; ?></span></p>
                                <p>placed on: <span><?= $fetch_order['date']; ?></span></p>
                                <p>user number: <span><?= $fetch_order['number']; ?></span></p>
                                <p>user email: <span><?= $fetch_order['email']; ?></span></p>
                                <p>total price: <span><?= $fetch_order['price']; ?></span></p>
                                <p>payment method: <span><?= $fetch_order['method']; ?></span></p>
                                <p>user address: <span><?= $fetch_order['address']; ?></span></p>
                            </div>
                            <form action="" method="post">
                                <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                                <select name="update_payment" class="box" style="width: 90%;">
                                    <option disabled selected><?= $fetch_order['payment_status']; ?></option>
                                    <option value="pending">pending</option>
                                    <option value="order delivered">order delivered</option>
                                </select>
                                <div class="flex-btn">
                                    <input type="submit" name="update_order" value="update payment" class="btn">
                                    <input type="submit" name="delete_order" value="delete order" class="btn"
                                        onclick="return confirm('delete this order?')">
                                </div>
                            </form>
                        </div>
                <?php }
                } else {
                    echo '<div class="empty"><p>No orders found!</p></div>';
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