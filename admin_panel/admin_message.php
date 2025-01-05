<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

if (isset($_POST['delete_msg'])) {
    $delete_id = filter_var($_POST['delete_id'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Verify if the message exists
    $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");
    $verify_delete->bind_param("s", $delete_id);
    $verify_delete->execute();
    $result = $verify_delete->get_result();

    if ($result->num_rows > 0) {
        // If the message exists, delete it
        $delete_msg = $conn->prepare("DELETE FROM `message` WHERE id = ?");
        $delete_msg->bind_param("s", $delete_id);
        $delete_msg->execute();

        $success_msg[] = 'Message deleted successfully.';
    } else {
        $warning_msg[] = 'Message already deleted or does not exist.';
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
        <section class="message-container">
            <div class="heading">
                <h1>messages</h1>
                <img src="../image/seperator-img.png">
            </div>
            <div class="box-container">
                <?php
                // No parameters needed; bind_param() removed
                $select_message = $conn->prepare("SELECT * FROM `message`");
                $select_message->execute();
                $result = $select_message->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_message = $result->fetch_assoc()) {
                ?>
                        <div class="box">
                            <h3 class="name"><?= $fetch_message['name']; ?></h3>
                            <h4><?= $fetch_message['subject']; ?></h4>
                            <p><?= $fetch_message['message']; ?></p>

                            <form action="" method="post">
                                <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                                <input type="submit" name="delete_msg" value="delete message" class="btn" onclick="return confirm('delete these message?');">
                            </form>
                        </div>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>no message yet!</p>
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
