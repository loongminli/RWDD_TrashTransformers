<?php
    include "../dbconn.php";
    include "checkaccess.php";

    if (isset($_POST["btnAssign"])) {
        $id = $_POST["id"];
        $cid = $_POST["centre_id"];

        $insert = mysqli_query($conn, "INSERT INTO dropoff_recyclingcentre VALUES ('$id', '$cid' , 0);");

        if ($insert) {
            echo "<script> alert('Recyclable was succesfully assigned with a centre!'); window.location.href = 'RC_recyclables.php';</script>";
        } else {
            echo "<script> alert('Fail to assign centre.'); window.location.href = 'RC_recyclables.php';</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Assign Recycling Centre </title>
    <link rel = "stylesheet" href="styles.css">

    <style>
        #content {
            display : flex;
            flex-direction : column;
            align-items : center;
            justify-content : center;
            padding : 3rem;
        }
        
        .card {
            margin : 3rem;
            width : fit-content;
        }

        #assignCentreForm input[type=text]{
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
        <a href="RC_recyclables.php"> <div class="back-button"> Back </div> </a>

        <?php
            $id = $_GET["dropoff_id"];

            $checkdropoff_result = mysqli_query($conn, "SELECT * FROM dropoff_recyclable WHERE dropoff_id = '$id';");
            $checkassign_result = mysqli_query($conn, "SELECT * FROM dropoff_recyclingcentre WHERE dropoff_id='$id';");

            if (mysqli_num_rows($checkassign_result) == 1) {
                echo "<script> alert('The recyclable already has an centre assigned.'); window.location.href = 'RC_recyclables.php'; </script>";
            } else if (mysqli_num_rows($checkdropoff_result) == 0) {
                echo "<script> alert('The recyclable does not exist.'); window.location.href = 'RC_recyclables.php'; </script>";
            } else {
                $dropoffinfo_result = mysqli_query($conn, "SELECT dropoff_id, material_type FROM dropoff_recyclable WHERE dropoff_id = '$id';");
                $dropoffinfo = mysqli_fetch_assoc($dropoffinfo_result);
        ?>      
                <div class="card">
                    <form id="assignCentreForm" method="post">
                        <table>
                            <tr>
                                <th> Dropoff ID </th>
                                <td> <input type="text" name="id" readonly value="<?php echo $dropoffinfo["dropoff_id"]; ?>"> </td>
                            </tr>

                            <tr>
                                <th> Material Type </th>
                                <td> <input type="text" name="material" readonly value="<?php echo $dropoffinfo["material_type"]; ?>"> </td>
                            </tr>

                            <tr>
                                <th> Send to </th>
                                <td> 
                                    <select id="centre" name="centre_id" required>
                                        <option value="" style="display:none"> Select Recycling Centre </option>
                                        <?php
                                            $material = $dropoffinfo["material_type"];
                                            $availablecentres_result = mysqli_query($conn, "SELECT * FROM recyclingcentre WHERE accepted_material_type in ('all', '$material');");

                                            while ($availablecentres = mysqli_fetch_assoc($availablecentres_result)) {
                                                $cid = $availablecentres["centre_id"];
                                                $name = $availablecentres["name"];
                                                $label = $cid . " - " . $name;
                                                echo "<option value='$cid'> $label </option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <br> <br>
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