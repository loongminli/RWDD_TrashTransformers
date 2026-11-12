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

                $_SESSION["id"] = $accountinfo["staff_id"];
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
        * {
            font-family :'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            margin : 0;
            padding : 0;
            box-sizing : border-box;
        }

        body {
            background-color : #F7F4ED;
        }

        h1 {
            font-size : 3rem;
        }

        table th, td {
            font-size : 2rem;
            padding : 0.5rem;
        }

        input {
            font-size : 2rem;
        }

        button {
            font-size : 1.5rem;
            background-color : #C8A96B;
            border : 2px solid #9a814f;
            border-radius : 20px;
            padding : 0.3rem;
            cursor : pointer;
        }

        #content {
            display : flex;
            flex-direction : column;
            align-items : center;
            padding-top : 6rem;
        }
        
        .card {
            display : flex;
            flex-direction : column;
            border : 5px solid #8FA28A;
            background-color : #C7D3C0;
            border-radius : 10px;
            padding : 1rem;
            margin : 1rem;
        }

        .user-login-button {
            background-color : #C8A96B;
            border : 2px solid #9a814f;
            border-radius : 5px;
            color : black;
            text-decoration : none;
            padding : 0.3rem;
        }

        .homepage-button {
            background-color : #C8A96B;
            border : 2px solid #9a814f;
            border-radius : 5px;
            color : black;
            text-decoration : none;
            padding : 0.3rem;
            margin-bottom : 3rem;
        }

        @media (max-width : 768px) {
            input {
                max-width : 30vw;
            }
        }
    </style>
</head>
<body>
    <div id="content">
        <a class="homepage-button" href="index.php"> Return to Homepage </a>

        <h1> Staff Login </h1>
        <div class="card">
            <form id="staffLoginForm" method="post">
                <table>
                    <tr>
                        <th> Staff ID </th>
                        <td> <input type="text" name="staff_id" autofocus required> </td>
                    </tr>

                    <tr>
                        <th> Password </th>
                        <td> <input type="password" name="password" required> </td>
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

        <h4> Contact the admin to register a staff account. </h4>
        <br>
        <h4> Not a staff? </h4>
        <a class="user-login-button" href=""> User Login </a>
    </div>
</body>
</html>