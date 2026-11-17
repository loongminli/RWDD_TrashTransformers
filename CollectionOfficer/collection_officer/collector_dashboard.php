<?php include "../../dbconn.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/collector.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main class="dashboard">

        <h1>COLLECTOR MENU</h1>

        <div class="menu-grid">

            <a href="collection_records.php" class="menu-card">
                <span class="menu-icon" aria-hidden="true">♻️</span>
                <h3>Collection Records</h3>
                <p>View and filter collection records</p>
                <span class="menu-link">View Records</span>
            </a>

            <a href="verify_collection.php" class="menu-card">
                <span class="menu-icon" aria-hidden="true">✅</span>
                <h3>Verify Collection</h3>
                <p>Check items and sort recyclables</p>
                <span class="menu-link">Verify Items</span>
            </a>

            <a href="collection_points.php" class="menu-card">
                <span class="menu-icon" aria-hidden="true">📍</span>
                <h3>Collection Points</h3>
                <p>Manage collection locations</p>
                <span class="menu-link">View Points</span>
            </a>

            <a href="recycling_guidelines.php" class="menu-card">
                <span class="menu-icon" aria-hidden="true">📖</span>
                <h3>Recycling Guidelines</h3>
                <p>Manage recycling instructions</p>
                <span class="menu-link">View Guidelines</span>
            </a>

        </div>

    </main>

    <script src="../assets/script.js"></script>
</body>
</html>