<?php
    session_start();
    session_destroy(); //remove all data from the session
    header("Location: index.php");
?>