<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me : Loong Min Li</title>

    <style>
        * {
            font-family : 'Courier New', Courier, monospace;
            margin : 0;
            padding : 0;
            box-sizing : border-box;
        }

        body {
            background-color : #F3E4C9;
        }

        h1, h2, h3 {
            text-align : center;
        }

        .title {
            text-decoration : underline;
            color : #7a5b31;
            padding-bottom : 0.5rem;
        }

        #content {
            display : flex;
            flex-direction : column;
            padding : 3rem;
            align-items : center;
        }

        #cards {
            display : grid;
            align-items : center;
            grid-template-columns : repeat(2, 1fr);
            gap : 2rem;
        }

        .card {
            padding : 0.5rem;
            border : 4px double #0A2947;
            border-radius : 5px;
            background-color : #D3D4C0;
            align-items : center;
            height : 100%;
        }

        .double-column {
            grid-column : span 2;
        }

        #pfp {
            width : 200px;
            height : 200px;
            border : 2px solid black;
            border-radius : 100%;
        }

        .socmeds {
            display : flex;
            gap : 2rem;
            align-items : center;
            justify-content: center;
        }

        .icon {
            height : 5rem;
            width : 5rem;
            border-radius : 100%;
        }

        .back-button {
            border : 2px solid black;
            border-radius : 10px;
            background-color : #0A2947;
            color : #D3D4C0;
            padding : 0.5rem;
        }

        a {
            margin-bottom : 2rem;
        }

        table {
            border-collapse: collapse;
            background-color: white;
        }

        table th, td {
            border : 1px solid black;
        }

        .interest {
            display : flex;
            flex-direction : column;
            border : 2px dashed black;
            background-color : white;
            margin : 0.5rem;
            align-items : center;
        }

        .interest-pic {
            border-radius : 5px;
            height : 4rem;
        }

        @media (max-width : 768px) {
            #content {
                padding : 1rem;
            }

            #cards {
                grid-template-columns : none;
            }

            .card {
                height : fit-content;
            }

            .double-column {
                grid-column : span 1;
            }
        }
    </style>
</head>
<body>
    <div id="content">
        <a href = "index.php"> <div class="back-button"> Back </div> </a>
        <img id="pfp" src="minli.jpg" alt="min li">
        <h1> Loong Min Li </h1>
        <h3> A second year computer science major. </h3>
        <h3> You can address me as <em>Min Li</em> ! </h3>

        <div id="cards">
            <div class="card">
                <h2 class="title"> Education </h2>
                <table>
                    <tr>
                        <th style="width:30%">Year</th>
                        <th>Education</th>
                    </tr>
                    <tr>
                        <td>2025-current</td> <td>Asia Pacific University of Technology & Innovation (APU)</td>
                    </tr>
                    <tr>
                        <td>2020-2024</td> <td>SMK Seri Bintang Utara</td>
                    </tr>
                    <tr>
                        <td>2014-2019</td> <td>SK Seri Bintang Utara</td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <h2 class="title"> Interests </h2>
                <div class="interest">
                    <h3> Playing Computer Games </h3>
                    <p> I enjoy games where I can pause anytime such as  </p>
                    <div>
                        <img class="interest-pic" src="minecraft.png" alt="minecraft">
                        <img class="interest-pic" src="terraria.png" alt="terraria">
                    </div>
                </div>
                <div class="interest">
                    <h3> Listening to Music </h3>
                    <p> I regularly listen to K-Pop groups such as </p>
                    <div>
                        <img src="kpop1.png" alt="Fromis 9" class="interest-pic">
                        <img src="kpop2.png" alt="NMIXX" class="interest-pic">
                    </div>
                </div>
                <div class="interest">
                    <h3> Arts and Crafts </h3>
                    <p> I like handmade items as they hold sentimental value </p>
                    <div>
                        <img src="crochet.png" alt="crochet" class="interest-pic">
                        <img src="needlefelt.png" alt="needle felting" class="interest-pic">
                    </div>
                </div>
            </div>

            <div class="double-column card">
                <h2 class="title"> Connect with Me </h2>
                <div class="socmeds">
                    <a href="mailto:loongminli@gmail.com"> <img class="icon" src="gmail.png" alt="gmail"> </a>
                    <a href="mailto:tp089374@mail.apu.edu.my"> <img class="icon" src="outlook.png" alt="outlook"> </a>
                    <a href="https://github.com/loongminli"> <img class="icon" src="github.png" alt="github"> </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>