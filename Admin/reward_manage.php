<?php
include "../dbconn.php" ;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $sql = "SELECT * FROM reward WHERE reward_id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reward Management</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .actions {
            display: flex;
            gap: 10px;
        }

        .actions form {
            margin: 0;
            padding: 0;
            background: none;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="main-content">

<?php if (isset($_GET['add'])) { ?>

    <h1>Add Reward</h1>

    <form action="reward_functions.php" method="POST">
        <input type="hidden" name="action" value="add">

        <label>Reward Name</label>
        <input type="text" name="reward" required>

        <button type="submit">Save</button>
        <a href="reward_manage.php" class="btn">Cancel</a>
    </form>

<?php } elseif (isset($_GET['edit'])) { ?>

    <h1>Edit Reward</h1>

    <form action="reward_functions.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="reward_id" value="<?php echo $row['reward_id']; ?>">

        <label>Reward Name</label>
        <input type="text" name="reward" value="<?php echo $row['reward']; ?>" required>

        <button type="submit">Save</button>
        <a href="reward_manage.php" class="btn">Cancel</a>
    </form>

<?php } else { ?>

    <h1>Reward Management</h1>
    <p>Manage recycling rewards and incentives.</p>

    <a href="reward_manage.php?add=1" class="btn">+ Add Reward</a>

    <table>
        <tr>
            <th>Reward ID</th>
            <th>Reward Name</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT * FROM reward";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['reward_id']; ?></td>
            <td><?php echo $row['reward']; ?></td>
            <td>
                <div class="actions">

                    <a class="btn" href="reward_manage.php?edit=<?php echo $row['reward_id']; ?>">Edit</a>

                    <form action="reward_functions.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="reward_id" value="<?php echo $row['reward_id']; ?>">
                        <button type="submit">Delete</button>
                    </form>

                </div>
            </td>
        </tr>
        <?php } ?>

    </table>

<?php } ?>

</div>

<script src="script.js"></script>
</body>
</html>
