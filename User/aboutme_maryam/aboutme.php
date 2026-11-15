
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Maryam</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f0e0f8;
            color: #523450;
            font-family: Georgia, serif;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 35px 30px 60px;
        }

        .back {
            display: inline-block;
            background: #52236f;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 18px;
        }

        .back:hover {
            background: #8a57c0;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 55px;
            margin: 35px 0 45px;
        }

        .profile img {
            width: 270px;
            height: 270px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #181652;
            padding: 7px;
            flex-shrink: 0;
        }

        .intro h1 {
            font-size: 65px;
            color: #ae6fb0;
            margin: 0 0 12px;
        }

        .intro h2 {
            display: inline-block;
            background: #715aa5;
            color: #bdaeec;
            padding: 5px 45px;
            border-radius: 12px;
            font-size: 35px;
            margin: 0 0 20px;
        }

        .intro p {
            font-family: Arial, sans-serif;
            font-size: 19px;
            line-height: 1.6;
            max-width: 570px;
        }

        .sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: #b3a8e4;
            border: 3px solid #3a1d5e;
            border-radius: 35px;
            padding: 30px;
        }

        .card h2 {
            color: #533156;
            font-size: 32px;
            margin: 0 0 28px;
        }

      
        .education-item {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #dbccf7;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 25px;
        }


        .education-item img {
            width: 75px;
            height: 75px;
            object-fit: contain;
            flex-shrink: 0;
            }

        .year {
            display: inline-block;
            background: #fae9fd;
            color: #595375;
            font-size: 21px;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 15px;
            margin-bottom: 12px;
        }

        .education-item p {
            font-size: 19px;
            margin: 0;
            line-height: 1.5;
        }

        .interest {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #dbccf7;
            padding: 12px;
            border-radius: 20px;
            margin-bottom: 15px;
        }

        .interest img {
            width: 115px;
            height: 90px;
            object-fit: cover;
            border-radius: 15px;
        }

        .interest h3 {
            font-size: 20px;
            margin: 0;
        }

        .interest p{
            margin: 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .connect {
            margin-top: 25px;
            text-align: center;
        }

        .connect h2 {
            margin-bottom: 25px;
        }

        .socials {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 70px;
        }

        .socials img {
            width: 65px;
            height: 65px;
            object-fit: contain;
            transition: transform 0.2s;
        }

        .socials img:hover {
            transform: scale(1.12);
        }

        @media (max-width: 750px) {
            .profile {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .profile img {
                width: 200px;
                height: 200px;
            }

            .intro h1 {
                font-size: 45px;
            }

            .intro h2 {
                font-size: 28px;
            }

            .sections {
                grid-template-columns: 1fr;
            }

            .socials {
                gap: 30px;
            }

            .socials img {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <a href="../meetourteam.php" class="back"> ◀┈╯ Back</a>

        <div class="profile">
            <img src="maryampfp.jpeg" alt="myprofilepicture">

            <div class="intro">
                <h1>About Me</h1>
                <h2>Maryam</h2>

                <p>
                    Hi! I'm Maryam Rehman and I'm from Pakistan currently studying Diploma ICT at Asia Pacific University.
                    I enjoy playing various online games. I like cooking and baking and i love travelling to different places and meeting new people!
                </p>
            </div>
        </div>

        <div class="sections">

            <div class="card">
                <h2>🎓 Education</h2>

                            
            <div class="education-list">

                <div class="education-item">
                    <img src="flower1.png" alt="Flower">

                    <div>
                        <span class="year">2025 - Current</span>
                        <p>Asia Pacific University (APU)</p>
                    </div>
                </div>

                <div class="education-item">
                    <img src="flower2.png" alt="Flower">

                    <div>
                        <span class="year">2022 - 2024</span>
                        <p>A-Levels</p>
                    </div>
                </div>

            </div>
            </div>


            <div class="card">
                <h2>💖 Interests</h2>

                <div class="interest">
                    <img src="game.png" alt="Gaming">

                    <div>
                    <h3>Playing Games</h3>
                    <p> i love playing story based games </p>
                </div>
            </div>

                <div class="interest">
                    <img src="chef.png" alt="cooking and baking">

                    <div>
                    <h3>Cooking & Baking</h3>
                    <p> i love to cook my traditional food and i like baking brownies </p>
                </div>
            </div>

                <div class="interest">
                    <img src="travel.png" alt="travelling">

                    <div>
                    <h3>Travelling</h3>
                    <p> my dream is to travel every corner of this world </p>
                </div>
            </div>
        </div>

        </div>

        <div class="card connect">
            <h2> 🌐 Connect with Me</h2>

            <div class="socials">
                <a href="mailto: maryam.rehman1505@gmail.com">
                    <img src="gmail.png" alt="Gmail">
                </a>

                <a href="mailto: TP088761@mail.apu.edu.my">
                    <img src="outlook.png" alt="Outlook">
                </a>

                <a href="https://github.com/MR-5000">
                    <img class="icon" src="github.jpeg" alt="github"> 
                </a>
            </div>
        </div>

    </div>
</body>
</html>
