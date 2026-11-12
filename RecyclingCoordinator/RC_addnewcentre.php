<?php
    include "../dbconn.php";
    include "checkaccess.php";

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

        #addForm input[type=text]{
            height : 2rem;
            width : 40rem;
        }

        #addForm textarea {
            height : 5rem;
            width : 40rem;
        }

        table td, th {
            padding : 0.5rem;
        }

        table th {
            text-align : right;
        }

        @media (max-width : 786px) {
            #content {
                padding : 0;
                padding-top : 3rem;
            }

            .card {
                margin : 1rem;
            }

            .form input[type=text]{
                height : 5rem;
                width : 10rem;
            }

            .form textarea {
                height : 10rem;
                width : 10rem;
            }
        }
    </style>

    <script>
        function resetFields() {
            document.getElementById("errorName").textContent = "";
            document.getElementById("errorAddress").textContent = "";
            document.getElementById("errorMaterial").textContent = "";
        }
    </script>
</head>
<body>
    <div id="content">
        <a href="RC_recyclingcentre.php"> <div class = "back-button"> Back </div> </a>

        <div class="card">
            <form id="addForm" method="post">
                <table>
                    <tr>
                        <th> Centre Name </th>
                        <td>
                            <input type="text" name="name" id="name" required> <br>
                            <span id="errorName" class="error"></span>
                        </td>
                    </tr>

                    <tr>
                        <th> Centre Address </th>
                        <td>
                            <textarea type="text" name="address" id="address" required></textarea> <br>
                            <span id="errorAddress" class="error"></span>
                        </td>
                    </tr>

                    <tr>
                        <th> Material Type Accepted </th>
                        <td>
                            <input type="radio" name="material_type" id="material_type" value="all" required> All <br>
                            <input type="radio" name="material_type" id="material_type" value="paper"> Paper <br>
                            <input type="radio" name="material_type" id="material_type" value="plastic"> Plastic <br>
                            <input type="radio" name="material_type" id="material_type" value="glass"> Glass <br>
                            <input type="radio" name="material_type" id="material_type" value="aluminium"> Aluminium <br>
                            <span id="errorMaterial" class="error"></span>
                        </td>
                    </tr>

                    <tr>
                        <td> </td>
                        <td>   
                            <br> <br>
                            <input class="button" type="reset" value="Reset" onclick="resetFields()">
                            <button class="button" type="button" id="btnAdd"> Add </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    
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

<?php
    mysqli_close($conn);
?>