<?php
    include "dbconn.php";
?>

<script>
    function markComplete(button) {
        let id = button.value;
        let isConfirmed = confirm(`
Mark Dropoff ${id} as complete ?
        `);

        if (isConfirmed) {
            window.location.href = `markcomplete_r.php?dropoff_id=${id}`;
        }
    }

    function markSent(button) {
        let id = button.value;
        let isConfirmed = confirm(`
Mark Dropoff ${id} as sent ?
        `);

        if (isConfirmed) {
            window.location.href = `marksent_r.php?dropoff_id=${id}`;
        }
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Recyclables </title>
    <link rel="stylesheet" href="styles.css">

    <style>
        table {
            margin : auto;
        }

        #content {
            grid-template-columns : 40% 20% 40% ; 
            grid-template-rows : repeat(2);
        }
    </style>
</head>
<body>
    <?php include "header.php" ?>

    <div id="content">
        <div class="card">
            <h2> Total Unassigned Dropoffs </h2>
            <?php
                $unassigned_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE action = 'unassigned';");
                $unassigned = mysqli_fetch_row($unassigned_result)[0];

                echo "<p class='placeholder'> $unassigned </p>";
            ?>
        </div>

        <div class="card">
            <h2> Unassigned Dropoffs </h2>
            <?php
                $unassigned_result = mysqli_query($conn, "
                    SELECT r.dropoff_id, item, actual_quantity FROM dropoff_recyclable r INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_check on r.dropoff_id = dropoff_check.dropoff_id
                    WHERE action = 'unassigned';
                ");

                echo "<table>";
                echo "<tr><th>ID</th> <th>Item</th> <th>Quantity</th> <th>Modify</th></tr>";
                while ($unassigned = mysqli_fetch_assoc($unassigned_result)) {
                    echo "<tr>";
                    echo "<td>" . $unassigned["dropoff_id"] . "</td>";
                    echo "<td>" . $unassigned["item"] . "</td>";
                    echo "<td>" . $unassigned["actual_quantity"] . "</td>";
            ?>
                    <td> <button> <a href="RC_recyclableaction.php?dropoff_id=<?php echo $unassigned["dropoff_id"]; ?>"> Assign </a> </button> </td>
            <?php
                    echo "</tr>";
                }
                echo "</table>";
            ?>
        </div>

        <div class="card">
            <h2> Uncompleted </h2>
            <?php
                $uncompleted_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE status = 'uncompleted' AND action != 'unassigned';");
                $uncompleted = mysqli_fetch_row($uncompleted_result)[0];

                echo "<p class='placeholder'> $uncompleted </p>";
            ?>
        </div>

        <div class="card">
            <h2> Dropoffs with Uncompleted Action </h2>
            <?php
                $uncompleted_result = mysqli_query($conn, "
                    SELECT r.dropoff_id, item, action FROM dropoff_recyclable r
                    INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_check on r.dropoff_id = dropoff_check.dropoff_id
                    WHERE status = 'uncompleted' AND action != 'unassigned';
                ");

                echo "<table>";
                echo "<tr><th>ID</th> <th>Item</th> <th>Action</th> <th>Modify</th></tr>";
                while ($uncompleted = mysqli_fetch_assoc($uncompleted_result)) {
                    echo "<tr>";
                    echo "<td>" . $uncompleted["dropoff_id"] . "</td>";
                    echo "<td>" . $uncompleted["item"] . "</td>";
                    echo "<td>" . $uncompleted["action"] . "</td>";
            ?>
                    <td> <button type="button" value="<?php echo $uncompleted['dropoff_id']; ?>" onclick="markComplete(this)"> Mark Complete </button> </td>
            <?php
                    echo "</tr>";
                }
                echo "</table>";
            ?>
        </div>

        <div class="card">
            <h2> Not Sent </h2>
            <?php
                $unsent_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclingcentre WHERE is_sent = 0;");
                $unsent = mysqli_fetch_row($unsent_result)[0];

                echo "<p class='placeholder'> $unsent </p>";
            ?>
        </div>

        <div class="card">
            <h2> Unsent Dropoffs </h2>
            <?php
                $unsent_result = mysqli_query($conn, "
                    SELECT rc.dropoff_id, item, material_type FROM dropoff_recyclingcentre rc
                    INNER JOIN dropoff ON rc.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_recyclable on rc.dropoff_id = dropoff_recyclable.dropoff_id
                    WHERE is_sent = 0;
                ");

                echo "<table>";
                echo "<tr><th>ID</th> <th>Item</th> <th>Material Type</th> <th>Modify</th></tr>";
                while ($unsent = mysqli_fetch_assoc($unsent_result)) {
                    echo "<tr>";
                    echo "<td>" . $unsent["dropoff_id"] . "</td>";
                    echo "<td>" . $unsent["item"] . "</td>";
                    echo "<td>" . $unsent["material_type"] . "</td>";
            ?>
                    <td> <button type="button" value="<?php echo $unsent['dropoff_id']; ?>" onclick="markSent(this)"> Mark Sent </button> </td>
            <?php
                }
                echo "</table>";
            ?>
        </div>

        <div class="double-column card">
            <h2> Recyclables </h2>
            <?php
                $recyclables_result = mysqli_query($conn, "SELECT r.*, item FROM dropoff_recyclable r INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id ORDER BY dropoff_id DESC;");

                echo "<table>";
                echo "<tr><th>ID</th> <th>Item</th> <th>Material Type</th> <th>Action</th> <th>Status</th></tr>";
                while ($recyclables = mysqli_fetch_assoc($recyclables_result)) {
                    echo "<tr>";
                    echo "<td>" . $recyclables["dropoff_id"] . "</td>";
                    echo "<td>" . $recyclables["item"] . "</td>";
                    echo "<td>" . $recyclables["material_type"] . "</td>";
                    echo "<td>" . $recyclables["action"] . "</td>";
                    echo "<td>" . $recyclables["status"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            ?>
        </div>
    </div>
</body>
</html>