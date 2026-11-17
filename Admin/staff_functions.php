<?php
include "../dbconn.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "add") {
        $id = $_POST['staff_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $status = $_POST['is_active'];
        $check = "SELECT * FROM staff WHERE staff_id='$id'";
        $result = mysqli_query($conn, $check);

        if (mysqli_num_rows($result) > 0) {
            header("Location: staff_manage.php?error=duplicate_staff");
            exit();
        } else {
            $sql = "INSERT INTO staff(staff_id, name, gender, role, password, is_active)
                    VALUES('$id', '$name', '$gender', '$role', '$password', '$status')";
        }

    } elseif ($action == "edit") {
        $id = $_POST['staff_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $role = $_POST['role'];
        $status = $_POST['is_active'];

        $sql = "UPDATE staff 
                SET name='$name', gender='$gender', role='$role',is_active='$status' 
                WHERE staff_id='$id'";

        if ($_POST['password'] != "") {
            $password = $_POST['password'];

            $sql = "UPDATE staff 
                    SET name='$name', gender='$gender', role='$role', password='$password', is_active='$status'
                    WHERE staff_id='$id'";
        }

    } elseif ($action == "delete") {
        $id = $_POST['staff_id'];
        $sql = "DELETE FROM staff WHERE staff_id='$id'";
    }

    if (isset($sql)) {
        if (mysqli_query($conn, $sql)) {
            header("Location: staff_manage.php?success=" . $action);
            exit();
        } else {
            header("Location: staff_manage.php?error=database");
            exit();
        }
    }
}
?>
