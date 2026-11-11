<?php
    include "dbconn.php";

    if (isset($_POST["btnLogin"])) {
        $staff_id = strtoupper(trim($_POST["staff_id"])) ?? "";
        $password = $_POST["password"] ?? "";

        $checkaccount_result = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id = '$staff_id' AND password = '$password';");

        if (mysqli_num_rows($checkaccount_result) == 0) {
            echo "<script> alert('Incorrect credentials. Please try again.'); </script>";
        } else {
            $accountinfo_result = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id = '$staff_id';");
            $accountinfo = mysqli_fetch_assoc($accountinfo_result);

            if ($accountinfo["is_active"] === "0") {
                echo "<script> alert('Your account is deactivated. Please contact the admin if this is a mistake.'); </script>";
            } else {
                $role = $accountinfo["role"];

                $_SESSION["staff_id"] = $accountinfo["staff_id"];
                $_SESSION["role"] = $role;
                $_SESSION["name"] = $accountinfo["name"];

                if ($role === "Admin") {
                    // header("Location:");
                } elseif ($role === "Collector") {
                    // header("Location:");
                } elseif ($role === "Coordinator") {
                    header("Location: RecyclingCoordinator/RC_homepage.php");
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Staff Login </title>

    <style>

    </style>
</head>
<body>
    <div id="content">
        <h1> Staff Login </h1>
        <form id="staffLoginForm" method="post">
            <table>
                <tr>
                    <th> Staff ID </th>
                    <td> <input type="text" name="staff_id"> </td>
                </tr>

                <tr>
                    <th> Password </th>
                    <td> <input type="password" name="password"> </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button type="reset"> Reset </button>
                        <button type="submit" name="btnLogin"> Login </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>