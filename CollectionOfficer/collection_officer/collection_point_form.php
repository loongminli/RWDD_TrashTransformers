<?php
include "../../dbconn.php";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$name = '';
$is_active = 1;
$error = '';

if ($id > 0 && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $stmt = $conn->prepare("SELECT collectionpoint, is_active FROM collectionpoint WHERE collectionpoint_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) {
        header("Location: collection_points.php");
        exit;
    }
    $name = $row['collectionpoint'];
    $is_active = (int)$row['is_active'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['collectionpoint'] ?? '');
    $is_active = (int)($_POST['is_active'] ?? 1);

    if ($name === '') {
        $error = "Collection point name is required.";
    } elseif (mb_strlen($name) > 50) {
        $error = "Name must be 50 characters or less.";
    } elseif (!in_array($is_active, [0, 1], true)) {
        $error = "Invalid status.";
    } else {
        $stmt = $conn->prepare("SELECT 1 FROM collectionpoint WHERE collectionpoint = ? AND collectionpoint_id <> ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "This collection point already exists.";
        }
    }

    if ($error === '') {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE collectionpoint SET collectionpoint = ?, is_active = ? WHERE collectionpoint_id = ?");
            $stmt->bind_param("sii", $name, $is_active, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO collectionpoint (collectionpoint, is_active) VALUES (?, ?)");
            $stmt->bind_param("si", $name, $is_active);
        }
        $stmt->execute();
        header("Location: collection_points.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id > 0 ? "Edit" : "Add" ?> Collection Point</title>
    <link rel="stylesheet" href="../assets/collector.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main class="page">
        <a href="collection_points.php" class="back-button">&larr; Back</a>

        <div class="form-page">
            <form method="post" class="form-card validate-form">
                <h2><?= $id > 0 ? "Edit Collection Point" : "Add Collection Point" ?></h2>
                <p class="form-intro">
                    <?= $id > 0
                        ? "Update the name or status of this collection point."
                        : "Add a new place where students can drop off recyclables." ?>
                </p>

                <?php if ($error): ?>
                    <p class="error" role="alert"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <input type="hidden" name="id" value="<?= $id ?>">

                <label>Name <span class="required" aria-hidden="true">*</span>
                    <input type="text" name="collectionpoint" maxlength="50" required
                           placeholder="e.g. Near Bila Bila Mart"
                           value="<?= htmlspecialchars($name) ?>">
                    <small class="form-hint">Maximum 50 characters.</small>
                </label>

                <label>Status
                    <select name="is_active">
                        <option value="1" <?= $is_active === 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $is_active === 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <small class="form-hint">Inactive points cannot be used for new drop-offs.</small>
                </label>

                <div class="form-actions">
                    <a href="collection_points.php" class="back-button">Cancel</a>
                    <button type="submit" class="button"><?= $id > 0 ? "Save Changes" : "Add Point" ?></button>
                </div>
            </form>
        </div>
    </main>

    <script src="../assets/script.js"></script>
</body>
</html>