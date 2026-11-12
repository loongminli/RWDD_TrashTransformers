<?php
    include "../dbconn.php";
    include "checkaccess.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $name = trim($_POST["name"]);
        $address = trim($_POST["address"]);
        $material = $_POST["material_type"];

        $update = mysqli_query($conn, "
            UPDATE recyclingcentre
            SET
                name = '$name',
                address = '$address',
                accepted_material_type = '$material'
            WHERE centre_id = '$id';
        ");

        if ($update) {
            echo "<script> alert('Update was successful!'); </script>";
        } else {
            echo "<script> alert('Update failed.'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit Centre Details </title>
    <link rel="stylesheet" href="styles.css">

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

        #updateForm input[type=text]{
            height : 2rem;
            width : 40rem;
        }

        #updateForm textarea {
            height : 5rem;
            width : 40rem;
        }

        table td, th {
            padding : 0.5rem;
        }

        table th {
            text-align : right;
        }

        @media (max-width : 768px) {
            #content {
                padding : 0;
                padding-top : 3rem;
            }

            .card {
                margin : 1rem;
                width : 80%;
            }

            #updateForm input[type=text]{
                height : 5rem;
                width : 10rem;
            }

            #updateForm textarea {
                height : 10rem;
                width : 10rem;
            }

        }
    </style>
</head>
<body>
    <div id="content">
        <a href="RC_recyclingcentre.php"> <div class="back-button"> Back </div> </a>

        <?php
            $id = $_GET["centre_id"];
            $centreinfo_result = mysqli_query($conn, "SELECT * FROM recyclingcentre WHERE centre_id = '$id';");

            if (mysqli_num_rows($centreinfo_result) == 0) {
            echo "
                <script>
                    alert('The centre you are trying to update does not exist.');
                    window.location.href = 'RC_recyclingcentre.php';
                </script>
            ";
            } else {
                $centreinfo = mysqli_fetch_assoc($centreinfo_result);
        ?>      
                <div class="card">
                    <form id="updateForm" method="post">
                        <table>
                            <tr>
                                <th> Centre ID : </th>
                                <td> <input type="text" name="id" id="id" value="<?php echo $centreinfo['centre_id']; ?>" readonly> </td>
                            </tr>

                            <tr>
                                <th> Centre Name : </th>
                                <td>
                                    <input type="text" name="name" id="name" value="<?php echo $centreinfo['name']; ?>" required> <br>
                                    <span id="errorName"></span>
                                </td>
                            </tr>

                            <tr>
                                <th> Centre Address : </th>
                                <td>
                                    <textarea type="text" name="address" id="address" required><?php echo $centreinfo['address']; ?></textarea> <br>
                                    <span id="errorAddress"></span>
                                </td>
                            </tr>

                            <tr>
                                <th> Material Type Accepted : </th>
                                <td>
                                    <input type="radio" name="material_type" id="material_type" value="all" <?php if($centreinfo["accepted_material_type"] == "all") { echo "checked"; } ?> required> All <br>
                                    <input type="radio" name="material_type" id="material_type" value="paper" <?php if($centreinfo["accepted_material_type"] == "paper") { echo "checked"; } ?>> Paper <br>
                                    <input type="radio" name="material_type" id="material_type" value="plastic" <?php if($centreinfo["accepted_material_type"] == "plastic") { echo "checked"; } ?>> Plastic <br>
                                    <input type="radio" name="material_type" id="material_type" value="glass" <?php if($centreinfo["accepted_material_type"] == "glass") { echo "checked"; } ?>> Glass <br>
                                    <input type="radio" name="material_type" id="material_type" value="aluminium" <?php if($centreinfo["accepted_material_type"] == "aluminium") { echo "checked"; } ?>> Aluminium <br>
                                    <span id="errorMaterial"></span>
                                </td>
                            </tr>
                    
                            <tr>
                                <td> </td>
                                <td>
                                    <br> <br>
                                    <button type="button" class="button" id="btnUpdate"> Update </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
        <?php
            }
        ?>
    </div>

    <script>
        document.getElementById("btnUpdate").addEventListener("click", function () {
            let isValid = true;
            let id = document.getElementById("id").value;
            let name = document.getElementById("name").value;
            if (name === "") {document.getElementById("errorName").textContent = "Please enter a centre name."; isValid = false;}
            let address = document.getElementById("address").value;
            if (address === "") {document.getElementById("errorAddress").textContent = "Please enter an address."; isValid = false;}  
            let material;
            try {material = document.querySelector("input[id='material_type']:checked").value;}
            catch {document.getElementById("errorMaterial").textContent = "Please select something."; isValid = false;}
            
            if (isValid) {
                let isConfirmed = confirm(`
Confirm the updated details.
Centre ID : ${id}
Centre Name : ${name}
Centre Address : ${address}
Material Type Accepted : ${material}
                `);

                if (isConfirmed) {
                    document.getElementById("updateForm").submit();
                }
            }
        })
    </script>
</body>
</html>

<?php
    mysqli_close($conn);
?>