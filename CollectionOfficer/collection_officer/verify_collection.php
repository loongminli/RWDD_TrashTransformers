<?php
include "../../dbconn.php";

$staff_id = 'CL001';
$id = (int)($_GET['id'] ?? $_POST['dropoff_id'] ?? 0);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actual        = filter_var($_POST['actual_quantity'] ?? '', FILTER_VALIDATE_INT);
    $is_recyclable = (int)($_POST['is_recyclable'] ?? -1);

    if ($actual === false || $actual < 0) {
        $error = "Actual quantity must be 0 or more.";
    } elseif (!in_array($is_recyclable, [0, 1], true)) {
        $error = "Please choose recyclable or not.";
    }

    if ($error === '') {
        try {
            $conn->begin_transaction();

            $stmt = $conn->prepare(
                "SELECT dropoff_id FROM dropoff WHERE dropoff_id = ? AND is_collected = 0 FOR UPDATE");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            if (!$stmt->get_result()->fetch_assoc()) {
                throw new Exception("This drop-off does not exist or was already processed.");
            }

            $stmt = $conn->prepare(
                "INSERT INTO dropoff_check (dropoff_id, actual_quantity, is_recyclable, staff_id)
                 VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $id, $actual, $is_recyclable, $staff_id);
            $stmt->execute();

            $stmt = $conn->prepare("UPDATE dropoff SET is_collected = 1 WHERE dropoff_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $conn->commit();
            header("Location: collection_records.php");
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            $error = $e->getMessage();
        }
    }
}

$drop = null;
if ($id > 0) {
    $stmt = $conn->prepare(
        "SELECT d.*, u.username, cp.collectionpoint
         FROM dropoff d
         JOIN user u ON d.user_id = u.user_id
         JOIN collectionpoint cp ON d.collectionpoint_id = cp.collectionpoint_id
         WHERE d.dropoff_id = ? AND d.is_collected = 0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $drop = $stmt->get_result()->fetch_assoc();
} else {
    $pending = $conn->query(
        "SELECT d.dropoff_id, d.item, d.quantity, d.dropoff_datetime, u.username, cp.collectionpoint
         FROM dropoff d
         JOIN user u ON d.user_id = u.user_id
         JOIN collectionpoint cp ON d.collectionpoint_id = cp.collectionpoint_id
         WHERE d.is_collected = 0
         ORDER BY d.dropoff_datetime");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Collection</title>
    <link rel="stylesheet" href="../assets/collector.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main class="page">
        <?php if ($id > 0): ?>
            <a href="verify_collection.php" class="back-button">&larr; Back</a>
        <?php else: ?>
        <a href="collector_dashboard.php" class="back-button">&larr; Back</a>
        <?php endif; ?>
        <h1>Verify Collection</h1>

        <?php if ($error): ?>
            <p class="error" role="alert"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($id > 0 && $drop): ?>
            <p>
                <strong>Item:</strong> <?= htmlspecialchars($drop['item']) ?> |
                <strong>Declared qty:</strong> <?= (int)$drop['quantity'] ?> |
                <strong>User:</strong> <?= htmlspecialchars($drop['username']) ?> |
                <strong>Point:</strong> <?= htmlspecialchars($drop['collectionpoint']) ?>
            </p>

            <form method="post" class="form-card"
      data-confirm="Submit this check? You cannot edit it afterwards.">
    <input type="hidden" name="dropoff_id" value="<?= (int)$drop['dropoff_id'] ?>">

    <label>Actual quantity
        <input type="number" name="actual_quantity" id="actual_quantity" min="0" required
               data-declared="<?= (int)$drop['quantity'] ?>">
        <small id="qtyHint" class="form-hint" aria-live="polite"></small>
    </label>

                <fieldset>
                    <legend>Recyclable?</legend>
                    <label><input type="radio" name="is_recyclable" value="1" required> Yes</label>
                    <label><input type="radio" name="is_recyclable" value="0"> No</label>
                </fieldset>

                <div class="form-actions">
                    <button type="submit">Submit</button>
                    <a href="verify_collection.php" class="text-link">Cancel</a>
                </div>
            </form>

        <?php elseif ($id > 0): ?>
            <p>Record not found or already processed.</p>
            <a href="verify_collection.php">Back</a>

        <?php else: ?>
            <div class="table-wrap">
                <table class="info-table">
                    <thead>
                        <tr><th>ID</th><th>Item</th><th>Qty</th><th>Date</th><th>User</th><th>Point</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php if ($pending && $pending->num_rows > 0): ?>
                        <?php while ($r = $pending->fetch_assoc()): ?>
                        <tr>
                            <td><?= (int)$r['dropoff_id'] ?></td>
                            <td><?= htmlspecialchars($r['item']) ?></td>
                            <td><?= (int)$r['quantity'] ?></td>
                            <td><?= htmlspecialchars($r['dropoff_datetime']) ?></td>
                            <td><?= htmlspecialchars($r['username']) ?></td>
                            <td><?= htmlspecialchars($r['collectionpoint']) ?></td>
                            <td><a href="verify_collection.php?id=<?= (int)$r['dropoff_id'] ?>" class="text-link">Verify</a></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No pending drop-offs.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

    <script src="../assets/script.js"></script>
</body>
</html>