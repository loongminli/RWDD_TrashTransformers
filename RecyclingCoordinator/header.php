<header>
    <div class="logo"> 
        <img src="../logo.png" style="border-radius:100%; width:100%; height:100%;" alt="logo">
    </div>
    
    <div id="menu">
        <div id="hamburger-menu-icon"> Action Menu </div>
        <div id="menu-options">
            <a href="RC_recyclingcentre.php">
                <div class="menu-option">
                    <h4> Recycling Centres </h4>
                </div>
            </a>
            <a href="RC_recyclables.php">
                <div class="menu-option">
                    <h4> Manage Recyclables </h4>
                </div>
            </a>
            <a href="RC_nonrecyclables.php">
                <div class="menu-option">
                    <h4> Manage Non-recyclables </h4>
                </div>
            </a>
        </div>
    </div>

    <div id="profile">
        <div> 
            <?php 
                echo "<h3> $name </h3>"; 
            ?>
        </div>
        <div class="pfp"> <img id="pfp" src="../pfp.png" alt="pfp" style="border-radius:100%; width:100%; height:100%;"> </div>
        <div id="staff-actions">
            <div id="homepage-button" onclick="window.location.href='RC_homepage.php'"> Coordinator Homepage </div>
            <div id="logout-button"> Logout </div> 
        </div>
    </div>

    <script>
        document.getElementById("hamburger-menu-icon").addEventListener("click", function () {
            document.getElementById("menu-options").classList.toggle("active");
        });

        document.getElementById("pfp").addEventListener("click", function () {
            document.getElementById("staff-actions").classList.toggle("active");
        })

        document.getElementById("logout-button").addEventListener("click", function () {
            confirmLogout = confirm("Are you sure you want to logout?");

            if (confirmLogout) {
                window.location.href = "../staff_login.php";
            }
        })
    </script>
</header>