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
        </div>
        
        <div class="card">
            <h2> Non-recyclables </h2>
        </div>

        <div class="double-row card">
            <h2> Unassigned Action </h2>
        </div>

        <div class="card">
            <table>
                <tr>
                    <td> Uncompleted Dropoffs : </td>
                    <td> num </td>
                </tr>
            </table>
        </div>

        <div class="card">
            <h2> Dropoffs with Uncompleted Action </h2>
        </div>
    </div>
</body>
</html>