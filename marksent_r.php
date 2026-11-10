<?php
    include "dbconn.php";

    $id = $_GET["dropoff_id"];

    $update = mysqli_query($conn, "
        UPDATE dropoff_recyclingcentre
        SET
            is_sent = 1
        WHERE dropoff_id = '$id';
    ");

    if ($update) {
        echo "<script> window.location.href = 'RC_recyclables.php'; alert('Dropoff is successfully marked as sent!'); </script>";
    } else {
        echo "<script> window.location.href = 'RC_recyclables.php'; alert('Status update failed.'); </script>";        
    }
?>