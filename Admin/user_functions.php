<?php
include "../dbconn.php"; 

if (isset($_POST['action'])) {

    $action = $_POST['action'];

    if ($action == "update") {

        $id = $_POST['user_id'];
        $status = $_POST['is_active'];

        $sql = "UPDATE user SET is_active='$status'
                WHERE user_id='$id'"; // Update status

        if (mysqli_query($conn, $sql)) {
            header("Location: user_manage.php");
            exit();
        } else {
            echo mysqli_error($conn);
        }
    }
}
?>