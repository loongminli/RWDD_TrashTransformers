<?php
include "../dbconn.php";

$tp_error = "";
$password_error = "";
$account_error = "";

if (isset($_POST['login'])) {

    $tp = trim($_POST['tp']);
    $password = $_POST['password'];

    if ($tp == "") {
        $tp_error = "Enter your TP Number.";
    }

    if ($password == "") {
        $password_error = "Enter your password.";
    }

    if ($tp != "" && $password != "") {

        $tp = mysqli_real_escape_string($conn, $tp);
        $result = mysqli_query($conn,
            "SELECT * FROM user WHERE user_id = '$tp'");

        if (mysqli_num_rows($result) == 0) {
            $tp_error = "TP Number not found.";
            $password_error = "Unable to verify password.";
        }
        else {
            $user = mysqli_fetch_assoc($result);

            if ($user['is_active'] == 0) {
                $account_error = "This account is inactive.";
            }
            elseif (!password_verify($password, $user['password']) &&
            $password != $user['password']) {
            $password_error = "Incorrect password.";
            
            }
            else {
                session_regenerate_id(true);
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = "User";

                header("Location: user.php");
                exit();
            }
        }
    }


    $_SESSION['tp_error'] = $tp_error;
    $_SESSION['password_error'] = $password_error;
    $_SESSION['account_error'] = $account_error;

    header("Location: login.php");
    exit();
}

$tp_error = $_SESSION['tp_error'] ?? "";
$password_error = $_SESSION['password_error'] ?? "";
$account_error = $_SESSION['account_error'] ?? "";

unset($_SESSION['tp_error']);
unset($_SESSION['password_error']);
unset($_SESSION['account_error']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="mobile.css">
    
</head>

<body>

<div class="login-container">

    <div class="login-image"></div>

    <div class="register login-form">

        <div class="logo">
            <a href="../index.php"> <img src="../logo.png" alt="Trash Transformers Logo"> </a>
            <h3>Trash Transformers</h3>
        </div>

        <h1>Welcome!</h1>
        <p>Every return brings new growth</p>

        <?php
        if ($account_error != "") {
            echo "<p class='error-message'>$account_error</p>";
        }
        ?>

        <form action="login.php" method="post" autocomplete="off">

            <label>TP Number</label>
            <input type="text" name="tp"
                placeholder="Enter your TP Number"
                maxlength="8"
                autocomplete="new-password">

            <?php
            if ($tp_error != "") {
                echo "<p class='error-message'>$tp_error</p>";
            }
            ?>

          <label>Password</label>
<input type="password" name="password" id="password"
    placeholder="Enter your password"
    maxlength="10"
    autocomplete="new-password">

    <?php
if ($password_error != "") {
    echo "<p class='error-message'>$password_error</p>";
}
?>

<label class="show-password">
    <input type="checkbox" onclick="showPassword()">
    Show Password
</label>

            <input type="submit" name="login" value="Login">

        </form>

        <p>Don't have an account?
            <a href="register.php">Register here</a>
        </p>

        <p>Looking for staff login?
            <a href="../staff_login.php"> Staff login</a>
        </p>

    </div>
</div>

<script>
function showPassword() {
    let password = document.getElementById("password");

    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}
</script>

</body>
</html>

