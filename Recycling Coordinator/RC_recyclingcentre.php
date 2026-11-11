<?php
    include "../dbconn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Recycling Centres </title>
    <link rel="stylesheet" href="styles.css">

    <style>
        #content {
            align-items : center;
            grid-template-rows : repeat(2); /* two rows */
        }

        table {
            margin : auto;
        }

        .add-button {
            border : 2px solid black;
            border-radius : 40px;
            padding : 0.5rem;
            width : fit-content;
            margin : auto;
            background-color : #C8A96B;
            font-size : 120%;
            color : black;
        }
    </style>
</head>
<body>
    <?php include "header.php" ?>

    <div id="content">
        <div class="card" style="border:none; background-color:#F7F4ED; width:fit-content; margin:auto;">
            <h4> New Centre ? </h4>
            <a href="RC_addnewcentre.php"> <div class="add-button"> Add Record </div> </a>
        </div>
        
        <div class="card">
            <h2> List of Recycling Centres </h2>
            <?php
                echo "<table class='info-table'>";
                echo "<tr><th>ID</th> <th> Name </th> <th>Address</th> <th>Material Accepted</th> <th>Modify</th></tr>";
                
                $centres_result = mysqli_query($conn, "SELECT * FROM recyclingcentre ORDER BY centre_id DESC;");
                
                while ($centres = mysqli_fetch_assoc($centres_result)) {
                    echo "<tr>";
                    echo "<td>" . $centres["centre_id"] . "</td>";
                    echo "<td>" . $centres["name"] . "</td>";
                    echo "<td>" . $centres["address"] . "</td>";
                    echo "<td>" . $centres["accepted_material_type"] . "</td>";
            ?>
                    <td> <button class="assign-button" type="button"> <a href="RC_editcentre.php?centre_id=<?php echo $centres['centre_id']; ?>"> Update </a> </button> </td>
            <?php
                    echo "</tr>";
                }

                echo "</table>";
            ?>
        </div>

        <div class="card">
            <h2> Recyclables and Assigned Recycling Centre </h2>
            <?php
                echo "<table class ='info-table'>";
                echo "<tr><th>Dropoff ID</th> <th>Centre ID</th> <th>Status</th></tr>";

                $dropoffcentre_result = mysqli_query($conn, "SELECT * FROM dropoff_recyclingcentre");

                while ($dropoffcentre = mysqli_fetch_assoc($dropoffcentre_result)) {
                    echo "<tr>";
                    echo "<td>" . $dropoffcentre["dropoff_id"] . "</td>";
                    echo "<td>" . $dropoffcentre["centre_id"] . "</td>";
                    echo "<td>" . (($dropoffcentre["is_sent"] === "0") ? "Not sent" : "Sent") . "</td>";
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