<?php
include "../dbconn.php";

$sql = "SELECT * FROM challenge";
$result = mysqli_query($conn, $sql);

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $sql = "SELECT * FROM challenge WHERE challenge_id=$id";
    $result_edit = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .actions form {
            margin: 0;
            padding: 0;
            background: none;
        }
    </style>
</head>
<body onload="showMessage()">
<?php include "header.php"; ?>
<div class="main-content">

<?php if (isset($_GET['add']) || isset($_GET['edit'])) { ?>
    <?php if (isset($_GET['edit'])) { ?>
        <h1>Edit Challenge</h1>
    <?php } else { ?>
        <h1>Add Challenge</h1>
    <?php } ?>

    <form action="challenge_functions.php" method="POST">
        <?php if (isset($_GET['edit'])) { ?>
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="challenge_id" value="<?php echo $row['challenge_id']; ?>">
        <?php } else { ?>
            <input type="hidden" name="action" value="add">
        <?php } ?>

        <label>Month</label>
        <select name="month" required>
            <?php
            $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            foreach ($months as $month) {
                $selected = "";
                if (isset($row) && $row['month'] == $month) {
                    $selected = "selected";
                } echo "<option value='$month' $selected>$month</option>";
            } ?>
        </select>

        <label>Year</label>
        <select name="year" required>
            <?php
            for ($year = 2026; $year <= 2030; $year++) {
                $selected = "";
                if (isset($row) && $row['year'] == $year) {
                    $selected = "selected";
                } echo "<option value='$year' $selected>$year</option>";
            } ?>
        </select>

        <label>Material Required</label>
        <input type="text" name="material_required"
               value="<?php if (isset($row)) echo $row['material_required']; ?>" required>

        <label>Quota(kg)</label>
        <input type="number" name="quota" min="1"
               value="<?php if (isset($row)) echo $row['quota']; ?>" required>

        <button type="submit">Save</button>
        <a href="challenge_manage.php" class="btn">Cancel</a>
    </form>

<?php } else { ?>
    <h1>Challenge Management</h1>
    <p>Manage monthly recycling challenges and targets.</p>
    <a href="challenge_manage.php?add=1" class="btn">+ Add Challenge</a>

    <table>
        <tr>
            <th>ID</th> <th>Month</th> <th>Year</th> <th>Material Required</th> <th>Quota(kg)</th> <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['challenge_id']; ?></td>
            <td><?php echo $row['month']; ?></td>
            <td><?php echo $row['year']; ?></td>
            <td><?php echo $row['material_required']; ?></td>
            <td><?php echo $row['quota']; ?></td>
            <td>
                <div class="actions">
                    <a class="btn" href="challenge_manage.php?edit=<?php echo $row['challenge_id']; ?>">Edit</a>

                    <form action="challenge_functions.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="challenge_id" value="<?php echo $row['challenge_id']; ?>">
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
