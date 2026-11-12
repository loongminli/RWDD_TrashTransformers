<?php 
    if ($_SESSION["role"] === "Coordinator") { 
        $name = $_SESSION["name"];
    } else {
        echo "<script> alert('You do not have permission to access these pages.'); window.location.href = '../index.php'; </script>";
    }
?> 