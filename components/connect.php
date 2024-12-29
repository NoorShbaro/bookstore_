<?php 

    $conn = new mysqli('localhost', 'root', '', 'bookstore_db');

    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    } 

    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }

        // Return the unique random string
        return $randomString;
    }
?>
