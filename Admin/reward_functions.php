<?php
include "dbconn.php";

if (isset($_POST['action'])) {

    $action = $_POST['action'];

    if ($action == "add") {

        $reward = $_POST['reward'];

        $sql = "INSERT INTO reward (reward) VALUES ('$reward')";

    } elseif ($action == "update") {

        $id = (int) $_POST['reward_id'];
        $reward = $_POST['reward'];

        $sql = "UPDATE reward SET reward='$reward' WHERE reward_id=$id";

    } elseif ($action == "delete") {

        $id = (int) $_POST['reward_id'];

        $sql = "DELETE FROM reward WHERE reward_id=$id";
    }

    if (isset($sql)) {

        if (mysqli_query($con, $sql)) {
            header("Location: reward_manage.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }

    }
}
?>
