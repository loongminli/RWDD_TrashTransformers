<header>
    <div class="logo"> 
        <img src="../logo.png" style="border-radius:100%; width:100%; height:100%;">
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

    <div id="profile" class="placeholder">
        <div> name </div>
        <div> pfp </div>
    </div>

    <script>
        document.getElementById("hamburger-menu-icon").addEventListener("click", function () {
            document.getElementById("menu-options").classList.toggle("active");
            this.classList.toggle("active");
        });
    </script>
</header>