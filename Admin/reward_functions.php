<?php
include "../dbconn.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "add") {
        $reward = $_POST['reward'];
        $sql = "INSERT INTO reward(reward) VALUES ('$reward')";

    } elseif ($action == "edit") {
        $id = (int) $_POST['reward_id'];
        $reward = $_POST['reward'];
        $sql = "UPDATE reward SET reward='$reward' WHERE reward_id=$id";

    } elseif ($action == "delete") {
        $id = (int) $_POST['reward_id'];

        $check = "SELECT * FROM challenge_reward WHERE reward_id=$id";
        $result = mysqli_query($conn, $check);

        if (!$result) {
            header("Location: reward_manage.php?error=database");
            exit();
        }
        if (mysqli_num_rows($result) > 0) {
            header("Location: reward_manage.php?error=assigned_challenge");
            exit();
        }
        $sql = "DELETE FROM reward WHERE reward_id=$id";
    }

    if (isset($sql)) {
        if (mysqli_query($conn, $sql)) {
            header("Location: reward_manage.php?success=" . $action);
        } else {
            header("Location: reward_manage.php?error=database");
        }
        exit();
    }
}
?>
