<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Meet Group 32 </title>
    <style>
        * {
            font-family :'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            margin : 0;
            padding : 0;
            box-sizing : border-box;
        }
        
        #content {
            display : flex;
            flex-direction : column;
            padding : 3rem;
            align-items : center;
            justify-content : center;
        }

        #cards {
            margin : auto;
            display : grid;
            grid-template-columns : repeat(4, 1fr);
        }

        body {
            background-color : #F7F4ED;
        }

        a {
            text-decoration : none;
            padding : 0;
        }

        h1, h2, h3 {
            text-align : center;
        }

        h2 {
            color : #6e5117;
        }

        .card {
            display : flex;
            flex-direction : column;
            margin : 1rem;
            border : 8px solid #8FA28A;
            border-radius : 20px;
            background-color : #C7D3C0;
            padding-bottom : 3rem;
            align-items : center;
        }

        .pfp {
            width : 15rem;
            height : 15rem;
            border-radius : 100%;
            margin : 1rem;
        }

        .homepage-button {
            background-color : #C8A96B;
            border : 2px solid #9a814f;
            border-radius : 5px;
            color : black;
            text-decoration : none;
            padding : 0.3rem;
            margin-bottom : 3rem;
        }

        @media (max-width : 768px) {
            #cards {
                grid-template-columns : none;
            }
        }
    </style>
</head>
<body>
    <div id="content">
        <a class="homepage-button" href="index.php"> Return to Homepage </a>

        <h1> Meet Our Team </h1>

        <div id="cards">
            <div class="card" onclick="window.location.href='LINK HERE'">
                <img src="logo.png" alt="NAMEEEEE" class="pfp">
                <div class="info">
                    <h2> Administrator </h2>
                    <h3> Gan Yu Xuan </h3>
                </div>
            </div>

            <div class="card" onclick="window.location.href='LINK HERE'">
                <img src="logo.png" alt="NAMEEEEE" class="pfp">
                <div class="info">
                    <h2> Collector </h2>
                    <h3> Wong Yan Qi </h3>
                </div>
            </div>

            <div class="card" onclick="window.location.href='aboutme-minli/aboutme_minli.php'">
                <img src="aboutme-minli/minli.jpg" alt="minli" class="pfp">
                <div class="info">
                    <h2> Recycling Coordinator </h2>
                    <h3> Loong Min Li </h3>
                </div>
            </div>

            <div class="card" onclick="window.location.href='LINK HERE'">
                <img src="logo.png" alt="NAMEEEEE" class="pfp">
                <div class="info">
                    <h2> User </h2>
                    <h3> Maryam Rehman </h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>