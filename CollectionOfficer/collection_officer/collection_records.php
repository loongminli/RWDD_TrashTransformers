<?php
include "../../dbconn.php";

$status = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');
$from = $_GET['from']?? '';
$to = $_GET['to']?? '';

$sql = "SELECT d.dropoff_id, d.item, d.quantity, d.dropoff_datetime, d.is_collected,
               u.username, cp.collectionpoint,
               dc.actual_quantity, dc.is_recyclable, s.name AS checked_by
        FROM dropoff d
        JOIN user u ON d.user_id = u.user_id
        JOIN collectionpoint cp ON d.collectionpoint_id = cp.collectionpoint_id
        LEFT JOIN dropoff_check dc ON d.dropoff_id = dc.dropoff_id
        LEFT JOIN staff s ON dc.staff_id = s.staff_id
        WHERE 1=1";

        $types = '';
$params = [];

if ($status === '0' || $status === '1') {
    $sql .= " AND d.is_collected = ?";
    $types .= 'i';
    $params[] = (int)$status;
}
if ($search !== '') {
    $sql .= " AND (d.item LIKE ? OR u.username LIKE ?)";
    $types .= 'ss';
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
}
if ($from !== '') {
    $sql .= " AND DATE(d.dropoff_datetime) >= ?";
    $types .= 's';
    $params[] = $from;
}
if ($to !== '') {
    $sql .= " AND DATE(d.dropoff_datetime) <= ?";
    $types .= 's';
    $params[] = $to;
}
$sql .= " ORDER BY d.dropoff_datetime DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/collector.css">
</head>
<body>

<?php include "navbar.php"; ?>

    <main class="page">
        <a href="collector_dashboard.php" class="back-button">&larr; Back</a>
    <h1>Collection Records</h1>

        <form method="get" class="filter-form">
            <label>Search
                <input type="text" name="search" placeholder="Item or username"
                       value="<?= htmlspecialchars($search) ?>">
            </label>

            <label>Status
                <select name="status">
                    <option value="">All</option>
                    <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Pending</option>
                    <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Collected</option>
                </select>
            </label>

            <label>From
                <input type="date" name="from" value="<?= htmlspecialchars($from) ?>">
            </label>

            <label>To
                <input type="date" name="to" value="<?= htmlspecialchars($to) ?>">
            </label>

            <button type="submit">Filter</button>
            <a href="collection_records.php" class="text-link">Reset</a>
        </form>

        <p><?= $result->num_rows ?> record(s) found</p>

        <div class="table-wrap">
            <table class="info-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Declared Qty</th>
                        <th>Actual Qty</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Collection Point</th>
                        <th>Status</th>
                        <th>Result</th>
                        <th>Checked By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row['dropoff_id'] ?></td>
                        <td><?= htmlspecialchars($row['item']) ?></td>
                        <td><?= (int)$row['quantity'] ?></td>
                        <td><?= $row['actual_quantity'] !== null ? (int)$row['actual_quantity'] : '-' ?></td>
                        <td><?= htmlspecialchars($row['dropoff_datetime']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['collectionpoint']) ?></td>
                        <td><?= $row['is_collected'] ? 'Collected' : 'Pending' ?></td>
                        <td>
                            <?php
                            if ($row['is_recyclable'] === null) {
                                echo 'Not checked';
                            } else {
                                echo $row['is_recyclable'] ? 'Recyclable' : 'Non-recyclable';
                            }
                            ?>
                        </td>
                        <td><?= $row['checked_by'] ? htmlspecialchars($row['checked_by']) : '-' ?></td>
                        <td>
                            <?php if (!$row['is_collected']): ?>
                                <a href="verify_collection.php?id=<?= (int)$row['dropoff_id'] ?>" class="text-link">Verify</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="11">No records found.</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </main>

    <script src="../assets/script.js"></script>
</body>
</html>

