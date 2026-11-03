<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Recyclables </title>
    <link rel="stylesheet" href="styles.css">

    <style>
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
        </div>

        <div class="double-column card">
            <h2> Recyclables </h2>
        </div>

        <div class="double-row card">
            <h2> Unassigned Dropoffs </h2>
        </div>

        <div class="card">
            <h2> Uncompleted </h2>
        </div>

        <div class="card">
            <h2> Not Sent </h2>
        </div>

        <div class="card">
            <h2> Dropoffs with Uncompleted Action </h2>
        </div>

        <div class="card">
            <h2> Unsent Dropoffs </h2>
        </div>
    </div>
</body>
</html>