<?php
include "dbconn.php"; 

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM staff WHERE staff_id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .staff-table {
            width: 100%;
            margin-top: 20px;
        }

        .staff-table th, .staff-table td {
            padding: 10px;
        }

        .staff-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .staff-actions form {
            margin: 0;
            padding: 0;
            background: none;
        }

        .staff-form {
            max-width: 600px;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="main-content">

<?php if (isset($_GET['add']) || isset($_GET['edit'])) { ?>

    <h1>
        <?php
        if (isset($_GET['edit'])) {
            echo "Edit Staff";
        } else {
            echo "Add Staff";
        }
        ?>
    </h1>

    <form class="staff-form" action="staff_functions.php" method="POST"
          onsubmit="return checkStaffForm();" novalidate>

        <?php if (isset($_GET['edit'])) { ?>

            <input type="hidden" name="action" value="update">
            <input type="hidden" name="staff_id" value="<?php echo $row['staff_id']; ?>">

            <label>Staff ID</label>
            <input type="text" value="<?php echo $row['staff_id']; ?>" readonly>

        <?php } else { ?>

            <input type="hidden" name="action" value="add">

            <label>Staff ID</label>
            <input type="text" name="staff_id" maxlength="5" required>

        <?php } ?>

        <label>Name</label>
        <input type="text" name="name"
               value="<?php if (isset($row)) echo $row['name']; ?>"
               required>

        <label>Gender</label>
        <select name="gender">
            <option value="Male" <?php if (isset($row) && $row['gender'] == 'Male') echo "selected"; ?>>Male</option>
            <option value="Female" <?php if (isset($row) && $row['gender'] == 'Female') echo "selected"; ?>>Female</option>
        </select>

        <label>Role</label>
        <select name="role">
            <option value="Admin" <?php if (isset($row) && $row['role'] == 'Admin') echo "selected"; ?>>Admin</option>
            <option value="Collector" <?php if (isset($row) && $row['role'] == 'Collector') echo "selected"; ?>>Collector</option>
            <option value="Coordinator" <?php if (isset($row) && $row['role'] == 'Coordinator') echo "selected"; ?>>Coordinator</option>
        </select>

        <label>Password</label>
        <input type="password" name="password"
               <?php if (!isset($row)) echo "required"; ?>
               placeholder="<?php if (isset($row)) echo 'Leave blank to keep password'; ?>">

        <label>Status</label>
        <select name="is_active">
            <option value="1" <?php if (isset($row) && $row['is_active'] == 1) echo "selected"; ?>>Active</option>
            <option value="0" <?php if (isset($row) && $row['is_active'] == 0) echo "selected"; ?>>Inactive</option>
        </select>

        <button type="submit">Save Staff</button>
        <a href="staff_manage.php" class="btn">Cancel</a>

    </form>

<?php } else { ?>

    <h1>Staff Management</h1>
    <p>Manage staff accounts and information.</p>

    <a href="staff_manage.php?add=1" class="btn">+ Add Staff</a>

    <table class="staff-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT * FROM staff";
        $result = mysqli_query($con, $sql);

        while ($staff = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $staff['staff_id']; ?></td>
            <td><?php echo $staff['name']; ?></td>
            <td><?php echo $staff['gender']; ?></td>
            <td><?php echo $staff['role']; ?></td>
            <td>
                <?php
                if ($staff['is_active'] == 1) {
                    echo "Active";
                } else {
                    echo "Inactive";
                }
                ?>
            </td>
            <td>
                <div class="staff-actions">

                    <a class="btn" href="staff_manage.php?edit=<?php echo $staff['staff_id']; ?>">Edit</a>

                    <form action="staff_functions.php" method="POST"
                          onsubmit="return confirmDelete();">

                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="staff_id" value="<?php echo $staff['staff_id']; ?>">

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
