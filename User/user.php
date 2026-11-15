<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$tp = mysqli_real_escape_string($conn, $_SESSION['user_id']);

$result = mysqli_query($conn, "SELECT username, nickname FROM user WHERE user_id = '$tp' AND is_active = 1");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: logout.php");
    exit();
}

// Current month's challenge
$month = date("F");
$year = date("Y");

$sql = "SELECT * FROM challenge
        WHERE month = '$month' AND year = '$year'
        LIMIT 1";
$result = mysqli_query($conn, $sql);
$challenge = mysqli_fetch_assoc($result);

$progress = 0;
$percentage = 0;
$unlocked = false;
$claimed = 0;
$current_reward = null;
$challenge_id = 0;

if ($challenge) {
    $challenge_id = (int)$challenge['challenge_id'];
    $material = mysqli_real_escape_string($conn, $challenge['material_required']);

    // Student's verified recycling progress
    $sql = "SELECT COALESCE(SUM(dc.actual_quantity), 0) AS total
            FROM dropoff d
            JOIN dropoff_check dc ON d.dropoff_id = dc.dropoff_id
            JOIN dropoff_recyclable dr ON d.dropoff_id = dr.dropoff_id
            WHERE d.user_id = '$tp'
            AND d.is_collected = 1
            AND dc.is_recyclable = 1
            AND dr.material_type = '$material'
            AND MONTH(d.dropoff_datetime) = MONTH(CURDATE())
            AND YEAR(d.dropoff_datetime) = YEAR(CURDATE())";

    $result = mysqli_query($conn, $sql);
    $progress_data = mysqli_fetch_assoc($result);
    $progress = (float)$progress_data['total'];

    if ($challenge['quota'] > 0) {
        $percentage = min(100, ($progress / $challenge['quota']) * 100);
        $unlocked = $progress >= $challenge['quota'];
    }

    // Reward linked to this month's challenge
    $sql = "SELECT r.reward FROM reward r
            JOIN challenge_reward cr ON r.reward_id = cr.reward_id
            WHERE cr.challenge_id = $challenge_id
            LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $current_reward = mysqli_fetch_assoc($result);

    // Check if the student has claimed this reward
$sql = "SELECT is_claimed
        FROM user_challenge
        WHERE user_id = '$tp'
        AND challenge_id = $challenge_id";

$result = mysqli_query($conn, $sql);
$reward_record = mysqli_fetch_assoc($result);

if ($reward_record) {
    $claimed = $reward_record['is_claimed'];
}

}

// Collection points
$points_result = mysqli_query($conn,
    "SELECT collectionpoint, is_active FROM collectionpoint ORDER BY collectionpoint_id"
);

// Recent drop-offs
$sql = "SELECT d.dropoff_datetime, d.item, d.quantity,
               d.is_collected, c.collectionpoint
        FROM dropoff d
        JOIN collectionpoint c ON d.collectionpoint_id = c.collectionpoint_id
        WHERE d.user_id = '$tp'
        AND d.dropoff_datetime BETWEEN NOW() - INTERVAL 5 DAY AND NOW()
        ORDER BY d.dropoff_datetime DESC, d.dropoff_id DESC
        LIMIT 5";

$recent_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Trash Transformers</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<nav class="navbar">
    <div class="logo">
    <img src="logo.jpeg" alt="Trash Transformers Logo">
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

<main>

  
<section class="welcome">
    <h2>Welcome Back, <?php echo htmlspecialchars(!empty($user['nickname']) ? $user['nickname'] : $user['username']); ?>!</h2>
</section>

<section class="dashboard">

    <!-- Monthly Challenge -->
    <div class="challenge">
        <h3>Monthly Recycling Challenge</h3>

        <?php if ($challenge): ?>

            <h2 class="challenge-title">
                <?php echo htmlspecialchars($month); ?> Recycling Challenge
            </h2>

            <div class="challenge-info">
                <div class="challenge-info-box">
                    <span>MATERIAL</span>
                    <h4><?php echo htmlspecialchars($challenge['material_required']); ?></h4>
                </div>

                <div class="challenge-info-box">
                    <span>TARGET</span>
                    <h4><?php echo $challenge['quota']; ?> kg</h4>
                </div>
            </div>

            
            <div class="progress">
                <h4>Your Progress</h4>

                <p><?php echo $progress; ?> / <?php echo $challenge['quota']; ?> kg</p>

                <div class="progress-track">
                    <div class="progress-fill"
                        style="width: <?php echo $percentage; ?>%;">
                    </div>
                </div>

                <p><?php echo round($percentage); ?>%</p>

                <?php if ($unlocked): ?>
                    <p>Challenge Completed!</p>
                <?php else: ?>
                    <p>Challenge In Progress</p>
                                <?php endif; ?>
                </div>

            <?php else: ?>
                <p>No challenge available this month.</p>
            <?php endif; ?>

            </div>

            <!-- Reward -->
            <div class="reward">
            <h3>Reward</h3>

            <?php if ($current_reward): ?>
                <div class="voucher-card">

                    <div class="voucher-header">
                        <span>TRASH TRANSFORMERS REWARDS</span>

                        <span class="voucher-lock">
                            <?php if ($unlocked): ?>
                                <img src="unlock.png" alt="Unlocked">
                            <?php else: ?>
                                <img src="lock.png" alt="Locked">
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="voucher-details">
                        <p>MONTHLY RECYCLING REWARD</p>
                        <h2><?php echo htmlspecialchars($current_reward['reward']); ?></h2>
                    </div>

                    <div class="voucher-progress">
                        <p>Recycle <?php echo $challenge['quota']; ?> kg of <?php echo htmlspecialchars($challenge['material_required']); ?></p>
                        <p><?php echo $progress; ?> / <?php echo $challenge['quota']; ?> kg</p>
                    </div>

                    <div class="voucher-progress-track">
                        <div class="voucher-progress-fill" style="width: <?php echo $percentage; ?>%;"></div>
                    </div>

                        <p class="voucher-percentage">
                            <?php echo round($percentage); ?>%
                        </p>

                  
                <?php if ($claimed): ?>
                    <p class="voucher-status">Reward Claimed!</p>

                <?php elseif ($unlocked): ?>
                    <p class="voucher-status">Reward Unlocked!</p>

                    
                <form action="profile.php?tab=rewards" method="POST">
                    <input type="hidden" name="challenge_id" value="<?php echo $challenge_id; ?>">
                    <button type="submit" name="claim_reward" class="claim-button">
                        Claim Reward
                    </button>
                    </form>


                    <?php else: ?>
                        <p class="voucher-status">Complete the challenge to unlock your reward!</p>
                    <?php endif; ?>

                    </div>
                    <?php else: ?>
                    <div class="no-reward">
                    <p>No rewards available this month.</p>
                </div>
            <?php endif; ?>
        </div>

    </section>

    <div class="dashboard-bottom">

        <!-- Collection Points -->
        <section class="collection">
            <h3>Available Collection Points</h3>

            <div id="collection-points">
                <?php while ($point = mysqli_fetch_assoc($points_result)): ?>
                    <div class="point-card">
                        <img src="location.jpeg" alt="Location" class="location-icon">

                        <div class="point-info">
                            <strong><?php echo htmlspecialchars($point['collectionpoint']); ?></strong>

                            <?php if ($point['is_active'] == 1): ?>
                                <small class="point-available">
                                    <span class="status-dot"></span>Available
                                </small>
                            <?php else: ?>
                                <small class="point-unavailable">
                                    <span class="status-dot"></span>Unavailable
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- Recent Drop-offs -->
        <section class="dropoff-section">
            <h3>Recent Drop-offs</h3>

            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Material</th>
                            <th>Quantity</th>
                            <th>Collection Point</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (mysqli_num_rows($recent_result) > 0): ?>

                            <?php while ($dropoff = mysqli_fetch_assoc($recent_result)): ?>
                                <tr>
                                    <td><?php echo date("d M Y", strtotime($dropoff['dropoff_datetime'])); ?></td>
                                    <td><?php echo htmlspecialchars($dropoff['item']); ?></td>
                                    <td><?php echo htmlspecialchars($dropoff['quantity']); ?> kg</td>
                                    <td><?php echo htmlspecialchars($dropoff['collectionpoint']); ?></td>
                                    <td>
                                        <?php if ($dropoff['is_collected'] == 1): ?>
                                            Collected
                                        <?php else: ?>
                                            Pending
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="5">No drop-offs in the last 5 days.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <a href="mydropoffs.php">View All Drop-offs</a>
        </section>

    </div>

</main>

<script>
function toggleProfile() {
    document.querySelector('.profile-menu').classList.toggle('open');
}
</script>

</body>
</html>