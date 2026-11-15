<?php
include "../../dbconn.php";

$result = $conn->query("SELECT * FROM collectionpoint ORDER BY collectionpoint_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection Points</title>
    <link rel="stylesheet" href="../assets/collector.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main class="page">
        <a href="collector_dashboard.php" class="back-button">&larr; Back</a>
        <h1>Collection Points</h1>
        <a href="collection_point_form.php" class="text-link">+ Add New Collection Point</a>

        <div class="table-wrap">
            <table class="info-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Collection Point</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row["collectionpoint_id"] ?></td>
                        <td><?= htmlspecialchars($row["collectionpoint"]) ?></td>
                        <td><?= $row["is_active"] ? "Active" : "Inactive" ?></td>
                        <td>
                            <a href="collection_point_form.php?id=<?= (int)$row['collectionpoint_id'] ?>" class="text-link">Edit</a>
                            <a href="toggle_collection_point.php?id=<?= (int)$row['collectionpoint_id'] ?>"
                            class="text-link"
                               onclick="return confirm('Change status of this collection point?');">
                                <?= $row["is_active"] ? "Deactivate" : "Activate" ?>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No collection points found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../assets/script.js"></script>
</body>
</html>