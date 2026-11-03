<?php
    include "dbconn.php";
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
            grid-template-columns : repeat(2, 1fr); /* two columns, equal in size */
            grid-template-rows : repeat(2); /* two rows */
        }

        table {
            margin : auto;
        }

        .button {
            border : 1px solid black;
            border-radius : 40px;
            padding : 0.5rem;
            width : fit-content;
            margin : auto;
        }
    </style>
</head>
<body>
    <?php include "header.php" ?>

    <div id="content">
        <div class="double-column card">
            <h2> List of Recycling Centres </h2>
            <?php
                echo "<table>";
                echo "
                    <tr>
                        <th> ID </th>
                        <th> Name </th>
                        <th> Address  </th>
                        <th> Material Accepted </th>
                    </tr>
                ";
                
                $centres_result = mysqli_query($conn, "SELECT * FROM recyclingcentre;");
                
                while ($centres = mysqli_fetch_assoc($centres_result)) {
                    echo "<tr>";
                    echo "<td>" . $centres["centre_id"] . "</td>";
                    echo "<td>" . $centres["name"] . "</td>";
                    echo "<td>" . $centres["address"] . "</td>";
                    echo "<td>" . $centres["accepted_material_type"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            ?>
        </div>

        <div class="card" style="border : none;">
            <h4> New Centre ? </h4>
            <a href="RC_addnewcentre.php"> <div class="button"> Add Record </div> </a>
        </div>

        <div class="card" style="border : none;">
            <h4> Centre Details Changed ? </h4>
            <div class="button"> Update Record </div>
        </div>
    </div>
</body>
</html>