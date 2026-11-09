<?php
    include "dbconn.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $material = $_POST["material_type"];

        $insert = mysqli_query($conn,"
            INSERT INTO recyclingcentre (name, address, accepted_material_type)
            VALUES ('$name', '$address', '$material');
        ");
        
        if ($insert) {
            echo "<script> alert('New centre has successfully been recorded.'); </script>";
        } else {
            echo "<script> alert('Record failed to be recorded in database.'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add New Centre </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="RC_recyclingcentre.php"> Back </a>

    <script>

    </script>
    
    <form id="addForm" method="post">
        <table>
            <tr>
                <td> Centre Name : </td>
                <td>
                    <input type="text" name="name" id="name" required> <br>
                    <span id="errorName"></span>
                </td>
            </tr>

            <tr>
                <td> Centre Address : </td>
                <td>
                    <textarea type="text" name="address" id="address" required></textarea> <br>
                    <span id="errorAddress"></span>
                </td>
            </tr>

            <tr>
                <td> Material Type Accepted : </td>
                <td>
                    <input type="radio" name="material_type" id="material_type" value="all" required> All <br>
                    <input type="radio" name="material_type" id="material_type" value="paper"> Paper <br>
                    <input type="radio" name="material_type" id="material_type" value="plastic"> Plastic <br>
                    <input type="radio" name="material_type" id="material_type" value="glass"> Glass <br>
                    <input type="radio" name="material_type" id="material_type" value="aluminium"> Aluminium <br>
                    <span id="errorMaterial"></span>
                </td>
            </tr>
            
            <tr>
                <td>
                    <input type="reset" value="Reset">
                    <button type="button" id="btnAdd"> Add </div>
                </td>
            </tr>
        </table>
    </form>
    
    <script>
        document.getElementById("btnAdd").addEventListener("click", function () {
            let isValid = true;
            let name = document.getElementById("name").value;
            if (name === "") {document.getElementById("errorName").textContent = "Please enter a centre name."; isValid = false;}
            let address = document.getElementById("address").value;
            if (address === "") {document.getElementById("errorAddress").textContent = "Please enter an address."; isValid = false;}
            let material;
            try {material = document.querySelector("input[id='material_type']:checked").value;}
            catch {document.getElementById("errorMaterial").textContent = "Please select something."; isValid = false;}
            
            if (isValid) {
                let isConfirmed = confirm(`
Confirm the details below.
Centre Name : ${name}
Centre Address : ${address}
Material Type Accepted : ${material}
            `);

                if (isConfirmed) {
                    document.getElementById("addForm").submit();
                }
            }
        })
    </script>
</body>
</html>