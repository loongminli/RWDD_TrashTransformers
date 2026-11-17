<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    
    <style>

        body {
            margin: 0;
            padding: 0 20px 40px;
            font-family: 'Times New Roman', Times, serif;
            background-color: lavenderblush;
            color: black;
            line-height: 1.25;
        }

        h1 {
            text-align: center;
            color: mediumvioletred;
            font-size: 36px;
            padding: 25px;
            margin: 0 auto 25px;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 25px 35px;
            background-color: mistyrose;
            border-radius: 15px;
        }

        h2 {
            color: mediumvioletred;
            font-size: 25px;
            border-bottom: 2px solid palevioletred;
            padding-bottom: 8px;
            margin-top: 35px;
        }

        h3 {
            color: palevioletred;
            font-size: 20px;
            margin-top: 25px;
        }

        p {
            color: black;
            font-size: 16px;
            margin: 12px 0;
        }

        .profile-photo {
            display: block;
            width: 180px;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid pink;
            margin: 15px 0;
        }

        .travel-images {
            display: grid;
            grid-template-columns: repeat(3, 150px);
            gap: 15px;
            margin: 15px 0 25px;
        }

        .travel-images figure {
            margin: 0;
            text-align: center;
        }

        .travel-images img {
            display: block;
            width: 100%;
            height: 180px;
            object-fit: cover;
            border: 2px solid pink;
            border-radius: 10px;
            box-sizing: border-box;
            transition: transform 0.3s;
        }

        .travel-images img:hover {
            transform: scale(1.05);
        }

        .travel-images figcaption {
            margin-top: 6px;
            font-size: 14px;
            color: black;
            overflow-wrap: anywhere;
        }

        a {
            color: mediumvioletred;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            body {
                padding: 0 10px 20px;
            }

            .container {
                padding: 20px;
                margin: 10px auto;
            }

            h1 {
                font-size: 28px;
            }

            .travel-images {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .travel-images img {
                height: 120px;
            }

            .travel-images figcaption {
                font-size: 12px;
            }

            .back {
                display : flex;
                flex-direction : column;
                align-items : center;
            }
        }
    </style>
</head>
<body>
    <div class="back"> <a href="../meetourteam.php">Back</a> </div>
    <h1>About Me</h1>

    <div class="container">

        <h2>Personal Information</h2>
        <img src="images/me.jpeg" alt="My Photo" class="profile-photo">
        <p>Name: Gan Yu Xuan</p>
        <p>Hi, You can call me Andrea. I'm from Johor.</p>
        <p>Welcome to my personal page.</p>

        <h2>Educational Background</h2>
        <p>University: Asia Pacific University of Technology & Innovation (APU)</p>
        <a href="https://www.apu.edu.my/">APU Website</a>
        <p>Certificate: Information and Communication Technology</p>
        <p>Diploma: Information and Communication Technology (DI)</p>

        <h2>Hobbies and Interests</h2>

        <h3>1. Watching Movies</h3>
        <p>I enjoy watching movies and dramas, and I often go to TGV Cinemas during my free time.</p>

        <h3>2. Travelling</h3>
        <p>I love travelling and exploring new places.</p>
        <div class="travel-images">
            <figure>
                <img src="images/travel1.jpeg" alt="China Xi'an">
                <figcaption>China XI'AN</figcaption>
            </figure>

            <figure>
                <img src="images/travel2.jpeg" alt="China Chang'an">
                <figcaption>China CHANG AN</figcaption>
            </figure>

            <figure>
                <img src="images/travel3.jpeg" alt="China Suzhou">
                <figcaption>China SU ZHOU</figcaption>
            </figure>

            <figure>
                <img src="images/travel4.jpeg" alt="China Xi'an Dayanta">
                <figcaption>China XI'AN (Dayanta)</figcaption>
            </figure>

            <figure>
                <img src="images/travel5.jpeg" alt="China Shanghai Jingrong">
                <figcaption>China SHANG HAI (Jingrong)</figcaption>
            </figure>

            <figure>
                <img src="images/travel6.jpeg" alt="China Shanghai">
                <figcaption>China SHANG HAI</figcaption>
            </figure>
        </div>

        <h3>3. Eating</h3>
        <p>I love eating!!! Food makes me happy.</p>
        <div class="travel-images">
            <figure>
                <img src="images/food1.jpeg" alt="AiFO KATO">
                <figcaption>AiFO KATO</figcaption>
            </figure>

            <figure>
                <img src="images/food2.jpeg" alt="IKEA">
                <figcaption>IKEA</figcaption>
            </figure>

            <figure>
                <img src="images/food3.jpeg" alt="Lok Lok">
                <figcaption>Lok Lok</figcaption>
            </figure>

            <figure>
                <img src="images/food4.jpeg" alt="Palsaik Korean BBQ">
                <figcaption>Palsaik Korean BBQ</figcaption>
            </figure>

            <figure>
                <img src="images/food5.jpeg" alt="Moxie">
                <figcaption>Moxie</figcaption>
            </figure>

            <figure>
                <img src="images/food6.jpeg" alt="Cake">
                <figcaption>Cake</figcaption>
            </figure>

            <figure>
                <img src="images/food7.jpeg" alt="Haidilao">
                <figcaption>Haidilao</figcaption>
            </figure>

            <figure>
                <img src="images/food8.jpeg" alt="Thailand">
                <figcaption>Thailand</figcaption>
            </figure>

            <figure>
                <img src="images/food9.jpeg" alt="French Fries">
                <figcaption>French Fries</figcaption>
            </figure>
        </div>

        <h2>Contact Information</h2>
        <p>Facebook:
            <a href="https://www.facebook.com/share/14vtp1VHcmK/?mibextid=wwXIfr">Andrea</a>
        </p>

        <p>Instagram:
            <a href="https://www.instagram.com/xka44._">xka44._</a>
        </p>

        <p>Snapchat:
            <a href="https://snapchat.com/t/a8YrT7MT">xka.44</a>
        </p>

    </div>

</body>
</html>
