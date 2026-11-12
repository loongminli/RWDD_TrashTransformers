<?php
    include "../dbconn.php";
    include "checkaccess.php";

    $id = $_GET["dropoff_id"];

    $update_sent = mysqli_query($conn, "
        UPDATE dropoff_recyclingcentre
        SET
            is_sent = 1
        WHERE dropoff_id = '$id';
    ");

    $update_complete = mysqli_query($conn, "
        UPDATE dropoff_recyclable
        SET
            status = 'complete'
        WHERE dropoff_id = '$id';
    ");

    if ($update_sent && $update_complete) {
        echo "<script> window.location.href = 'RC_recyclables.php'; alert('Dropoff is successfully marked as sent!'); </script>";
    } else {
        echo "<script> window.location.href = 'RC_recyclables.php'; alert('Status update failed.'); </script>";        
    }

    mysqli_close($conn);
?>