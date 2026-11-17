</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        :root {
           --bg: #f7f4ed;
            --main: #8fa28a;
            --card: #c7d3c0;
            --acccent: #c8a96b;
            --text: #222;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

html { scroll-behavior: smooth; }

body {
    font-family: 'Trebuchet MS', Arial, sans-serif;
    background: var(--bg);
    color: var(--text);
    line-height: 1.6;
}

a { color: inherit; }

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    background: var(--main);
}
nav ul { display: flex; gap: 1rem; list-style: none; flex-wrap: wrap; }
nav a { text-decoration: none; padding: 0.3rem 0.8rem; border-radius: 20px; }
nav a:hover { background: var(--accent); }

main { max-width: 900px; margin: 0 auto; padding: 1rem 1.5rem; }
section { margin: 2rem 0; }
section h2 { margin-bottom: 1rem; border-bottom: 3px solid var(--accent); display: inline-block; }

.intro { display: flex; align-items: center; gap: 1.5rem; }
.profile-photo {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid black;
}

.timeline { list-style: none; border-left: 4px solid var(--accent); padding-left: 1rem; }
.timeline li { margin-bottom: 1.2rem; }
.years { font-style: italic; }

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
}
.card {
    padding: 1.2rem;
    text-align: center;
    background: var(--card);
    border: 2px solid black;
    border-radius: 10px;
}
.icon { display: block; font-size: 2.5rem; }

.hobby-img { width: 100%; height: 150px; object-fit: cover; border-radius: 8px; }

.social-links { display: flex; gap: 1rem; list-style: none; margin-top: 0.75rem; flex-wrap: wrap; }
.social-links a {
    display: inline-block;
    padding: 0.5rem 1.2rem;
    background: var(--accent);
    border: 2px solid black;
    border-radius: 20px;
    text-decoration: none;
}
.social-links a:hover { background: var(--card); }

footer { text-align: center; padding: 1rem; background: var(--main); }

@media (max-width: 600px) {
    .intro { flex-direction: column; text-align: center; }
    header { justify-content: center; }
}

    </style>
</head>
<body>
    <header>
        <h1>Wong Yan Qi</h1>
         <nav aria-label="Main navigation">
            <ul>
                <li><a href="#personal">About</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#hobbies">Hobby</a></li>
                <li><a href="c#ontact">Contact</a></li>
                <li><a href="../meetourteam.php">Back</a></li>
            </ul>
         </nav>
    </header>

    <main>
        <section id="personal" class="intro">
            <img src="profile.jpeg" alt="Photo of Wong Yan Qi" class="profile-photo">
            <div>
                <h2>I'm Wong Yan Qi</h2>
                <p>I'm a Diploma student currently pursing a Diploma in Information and Communication Technology with a speacialism in Data Informatics at APU. I'm interested in exploring technology, developing new skills, and learning how technology can be used to solve real-world problems. I enjoy spendng time on activities that interest me, exploring new places, and creating meaningful experiences. I'm always looking for opportunities to grow, gain new expericences, and improve myself both personally and academically. </p>
            </div>
        </section>

        <section id="education">
            <h2>Education Background</h2>
            <ul class="timeline">
                <li>
                    <h3>Diploma in Information and Communication Technology (Data Informatics)</h3>
                    <p>Asia Pacific University of Technology & Innovation (APU)</p>
                    <p class="years">2025 - Present</p>
                </li>

                <h3>Secondary Education</h3>
                <p>Poi Lam High School</p>
                <p class="years">2019 - 2023</p>
            </ul>
        </section>

        <section id="hobbies">
            <h2>Hobbies and Interest</h2>
            <div class= "card-grid">
                <article class="card">
                    <img src="exercise.jpeg" alt="Photo of Playing Volleyball" class="hobby-img">
            <h3>Exercise</h3>
            <p>I love exercising because I enjoy the feeling of being active, sweating, and the energy. I especially enjoy group activities and team sports, such as playing volleyball with friends. For me, it's not just about staying healthy, but also having fun and creating great memories together.</p>
            </article>

            <article class="card">
                    <img src="travel.jpeg" alt="Photo of Travel" class="hobby-img">
            <h3>Travel</h3>
            <p>I love travelling with my family and friends, exploring the world and discovering new places. The world is so big, with diverse landscapes, cultures, histories, and lifestyles waiting to be explored. Most importantly, I enjoy creating special memories and cherishing meaningful moments with the people I love.</p>
            </article>

            <article class="card">
                    <img src="music.jpeg" alt="Photo of Concert" class="hobby-img">
            <h3>Listen Music</h3>
            <p>I love appreciating the creativity and talent behind music. I'm fascinated by how artists express their emotions and tell stories through lyrics, melodies, rhythm, and flow. I admire how music can inspire people, connect emotions, and encourage others through its unique form of artistic expression.</p>
            </article>

            </div>
        </section>

        <section id="Contact">
            <h2>Contact Me</h2>
            <p>Email: <a href="mailto:wongyq6313@gmail.com">wongyq6313@gmail.com</a></p>
            <ul class="social-links">
                <li><a href="https://www.instagram.com/yannqqii?dlrf=MTBtZTliaHp6b3YwZw%3D%3D&utm_source=qr" target="_blank" rel="noopener">Instagran</a></li>
                <li><a href="https://www.linkedin.com/in/wongyanqi/" target="_blank" rel="noopener">LinkedIn</a></li>
                <li><a href="https://github.com/yq6313" target="_blank" rel="noopener">GitHub</a></li>
            </ul>
        </section>
    </main>

    <footer>

    </footer>

</body>
</html>