<?php
require_once __DIR__ . '/../dbconn.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = mysqli_real_escape_string($conn, $_SESSION['id']);

$sql = "SELECT d.dropoff_datetime, d.item, d.quantity,
               d.is_collected, c.collectionpoint
        FROM dropoff d
        JOIN collectionpoint c
        ON d.collectionpoint_id = c.collectionpoint_id
        WHERE d.user_id = '$user_id'
        ORDER BY d.dropoff_datetime DESC, d.dropoff_id DESC";

$dropoffs_result = mysqli_query($conn, $sql);


$sql = "SELECT c.*, COALESCE(uc.quantity_collected, 0) AS progress
        FROM challenge c
        LEFT JOIN user_challenge uc
            ON c.challenge_id = uc.challenge_id
            AND uc.user_id = '$user_id'
        WHERE c.year < YEAR(CURDATE())
           OR (c.year = YEAR(CURDATE())
               AND FIELD(c.month, 'January', 'February', 'March',
                         'April', 'May', 'June', 'July', 'August',
                         'September', 'October', 'November', 'December')
                   < MONTH(CURDATE()))
        ORDER BY c.year DESC,
                 FIELD(c.month, 'January', 'February', 'March',
                       'April', 'May', 'June', 'July', 'August',
                       'September', 'October', 'November', 'December') DESC
        LIMIT 12";

$challenge_result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Drop-offs - Trash Transformers</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mydropoffs.css">
    <link rel="stylesheet" href="mobile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="logo">
    <a href="../index.php">
        <img src="../logo.png" alt="Trash Transformers Logo">
    </a>
    <span>Trash Transformers</span>
</div>

     <ul>
        <li><a href="user.php">Home</a></li>
        <li><a href="createdropoff.php">Create Drop-off</a></li>
        <li><a href="mydropoffs.php">My Drop-offs</a></li>
        <li class="profile-menu">
            <button type="button" class="profile-button" onclick="toggleProfile()">Profile ▾</button>
            <ul class="profile-dropdown">
                <li><a href="profile.php?tab=myaccount">My Account</a></li>
                <li><a href="profile.php?tab=rewards">Rewards</a></li>
            </ul>
        </li>
    </ul>
</nav>


<main class="mydropoffs-page">

    <section class="dropoffs-history">
        <h2>MY DROP-OFFS</h2>

        <div class="table-container">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Material Type</th>
                        <th>Quantity</th>
                        <th>Collection Point</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($dropoffs_result) > 0): ?>
                        <?php while ($dropoff = mysqli_fetch_assoc($dropoffs_result)): ?>
                            <tr>
                                <td><?php echo date("d M Y", strtotime($dropoff['dropoff_datetime'])); ?></td>
                                <td><?php echo htmlspecialchars($dropoff['item']); ?></td>
                                <td><?php echo htmlspecialchars($dropoff['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($dropoff['collectionpoint']); ?></td>
                                <td><?php echo $dropoff['is_collected'] == 1 ? "Collected" : "Pending"; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No drop-offs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="challenge-history">
        <h2>CHALLENGE HISTORY</h2>

        <div class="table-container">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Challenge</th>
                        <th>Progress</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($challenge_result) > 0): ?>
                        <?php while ($challenge = mysqli_fetch_assoc($challenge_result)): ?>

                            <?php
                            $progress = $challenge['progress'];
                            ?>

                            <tr>
                                <td><?php echo htmlspecialchars($challenge['month'] . " " . $challenge['year']); ?></td>

                                <td>
                                    Recycle <?php echo htmlspecialchars($challenge['material_required']); ?>
                                </td>

                                <td>
                                    <?php echo $progress; ?> /
                                    <?php echo htmlspecialchars($challenge['quota']); ?>
                                </td>

                                <td>
                                    <?php
                                    if ($progress >= $challenge['quota']) {
                                        echo "Completed";
                                    } else {
                                        echo "Uncompleted";
                                    }
                                    ?>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No previous challenges found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

<script>
function toggleProfile() {
    document.querySelector('.profile-menu').classList.toggle('open');
}
</script>

</body>
</html>
