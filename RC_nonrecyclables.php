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
            window.location.href = `markcomplete_nr.php?dropoff_id=${id}`;
        }
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Non-recyclables </title>
    <link rel="stylesheet" href="styles.css">

    <style>
        table {
            margin : auto;
        }

        #content {
            grid-template-columns : repeat(2,1fr) ;
            grid-template-rows : repeat(3,1fr);
        }
    </style>
</head>
<body>
    <?php include "header.php" ?>

    <div id="content">
        <div class="card">
            <h2> Total Unassigned Dropoffs </h2>
            <?php
                $unassigned_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_nonrecyclable WHERE action = 'unassigned';");
                $unassigned = mysqli_fetch_row($unassigned_result)[0];

                echo "<p class='placeholder'> $unassigned </p>";
            ?>
        </div>

        <div class="card">
            <?php
                $uncompleted_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_nonrecyclable WHERE status = 'uncompleted' AND action != 'unassigned';");
                $uncompleted = mysqli_fetch_row($uncompleted_result)[0];
            ?>

                <h2> Uncompleted Dropoffs : </h2>
                <p class="placeholder"> <?php echo $uncompleted; ?> </p>
        </div>

        <div class="card">
            <h2> Unassigned Action </h2>
            <?php
                $unassigned_result = mysqli_query($conn, "
                    SELECT nr.dropoff_id, item, actual_quantity FROM dropoff_nonrecyclable nr
                    INNER JOIN dropoff on nr.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_check on nr.dropoff_id = dropoff_check.dropoff_id
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
                    <td><button><a href="RC_nonrecyclableaction.php?dropoff_id=<?php echo $unassigned['dropoff_id'];?>"> Assign </a></button></td>
            <?php
                    echo "</tr>";
                }
                echo "</table>";
            ?>
        </div>

        <div class="card">
            <h2> Dropoffs with Uncompleted Action </h2>
            <?php
                $uncompleted_result = mysqli_query($conn, "
                    SELECT nr.dropoff_id, item, action FROM dropoff_nonrecyclable nr
                    INNER JOIN dropoff on nr.dropoff_id = dropoff.dropoff_id
                    INNER JOIN dropoff_check on nr.dropoff_id = dropoff_check.dropoff_id
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
        
        <div class="double-column card">
            <h2> Non-recyclables </h2>
            <?php
                $nonrecyclable_result = mysqli_query($conn,"
                    SELECT nr.*, item FROM dropoff_nonrecyclable nr
                    INNER JOIN dropoff ON nr.dropoff_id = dropoff.dropoff_id
                    ORDER BY dropoff_id DESC;
                ");

                echo "<table>";
                echo "<tr><th>ID</th> <th>Item</th> <th>Action</th> <th>Status</th></tr>";
                while ($nonrecyclable = mysqli_fetch_assoc($nonrecyclable_result)){
                    echo "<tr>";
                    echo "<td>" . $nonrecyclable["dropoff_id"] . "</td>";
                    echo "<td>" . $nonrecyclable["item"] . "</td>";
                    echo "<td>" . $nonrecyclable["action"] . "</td>";
                    echo "<td>" . $nonrecyclable["status"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            ?>
        </div>
    </div>
</body>
</html>