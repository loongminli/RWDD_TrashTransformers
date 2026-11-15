<?php
include "../../dbconn.php";

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare(
        "UPDATE collectionpoint SET is_active = 1 - is_active WHERE collectionpoint_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: collection_points.php");
exit;