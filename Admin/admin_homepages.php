<?php
include "../dbconn.php";

$staff_result = mysqli_query($conn, "SELECT COUNT(*) AS TOTAL FROM staff");
$staff = mysqli_fetch_assoc($staff_result);

$user_result = mysqli_query($conn, "SELECT COUNT(*) AS TOTAL FROM user");
$user = mysqli_fetch_assoc($user_result);

$challenge_result = mysqli_query($conn, "SELECT COUNT(*) AS TOTAL FROM challenge");
$challenge = mysqli_fetch_assoc($challenge_result);

$reward_result = mysqli_query($conn, "SELECT COUNT(*) AS TOTAL FROM reward");
$reward = mysqli_fetch_assoc($reward_result);

$challengereward_result = mysqli_query($conn, "SELECT COUNT(*) AS TOTAL FROM challenge_reward");
$challengereward = mysqli_fetch_assoc($challengereward_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include "header.php"; ?>
    <div class="main-content">

        <h1>Administrator Homepage</h1>
        <p>Welcome to Trash Transformers Management System.</p>

        <h2>Management Overview</h2>
        <div class="cards dashboard-cards">
            <div class="card">
                <h2>👥</h2>
                <h3>Staff Management</h3>
                <h2><?php echo $staff["TOTAL"]; ?></h2>
                <p>Total Staff</p>
                <a href="staff_manage.php" class="btn">Manage Staff</a>
            </div>

            <div class="card">
                <h2>👤</h2>
                <h3>User Management</h3>
                <h2><?php echo $user["TOTAL"]; ?></h2>
                <p>Total Users</p>
                <a href="user_manage.php" class="btn">Manage Users</a>
            </div>

            <div class="card">
                <h2>🎯</h2>
                <h3>Monthly Challenges</h3>
                <h2><?php echo $challenge["TOTAL"]; ?></h2>
                <p>Total Challenges</p>
                <a href="challenge_manage.php" class="btn">Manage Challenges</a>
            </div>

            <div class="card">
                <h2>🎁</h2>
                <h3>Rewards Management</h3>
                <h2><?php echo $reward["TOTAL"]; ?></h2>
                <p>Total Rewards</p>
                <a href="reward_manage.php" class="btn">Manage Rewards</a>
            </div>

            <div class="card">
                <h2>🏆</h2>
                <h3>Challenge Rewards</h3>
                <h2><?php echo $challengereward["TOTAL"]; ?></h2>
                <p>Total Assigned Rewards</p>
                <a href="challenge_reward_manage.php" class="btn">Manage Challenge Rewards</a>
            </div>
        </div>
    </div>
</body>
</html>
