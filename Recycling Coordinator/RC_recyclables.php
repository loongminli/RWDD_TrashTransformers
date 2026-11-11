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
            grid-template-columns : repeat(2, 1fr);
            grid-template-rows : repeat(2);
        }

        #numbers {
            display : grid;
            grid-template-columns : repeat(2,1fr);
        }

        @media (max-width : 768px) {
            #content {
                grid-template-columns : none;
                grid-template-rows : none;
            }

            .double-column {
                grid-column : span 1;
            }
        }
    </style>
</head>
<body>
    <?php include "header.php" ?>

    <div id="content">
        <div id="numbers" class="double-column">
            <div class="number-box card">
                <h2> Total Unassigned Action Dropoffs </h2>
                <?php
                    $unassigned_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE action = 'unassigned';");
                    $unassigned = mysqli_fetch_row($unassigned_result)[0];

                    echo "<div class='number'> $unassigned </div>";
                ?>
            </div>

            <div class="number-box card">
                <h2> Uncompleted </h2>
                <?php
                    $uncompleted_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE status = 'incomplete' AND action NOT in ('unassigned', 'recycle');");
                    $uncompleted = mysqli_fetch_row($uncompleted_result)[0];

                    echo "<div class='number'> $uncompleted </div>";
                ?>
            </div>
        </div>

        <div id="numbers" class="double-column">
            <div class="number-box card">
                <h2> Total without an Assigned Centre </h2>
                <?php
                    $unassignedcentre_result = mysqli_query($conn, "
                        SELECT COUNT(*) FROM dropoff_recyclable r
                        WHERE action='recycle' AND r.dropoff_id NOT in (
                            SELECT dropoff_id FROM dropoff_recyclingcentre
                        )
                    ");
                    $unassignedcentre = mysqli_fetch_row($unassignedcentre_result)[0];

                    echo "<div class='number'> $unassignedcentre </div>";
                ?>
            </div>

            <div class="number-box card">
                <h2> Not Sent </h2>
                <?php
                    $unsent_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclingcentre WHERE is_sent = 0;");
                    $unsent = mysqli_fetch_row($unsent_result)[0];

                    echo "<div class='number'> $unsent </div>";
                ?>
            </div>
        </div>

        <script src="number_color.js"></script>

        <div class="card">
            <h2> Unassigned Action Dropoffs </h2>
            <?php
                $unassigned_result = mysqli_query($conn, "
                    SELECT r.dropoff_id, item, actual_quantity FROM dropoff_recyclable r INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_check on r.dropoff_id = dropoff_check.dropoff_id
                    WHERE action = 'unassigned';
                ");

                if (mysqli_num_rows($unassigned_result) == 0)  {
                    echo "<p class='alert'> All recyclables are assigned an action! </p>";
                } else {
                    echo "<table class = 'info-table'>";
                    echo "<tr><th>ID</th> <th>Item</th> <th>Quantity</th> <th>Modify</th></tr>";
                    while ($unassigned = mysqli_fetch_assoc($unassigned_result)) {
                        echo "<tr>";
                        echo "<td>" . $unassigned["dropoff_id"] . "</td>";
                        echo "<td>" . $unassigned["item"] . "</td>";
                        echo "<td>" . $unassigned["actual_quantity"] . "</td>";
                ?>
                        <td> <button class = "assign-button"> <a href="RC_recyclableaction.php?dropoff_id=<?php echo $unassigned["dropoff_id"]; ?>"> Assign </a> </button> </td>
                <?php
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
        </div>

        <div class="card">
            <h2> Dropoffs with Uncompleted Action </h2>
            <?php
                $uncompleted_result = mysqli_query($conn, "
                    SELECT r.dropoff_id, item, action FROM dropoff_recyclable r
                    INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_check on r.dropoff_id = dropoff_check.dropoff_id
                    WHERE status = 'incomplete' AND action NOT in ('unassigned', 'recycle');
                ");

                if (mysqli_num_rows($uncompleted_result) == 0) {
                    echo "<p class='alert'> All recyclables have successfully been processed! </p>";
                } else {
                    echo "<table class = 'info-table'>";
                    echo "<tr><th>ID</th> <th>Item</th> <th>Action</th> <th>Modify</th></tr>";
                    while ($uncompleted = mysqli_fetch_assoc($uncompleted_result)) {
                        echo "<tr>";
                        echo "<td>" . $uncompleted["dropoff_id"] . "</td>";
                        echo "<td>" . $uncompleted["item"] . "</td>";
                        echo "<td>" . $uncompleted["action"] . "</td>";
                ?>
                        <td> <button class="mark-button" type="button" value="<?php echo $uncompleted['dropoff_id']; ?>" onclick="markComplete(this)"> Mark Complete </button> </td>
                <?php
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
        </div>

        <div class="card">
            <h2> No Assigned Centres </h2>
            <?php
                $unassignedcentre_result = mysqli_query($conn, "
                    SELECT r.dropoff_id, item FROM dropoff_recyclable r
                    INNER JOIN dropoff ON r.dropoff_id = dropoff.dropoff_id
                    WHERE action='recycle' AND r.dropoff_id NOT in (
                        SELECT dropoff_id FROM dropoff_recyclingcentre
                    )
                ");

                if (mysqli_num_rows($unassignedcentre_result) == 0) {
                    echo "<p class='alert'> All to-be-recycled are assigned a centre! </p>";
                } else {
                    echo "<table class = 'info-table'>";
                    echo "<tr><th>ID</th> <th>Item</th> <th>Modify</th></tr>";
                    while ($unassignedcentre = mysqli_fetch_assoc($unassignedcentre_result)) {
                        echo "<tr>";
                        echo "<td>" . $unassignedcentre["dropoff_id"] . "</td>";
                        echo "<td>" . $unassignedcentre["item"] . "</td>";
                ?>
                        <td> <button class = "assign-button"> <a href="RC_recyclableassigncentre.php?dropoff_id=<?php echo $unassignedcentre["dropoff_id"]; ?>"> Assign </a> </button> </td>
                <?php
                        echo "</tr>";
                    }
                    echo "</table>";
                }
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

                if (mysqli_num_rows($unsent_result) == 0) {
                    echo "<p class='alert'> All recycles have been sent to their respective centres! </p>";
                } else {
                    echo "<table class = 'info-table'>";
                    echo "<tr><th>ID</th> <th>Item</th> <th>Material Type</th> <th>Modify</th></tr>";
                    while ($unsent = mysqli_fetch_assoc($unsent_result)) {
                        echo "<tr>";
                        echo "<td>" . $unsent["dropoff_id"] . "</td>";
                        echo "<td>" . $unsent["item"] . "</td>";
                        echo "<td>" . $unsent["material_type"] . "</td>";
                ?>
                        <td> <button class="mark-button" type="button" value="<?php echo $unsent['dropoff_id']; ?>" onclick="markSent(this)"> Mark Sent </button> </td>
                <?php
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
        </div>

        <div class="double-column card">
            <h2> Recyclables </h2>
            <?php
                $recyclables_result = mysqli_query($conn, "SELECT r.*, item FROM dropoff_recyclable r INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id ORDER BY dropoff_id DESC;");

                echo "<table class = 'info-table'>";
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

<?php
    mysqli_close($conn);
?>