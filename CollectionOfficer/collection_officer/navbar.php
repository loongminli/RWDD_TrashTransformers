<?php
include "../../dbconn.php";

$current = basename($_SERVER['PHP_SELF']);

$links = [
    'collection_records.php'   => 'Records',
    'verify_collection.php'    => 'Verify',
    'collection_points.php'    => 'Points',
    'recycling_guidelines.php' => 'Guidelines',
];
?>
<header>
    <div class="logo">
        <a href = "../../index.php"> <img src="../../logo.png" alt="logo"> </a>
    </div>

    <div id="menu">
        <div id="hamburger-menu-icon"> Action Menu </div>
        <div id="menu-options">
            <?php foreach ($links as $file => $label): ?>
                <a href="<?= $file ?>">
                    <div class="menu-option <?= $file === $current ? 'current' : '' ?>">
                        <h4> <?= $label ?> </h4>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="profile">
        <div> <?= htmlspecialchars($_SESSION["name"]) ?> </div>
        <div class="pfp"> <img id="pfp" src="../../pfp.png" alt="pfp" style="border-radius:100%; width:100%; height:100%;"> </div>
        <div id="staff-actions">
            <div id="homepage-button" onclick="window.location.href='collector_dashboard.php'"> Dashboard </div>
            <div id="logout-button"> Logout </div> 
        </div>
    </div>

    <script>
        document.getElementById("hamburger-menu-icon").addEventListener("click", function () {
            document.getElementById("menu-options").classList.toggle("active");
            this.classList.toggle("active");
        });

        document.getElementById("pfp").addEventListener("click", function () {
            document.getElementById("staff-actions").classList.toggle("active");
        })

        document.getElementById("logout-button").addEventListener("click", function () {
            confirmLogout = confirm("Are you sure you want to logout?");

            if (confirmLogout) {
                window.location.href = "../../logout.php";
            }
        })
    </script>
</header>