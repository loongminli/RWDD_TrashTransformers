<?php
include "../../dbconn.php";

$staff_id = 'CL001'; 
$stmt = $conn->prepare("SELECT name FROM staff WHERE staff_id = ?");
$stmt->bind_param("s", $staff_id);
$stmt->execute();
$staffName = $stmt->get_result()->fetch_assoc()['name'] ?? 'Collector';

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
        <a href = "../../index.php"> <img src="../../logo.png" style="border-radius:100%; width:100%; height:100%;" alt="logo"> </a>
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
        <div> <?= htmlspecialchars($staffName) ?> </div>
        <div class="pfp"> <img id="pfp" src="../../pfp.png" alt="pfp" style="border-radius:100%; width:100%; height:100%;"> </div>
    </div>

    <script>
        document.getElementById("hamburger-menu-icon").addEventListener("click", function () {
            document.getElementById("menu-options").classList.toggle("active");
            this.classList.toggle("active");
        });
    </script>
</header>