<?php
include"dbconn.php";

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM user WHERE user_id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "header.php"; ?>

<div class="main-content">

<?php if (isset($_GET['edit']) && $row) { ?>

    <h1>Edit User Status</h1>

    <form action="user_functions.php" method="POST">

        <input type="hidden" name="action" value="update">
        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

        <p>User ID: <?php echo $row['user_id']; ?></p>
        <p>Username: <?php echo $row['username']; ?></p>

        <label>Status</label>
        <select name="is_active">
            <option value="1" <?php if ($row['is_active'] == 1) echo "selected"; ?>>Active</option>
            <option value="0" <?php if ($row['is_active'] == 0) echo "selected"; ?>>Inactive</option>
        </select>

        <button type="submit">Save</button>
        <a href="user_manage.php" class="btn">Cancel</a>

    </form>

<?php } else { ?>

    <h1>User Management</h1>
    <p>Manage user accounts and account status.</p>

    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Gender</th>
            <th>Account Made</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT * FROM user";
        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['account_made']; ?></td>

            <td>
                <?php
                if ($row['is_active'] == 1) {
                    echo "Active";
                } else {
                    echo "Inactive";
                }
                ?>
            </td>

            <td>
                <a class="btn" href="user_manage.php?edit=<?php echo $row['user_id']; ?>">Edit</a>
            </td>
        </tr>
        <?php } ?>

    </table>

<?php } ?>

</div>

<script src="script.js"></script>
</body>
</html>
