
<?php
include "../dbconn.php";

$tp_error = "";
$username_error = "";
$password_error = "";
$confirm_error = "";
$register_error = "";

if (isset($_POST['register'])) {

    $tp = trim($_POST['tp']);
    $username = trim($_POST['username']);
    $nickname = trim($_POST['nickname']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($tp)) {
        $tp_error = "Enter your TP Number.";
    }

    if (empty($username)) {
        $username_error = "Enter your username.";
    }

    if (empty($password)) {
        $password_error = "Enter your password.";
    }

    if (empty($confirm_password)) {
        $confirm_error = "Confirm your password.";
    }
    elseif ($password != $confirm_password) {
        $confirm_error = "Passwords do not match.";
    }

    if (!empty($tp)) {

        $tp = mysqli_real_escape_string($conn, $tp);

        $sql = "SELECT * FROM user WHERE user_id = '$tp'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $tp_error = "TP Number already registered.";
        }
    }

    if ($tp_error == "" && $username_error == "" &&
        $password_error == "" && $confirm_error == "") {

        $username = mysqli_real_escape_string($conn, $username);
        $nickname = mysqli_real_escape_string($conn, $nickname);

        $sql = "INSERT INTO user
                (user_id, username, nickname, password, account_made, is_active)
                VALUES
                ('$tp', '$username', '$nickname', '$password', CURDATE(), 1)";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        }
        else {
            $register_error = "Registration failed. Please try again.";
        }
    }

    $_SESSION['tp_error'] = $tp_error;
    $_SESSION['username_error'] = $username_error;
    $_SESSION['password_error'] = $password_error;
    $_SESSION['confirm_error'] = $confirm_error;
    $_SESSION['register_error'] = $register_error;

    header("Location: register.php");
    exit();
}

$tp_error = $_SESSION['tp_error'] ?? "";
$username_error = $_SESSION['username_error'] ?? "";
$password_error = $_SESSION['password_error'] ?? "";
$confirm_error = $_SESSION['confirm_error'] ?? "";
$register_error = $_SESSION['register_error'] ?? "";

unset($_SESSION['tp_error']);
unset($_SESSION['username_error']);
unset($_SESSION['password_error']);
unset($_SESSION['confirm_error']);
unset($_SESSION['register_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>

<div class="container">
    <div class="register">

        <div class="logo">
            <a href="../index.php"> <img src="../logo.png" alt="Trash Transformers Logo"> </a>
            <h3>Trash Transformers</h3>
        </div>

        <h1>Create an Account</h1>
        <p>The first mark for transformation.</p>

        <?php
        if ($register_error != "") {
            echo "<p class='error-message'>$register_error</p>";
        }
        ?>

        <form action="register.php" method="post" autocomplete="off">

            <label>TP Number</label>
            <input type="text" name="tp"
                placeholder="Enter your TP Number"
                maxlength="8"
                autocomplete="off">

            <?php
            if ($tp_error != "") {
                echo "<p class='error-message'>$tp_error</p>";
            }
            ?>

            <label>Username</label>
            <input type="text" name="username"
                placeholder="Enter your username"
                maxlength="100"
                autocomplete="off">

            <?php
            if ($username_error != "") {
                echo "<p class='error-message'>$username_error</p>";
            }
            ?>

            <label>Nickname</label>
            <input type="text" name="nickname"
                placeholder="Enter your nickname (optional)"
                maxlength="100"
                autocomplete="off">

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

            <label>Confirm Password</label>
            <input type="password" name="confirm_password"
                id="confirm_password"
                placeholder="Confirm your password"
                maxlength="10"
                autocomplete="new-password">

            <?php
            if ($confirm_error != "") {
                echo "<p class='error-message'>$confirm_error</p>";
            }
            ?>

            <label class="show-password">
                <input type="checkbox" onclick="showPassword()">
                Show Password
            </label>

            <input type="submit" name="register" value="Create Account">

        </form>

        <p>Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

    <div class="image"></div>
</div>

<script>
function showPassword() {

    let password = document.getElementById("password");
    let confirmPassword = document.getElementById("confirm_password");

    if (password.type == "password") {
        password.type = "text";
        confirmPassword.type = "text";
    }
    else {
        password.type = "password";
        confirmPassword.type = "password";
    }
}
</script>

</body>
</html>
