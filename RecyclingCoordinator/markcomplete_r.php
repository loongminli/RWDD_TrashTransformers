<?php
    include "../dbconn.php";
    include "checkaccess.php";

    $id = $_GET["dropoff_id"];

    $update = mysqli_query($conn, "
        UPDATE dropoff_recyclable
        SET
            status = 'complete'
        WHERE dropoff_id = '$id';
    ");

    if ($update) {
        echo "<script> window.location.href = 'RC_recyclables.php'; alert('Dropoff is successfully marked as complete!'); </script>";
    } else {
        echo "<script> window.location.href = 'RC_recyclables.php'; alert('Status update failed.'); </script>";        
    }

    mysqli_close($conn);
?>