<?php
include "dbconn.php";

if (isset($_POST['add'])) {
    $challenge = (int) $_POST['challenge_id'];
    $reward = (int) $_POST['reward_id'];

    $sql = "INSERT INTO challenge_reward VALUES ($challenge, $reward)";
    mysqli_query($con, $sql);
}

if (isset($_POST['delete'])) {
    $challenge = (int) $_POST['challenge_id'];

    $sql = "DELETE FROM challenge_reward WHERE challenge_id=$challenge";
    mysqli_query($con, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Reward Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "header.php"; ?>

<div class="main-content">

<h1>Challenge Reward Management</h1>
<p>Assign rewards to recycling challenges.</p>

<form method="POST">
    <label>Challenge</label>
    <select name="challenge_id" required>
        <option value="">Select Challenge</option>
        <?php
        $result = mysqli_query($con, "SELECT * FROM challenge");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='$row[challenge_id]'>
                  $row[month] $row[year] - $row[material_required]
                  </option>";
        }
        ?>
    </select>

    <label>Reward</label>
    <select name="reward_id" required>
        <option value="">Select Reward</option>
        <?php
        $result = mysqli_query($con, "SELECT * FROM reward");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='$row[reward_id]'>$row[reward]</option>";
        }
        ?>
    </select>

    <button type="submit" name="add">Assign Reward</button>
</form>

<h2>Assigned Rewards</h2>

<table>
    <tr>
        <th>Challenge</th>
        <th>Reward</th>
        <th>Action</th>
    </tr>

    <?php
    $sql = "SELECT * FROM challenge_reward
            JOIN challenge USING (challenge_id)
            JOIN reward USING (reward_id)";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row['month'] . " " . $row['year'] . " - " . $row['material_required']; ?></td>
        <td><?php echo $row['reward']; ?></td>
        <td>
            <form method="POST" style="margin:0; padding:0; background:none;">
                <input type="hidden" name="challenge_id" value="<?php echo $row['challenge_id']; ?>">
                <button type="submit" name="delete">Remove</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

<script src="script.js"></script>
</body>
</html>
