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

        @media (max-width : 768px) {
            #cards {
                grid-template-columns : none;
            }
        }
    </style>
</head>
<body>
    <div id="content">
        <h1> Meet Group 32 </h1>

        <div id="cards">
            <div class="card" onclick="window.location.href='LINK HERE'">
                <img src="logo.png" alt="NAMEEEEE" class="pfp">
                <div class="info">
                    <h2> Administrator </h2>
                    <h3> Nameeeee </h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>