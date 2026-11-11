<?php
    include "../dbconn.php";

    $id = $_GET["dropoff_id"];

    $update = mysqli_query($conn, "
        UPDATE dropoff_nonrecyclable
        SET
            status = 'complete'
        WHERE dropoff_id = '$id';
    ");

    if ($update) {
        echo "<script> window.location.href = 'RC_nonrecyclables.php'; alert('Dropoff is successfully marked as complete!'); </script>";
    } else {
        echo "<script> window.location.href = 'RC_nonrecyclables.php'; alert('Status update failed.'); </script>";        
    }

    mysqli_close($conn);
?>