<?php
    include "../dbconn.php";
    include "checkaccess.php";

    if (isset($_POST["btnAssign"])) {
        $id = $_POST["id"];
        $action = $_POST["action"];

        $update = mysqli_query($conn, "
            UPDATE dropoff_recyclable
            SET
                action = '$action'
            WHERE dropoff_id = '$id';
        ");

        if ($update) {
            echo "<script> alert('Action was successfully assigned!'); window.location.href = 'RC_recyclables.php';</script>";
        } else {
            echo "<script> alert('Fail to assign action.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Assign Action to Recyclable</title>
    <link rel="stylesheet" href="styles.css">
    
    <style>
        #content {
            align-items : center;
            justify-content : center;
            padding : 3rem;
        }

        a {
            margin : auto;
        }

        .card {
            margin : 3rem;
            width : fit-content;
        }

        #assignActionForm input[type=text]{
            height : 2rem;
            width : fit-content;
        }

        table td, th {
            padding : 0.5rem;
        }

        table th {
            text-align : right;
        }
    </style>
</head>
<body>
    <div id="content">
        <a href="RC_recyclables.php"><div class="back-button"> Back </div> </a>

        <?php
            $id = $_GET["dropoff_id"];

            $checkdropoff_result = mysqli_query($conn, "SELECT * FROM dropoff_recyclable WHERE dropoff_id = '$id';");
            $checkassign_result = mysqli_query($conn, "SELECT dropoff_id from dropoff_recyclable WHERE dropoff_id = '$id' AND action != 'unassigned';");

            if (mysqli_num_rows($checkassign_result) == 1) { 
                echo "<script> alert('The dropoff already has an action assigned.'); window.location.href = 'RC_recyclables.php'; </script>";
            } elseif (mysqli_num_rows($checkdropoff_result) == 0) { 
                echo "<script> alert('The dropoff you are trying to access does not exist or is a non-recyclable.'); window.location.href = 'RC_recyclables.php'; </script>";
            } else {
                $dropoffinfo_result = mysqli_query($conn, "
                    SELECT dc.dropoff_id, item, actual_quantity FROM dropoff_check dc
                    INNER JOIN dropoff ON dc.dropoff_id = dropoff.dropoff_id
                    WHERE dc.dropoff_id = '$id';
                ");
                $dropoffinfo = mysqli_fetch_assoc($dropoffinfo_result);
        ?>      
                <div class="card">
                    <form id="assignActionForm" method="post">
                        <table>
                            <tr>
                                <th> Dropoff ID </th>
                                <td> <input type="text" name="id" readonly value="<?php echo $dropoffinfo['dropoff_id']; ?>"> </td>
                            </tr>

                            <tr>
                                <th> Item </th>
                                <td> <input type="text" name="item" readonly value="<?php echo $dropoffinfo['item']; ?>"> </td>
                            </tr>

                            <tr>
                                <th> Quantity </th>
                                <td> <input type="number" name="quantity" readonly value="<?php echo $dropoffinfo['actual_quantity']; ?>"> </td>
                            </tr>

                            <tr>
                                <th> Action </th>
                                <td>
                                    <input type="radio" name="action" value="recycle" required> Recycle
                                    <input type="radio" name="action" value="upcycle"> Upcycle
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <br><br>
                                    <input class="button" name="btnAssign" type="submit" value="Assign">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

        <?php
            }
        ?>
    </div>
</body>
</html>

<?php
    mysqli_close($conn);
?>