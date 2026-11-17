<?php
include "../dbconn.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "add") {
        $challenge = (int) $_POST['challenge_id'];
        $reward = (int) $_POST['reward_id'];

        $check = "SELECT * FROM challenge_reward
                  WHERE challenge_id=$challenge OR reward_id=$reward";
        $result = mysqli_query($conn, $check);

        if (!$result) {
            header("Location: challenge_reward_manage.php?error=database");
            exit();
        }

        if (mysqli_num_rows($result) > 0) {
            header("Location: challenge_reward_manage.php?error=duplicate_assignment");
            exit();
        }

        $sql = "INSERT INTO challenge_reward (challenge_id, reward_id)
                VALUES ($challenge, $reward)";

    } elseif ($action == "delete") {
        $challenge = (int) $_POST['challenge_id'];
        $reward = (int) $_POST['reward_id'];

        $sql = "DELETE FROM challenge_reward
                WHERE challenge_id=$challenge AND reward_id=$reward";
    }

    if (isset($sql)) {
        try {
            mysqli_query($conn, $sql);
            header("Location: challenge_reward_manage.php?success=" . $action);
        } catch (mysqli_sql_exception $e) {
            header("Location: challenge_reward_manage.php?error=database");
        }
        exit();
    }
}

$sql = "SELECT * FROM challenge";
$result_challenge = mysqli_query($conn, $sql);

$sql = "SELECT * FROM reward";
$result_reward = mysqli_query($conn, $sql);

$sql = "SELECT * FROM challenge_reward
        JOIN challenge USING (challenge_id)
        JOIN reward USING (reward_id)";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Reward Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body onload="showMessage()">

<?php include "header.php"; ?>
<div class="main-content">

<h1>Challenge Reward Management</h1>
<p>Assign rewards to recycling challenges.</p>

<form method="POST">
    <input type="hidden" name="action" value="add">

    <label>Challenge</label>
    <select name="challenge_id" required>
        <option value="">Select Challenge</option>
        <?php while ($row = mysqli_fetch_assoc($result_challenge)) { ?>
            <option value="<?php echo $row['challenge_id']; ?>">
                <?php echo $row['month'] . " " . $row['year'] . " - " . $row['material_required']; ?>
            </option>
        <?php } ?>
    </select>

    <label>Reward</label>
    <select name="reward_id" required>
        <option value="">Select Reward</option>
        <?php while ($row = mysqli_fetch_assoc($result_reward)) { ?>
            <option value="<?php echo $row['reward_id']; ?>">
                <?php echo $row['reward']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Assign Reward</button>
</form>

<h2>Assigned Rewards</h2>
<table class="assigned-table">
    <tr>
        <th>Challenge ID</th><th>Challenge</th><th>Reward ID</th><th>Reward</th><th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['challenge_id']; ?></td>
        <td><?php echo $row['month'] . " " . $row['year'] . " - " . $row['material_required']; ?></td>
        <td><?php echo $row['reward_id']; ?></td>
        <td><?php echo $row['reward']; ?></td>
        <td>
            <form method="POST" class="assignment-remove-form"
                  onsubmit="return confirmDelete('challenge_reward')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="challenge_id" value="<?php echo $row['challenge_id']; ?>">
                <input type="hidden" name="reward_id" value="<?php echo $row['reward_id']; ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
</div>
<script src="script.js?v=2"></script>
</body>
</html>
