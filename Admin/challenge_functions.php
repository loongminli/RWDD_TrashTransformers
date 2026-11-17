<?php
include "../dbconn.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "add") {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $material = $_POST['material_required'];
        $quota = $_POST['quota'];

        $sql = "INSERT INTO challenge
                (month, year, material_required, quota)
                VALUES ('$month', '$year', '$material', '$quota')";

    } elseif ($action == "edit") {
        $id = (int) $_POST['challenge_id'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $material = $_POST['material_required'];
        $quota = $_POST['quota'];

        $sql = "UPDATE challenge SET
                month='$month',
                year='$year',
                material_required='$material',
                quota='$quota'
                WHERE challenge_id=$id";

    } elseif ($action == "delete") {
        $id = (int) $_POST['challenge_id'];

        $check = "SELECT * FROM challenge_reward WHERE challenge_id=$id";
        $result = mysqli_query($conn, $check);

        if (!$result) {
            header("Location: challenge_manage.php?error=database");
            exit();
        }
        if (mysqli_num_rows($result) > 0) {
            header("Location: challenge_manage.php?error=assigned_reward");
            exit();
        }

        $sql = "DELETE FROM challenge WHERE challenge_id=$id";
    }

    if (isset($sql)) {
        if (mysqli_query($conn, $sql)) {
            header("Location: challenge_manage.php?success=" . $action);
        } else {
            header("Location: challenge_manage.php?error=database");
        }
        exit();
    }
}
?>
