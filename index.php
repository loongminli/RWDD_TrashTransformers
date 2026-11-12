<?php include "dbconn.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Trash Tranformers </title>

    <style>
        * {
            font-family :'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            margin : 0;
            padding : 0;
            box-sizing : border-box;
            text-decoration : none;
        }

        header {
            display : inline-flex;
            width : 100%;
            align-items : center;
            padding : 0.5rem;
            background-color : #8FA28A;
        }

        .logo {
            height : 3.5rem;
            width : 3.5rem;
        }

        #profile {
            display : flex;
            flex-direction: row;
            align-items : center;
            gap : 0.5rem;
        }

        .pfp {
            height : 3.5rem;
            width : 3.5rem;
        }

        #menu-options {
            display : flex;
            flex-direction: row;
            align-items : center;
            position : center;
            margin : auto;
        }

        .menu-option {
            height : 2.5rem;
            width : 13rem;
            padding : 0.5rem;
            margin : 1rem;
            display : flex;
            border : 2px solid black;
            border-radius : 30px;
            align-items : center;
            justify-content : center;
            cursor : pointer;
            font-size : 1rem;
            transition : background-color 0.5s ease;
            background-color : #C8A96B;
        }

        .menu-option:hover {
            background-color : #ad925c;
        }

        .menu-option h4 {
            color : black;
            transition : font-size 0.3s ease;
        }

        .menu-option:hover h4 {
            color : #22447a;
            font-size : 105%;
        }

        .big-pic {
            height : 15rem;
        }

        #contents {
            display : flex;
            flex-direction : column;
            align-items : center;
            margin : 1rem;
        }

        .content {
            width : 100%;
            margin : 1rem;
            gap : 1rem;
            display : grid;
            grid-template-columns : 1fr 3fr;
        }

        #login-button {
            padding : 0.4rem;
            color : black;
            background-color : white;
            cursor : pointer;
            border-radius : 10px;
        }

        #logout-button {
            padding : 0.4rem;
            color : darkred;
            background-color : rgb(255, 73, 73);
            cursor : pointer;
            border-radius : 10px;
        }

        #actions {
            position : absolute;
            display : flex;
            flex-direction : column;
            display : none;
            opacity : 0;
            padding : 0.5rem;
            gap : 0.3rem;
            align-items : center;
            justify-content : center;
        }

        #actions.active {
            display : flex;
            opacity : 1;
            top : 80px;
            right : 10px;
            justify-content : center;
            background-color: black;
            border : 2px solid white;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"> 
            <img src="logo.png" style="border-radius:100%; width:100%; height:100%;" alt="logo">
        </div>

        <div id="menu-options">
            <?php
                if (isset($_SESSION["id"])) {
                    switch ($_SESSION["role"]) {
                        case "User" :
                            echo "<a href='.php'> <div class='menu-option'> <h4> User Functions </h4> </div> </a>";
                            break;
                        case "Admin" :
                            echo "<a href='.php'> <div class='menu-option'> <h4> Admin Functions </h4> </div> </a>";
                            break;
                        case "Collector" :
                            echo "<a href='.php'> <div class='menu-option'> <h4> Collector Functions </h4> </div> </a>";
                            break;
                        case "Coordinator" :
                            echo "<a href='RecyclingCoordinator/RC_homepage.php'> <div class='menu-option'> <h4> Coordinator Functions </h4> </div> </a>";
                            break;
                    }
                } else {
                    echo "<a href='userregister.php'> <div class='menu-option'> <h4> Register an Account </h4> </div> </a>";
                }
            ?>
            <a href="meetourteam.php"> <div class="menu-option"> <h4> Get to Know Us </h4> </div> </a>
        </div>
        
        <div id="profile">
            <div>
                <?php
                    if (isset($_SESSION["name"])) {
                        $name = $_SESSION["name"];
                        echo "$name";
                    } else {
                        echo "Guest";
                    }
                ?>
            </div>
            <div class="pfp"> <img id="pfp" src="pfp.png" style="border-radius:100%; width:100%; height:100%;" alt="pfp"></div>
            <div id="actions">
                <?php
                    if (!isset($_SESSION["id"])) {
                        echo "<a href='staff_login.php'> <div id='login-button'> Login </div> </a>";
                    } else {
                        echo "<div id='logout-button'> Logout </div> ";
                    }
                ?>
            </div>
        </div>
    </header>

    <div id="contents">
        <h1> Trash Transformers </h1>
        <h3> Giving a New Life to Trash </h3>

        <div class="content">
            <div class="big-pic">
                <img src="logo.png" style="height:100%;" alt="our logo">
            </div>

            <div>
                <h2> What do we do ? </h2>
                <p> Our system acts as the bridge between the APU community and recycling. We understand that ___ </p>
            </div>
        </div>

        <div class="content">
            <div class="big-pic">
                <img src="recycling.jpg" style="height:100%;" alt="collect dropoff">
            </div>

            <div>
                <h2> Why are we doing this ? </h2>
                <p>  </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("pfp").addEventListener("click", function () {
            document.getElementById("actions").classList.toggle("active");
        })

        document.getElementById("logout-button").addEventListener("click", function () {
            confirmLogout = confirm("Are you sure you want to logout?");

            if (confirmLogout) {
                window.location.href = "logout.php";
            }
        })
    </script>
</body>
</html>