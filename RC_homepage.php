<?php
    include "dbconn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard </title>
    <link rel="stylesheet" href="styles.css">

    <style>
        table { 
            margin : auto;
        }

        #unassigned {
            display : grid;
            grid-template-columns : 40% 60%;
        }

        .unassigned-box {
            display : flex;
            margin : 1rem auto;
            height : 3rem;
            width : 3rem;
            border : 1px solid black;
            border-radius : 5px;
            align-items : center;
            justify-content : center;
        }

        .material {
            text-align : right;
        }

        #content {
            grid-template-columns : repeat(2, 1fr); /* two columns, equal in size*/
            grid-template-rows : repeat(2); /* two rows */
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

    <section id="content">
        <div class="double-column card">
            <h2> Checked Dropoffs with Needed Action </h2>
            <div id="unassigned">
                <div class="unassigned-box">
                    <?php
                        $unassigned_r_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE action = 'unassigned';");
                        $unassigned_nr_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_nonrecyclable WHERE action = 'unassigned';");
                        
                        $unassigned_r = mysqli_fetch_row($unassigned_r_result);
                        $unassigned_nr = mysqli_fetch_row($unassigned_nr_result);

                        $total_unassigned = $unassigned_r[0] + $unassigned_nr[0]; /* using row cuz theres just one result */
                        echo "<p> $total_unassigned </p>";
                    ?>
                </div>

                <div>
                    <h4> Unassigned Dropoffs </h4>
                    <?php
                        $unassigned_r_result = mysqli_query($conn, 
                            "SELECT r.dropoff_id, item, actual_quantity FROM dropoff_recyclable r
                            INNER JOIN dropoff on r.dropoff_id = dropoff.dropoff_id
                            INNER JOIN dropoff_check on r.dropoff_id = dropoff_check.dropoff_id
                            WHERE action = 'unassigned';"
                        );
                        $unassigned_nr_result = mysqli_query($conn, 
                            "SELECT nr.dropoff_id, item, actual_quantity FROM dropoff_nonrecyclable nr
                            INNER JOIN dropoff on nr.dropoff_id = dropoff.dropoff_id
                            INNER JOIN dropoff_check on nr.dropoff_id = dropoff_check.dropoff_id
                            WHERE action = 'unassigned';"
                        );

                        echo "<table>";
                        echo "<tr> <th>ID</th> <th>Item</th> <th>Quantity</th> </tr>";
                        
                        while ($unassigned_r = mysqli_fetch_assoc($unassigned_r_result)) {
                            echo "<tr>";
                            echo "<td>" . $unassigned_r['dropoff_id'] . "</td>";
                            echo "<td>" . $unassigned_r['item'] . "</td>";
                            echo "<td>" . $unassigned_r['actual_quantity'] . "</td>";
                            echo "</tr>";
                        }

                        while ($unassigned_nr = mysqli_fetch_assoc($unassigned_nr_result)) {
                            echo "<tr>";
                            echo "<td>" . $unassigned_nr['dropoff_id'] . "</td>";
                            echo "<td>" . $unassigned_nr['item'] . "</td>";
                            echo "<td>" . $unassigned_nr['actual_quantity'] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</table>";
                    ?>
                </div>
            </div>
        </div>

        <div class="card">
            <h2> Total Batches of Dropoffs Collected </h2>
            <table>
                <tr>
                    <td style="width:40%"> Month : </td>
                    <td style="width:60%"> 
                        <form method="get" id="monthForm">
                            <select name="dropdownMonth" id="dropdownMonth">
                                <option value="" style="display:none"> Select Month </option>
                                <option value="1"> January </option>
                                <option value="2"> February </option>
                                <option value="3"> March </option>
                                <option value="4"> April </option>
                                <option value="5"> May </option>
                                <option value="6"> June </option>
                                <option value="7"> July </option>
                                <option value="8"> August </option>
                                <option value="9"> September </option>
                                <option value="10"> October </option>
                                <option value="11"> November </option>
                                <option value="12"> December </option>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
            <span id="total_batches" class="placeholder">  </span>

            <!-- i have never made a smarter code than below -->
            <script>
                document.getElementById("dropdownMonth").addEventListener("change", function () {
                    document.getElementById("monthForm").submit();
                });
            </script>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $month = $_GET["dropdownMonth"] ?? 1;
                    
                    $batches_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff WHERE year(dropoff_datetime) = year(CURRENT_DATE) AND month(dropoff_datetime) = '$month';");
                    $batches = mysqli_fetch_row($batches_result)[0];

                    echo "<script> document.getElementById('total_batches').textContent = $batches; </script>";
                }
            ?>
        </div>

        <div class="card">
            <h2> Dropoffs by Material </h2>
            <?php
                $paper_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE material_type = 'paper';");
                $plastic_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE material_type = 'plastic';");
                $glass_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE material_type = 'glass';");
                $aluminium_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE material_type = 'aluminium';");
                $others_result = mysqli_query($conn, "SELECT COUNT(*) FROM dropoff_recyclable WHERE material_type not in ('paper', 'plastic', 'glass', 'aluminium');");

                $paper = mysqli_fetch_row($paper_result)[0];
                $plastic = mysqli_fetch_row($plastic_result)[0];
                $glass = mysqli_fetch_row($glass_result)[0];
                $aluminium = mysqli_fetch_row($aluminium_result)[0];
                $others = mysqli_fetch_row($others_result)[0];
            ?>

            <table>
                <tr>
                    <th class="material"> Paper : </th>
                    <td class="placeholder"> <?php echo $paper ?> </td>
                </tr>
                <tr>
                    <th class="material"> Plastic : </th>
                    <td class="placeholder"> <?php echo $plastic ?> </td>
                </tr>
                <tr>
                    <th class="material"> Glass : </th>
                    <td class="placeholder"> <?php echo $glass ?> </td>
                </tr>
                <tr>
                    <th class="material"> Aluminium : </th>
                    <td class="placeholder"> <?php echo $aluminium ?> </td>
                </tr>
                <tr>
                    <th class="material"> Others : </th>
                    <td class="placeholder"> <?php echo $others ?> </td>
                </tr>
            </table>
        </div>
    </section>
</body>
</html>