
<?php
include "../dbconn.php";

if (isset($_POST['action'])) {

    $action = $_POST['action'];

    if ($action == "add") {

        $month = $_POST['month'];
        $year = $_POST['year'];
        $material = $_POST['material_required'];
        $quota = $_POST['quota'];

        $sql = "INSERT INTO challenge (month, year, material_required, quota)
                VALUES ('$month', '$year', '$material', '$quota')";

    } elseif ($action == "update") {

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

        $sql = "DELETE FROM challenge WHERE challenge_id=$id";
    }

    if (isset($sql)) {

        if (mysqli_query($conn, $sql)) {
            header("Location: challenge_manage.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

    }
}
?>
