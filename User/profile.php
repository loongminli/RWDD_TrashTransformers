
<?php
include "../dbconn.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
$tab = $_GET['tab'] ?? 'account';
$message = "";

// Get user details
$result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id' AND is_active = 1");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: login.php");
    exit();
}

// Save account changes
if (isset($_POST['save_account'])) {
    $name = trim($_POST['fullname']);
    $nickname = trim($_POST['nickname']);
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];

    if ($name == "") {
        $message = "Please enter your full name.";
    } elseif (strlen($name) > 100 || strlen($nickname) > 50) {
        $message = "Name or nickname is too long.";
    } elseif (strlen($new) > 32) {
        $message = "Password cannot exceed 32 characters.";
    } elseif ($new != "" && $current != $user['password']) {
        $message = "Current password is incorrect.";
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $nickname = mysqli_real_escape_string($conn, $nickname);

        $sql = "UPDATE user SET username = '$name', nickname = '$nickname'";

        if ($new != "") {
            $new = mysqli_real_escape_string($conn, $new);
            $sql .= ", password = '$new'";
        }

        $sql .= " WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $sql)) {
            $message = "Changes saved successfully.";

            $result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
            $user = mysqli_fetch_assoc($result);
        } else {
            $message = "Could not save changes.";
        }
    }
}

// Reward values
$challenge = null;
$reward = null;
$progress = 0;
$claimed = 0;
$month = "";
$year = 0;
$summary = ['earned' => 0, 'used' => 0];
$vouchers = false;

if ($tab == 'rewards') {

    $result = mysqli_query($conn, "SELECT MONTHNAME(CURDATE()) AS month, YEAR(CURDATE()) AS year");
    $today = mysqli_fetch_assoc($result);

    $month = $today['month'];
    $year = $today['year'];

    // Current challenge
    $result = mysqli_query($conn, "SELECT * FROM challenge WHERE month = '$month' AND year = $year LIMIT 1");
    $challenge = mysqli_fetch_assoc($result);

    if ($challenge) {
        $challenge_id = (int)$challenge['challenge_id'];
        $material = mysqli_real_escape_string($conn, $challenge['material_required']);

        // Verified recycling progress
        $sql = "SELECT COALESCE(SUM(dc.actual_quantity), 0) AS total
                FROM dropoff d
                JOIN dropoff_check dc ON d.dropoff_id = dc.dropoff_id
                JOIN dropoff_recyclable dr ON d.dropoff_id = dr.dropoff_id
                WHERE d.user_id = '$user_id'
                AND d.is_collected = 1
                AND dc.is_recyclable = 1
                AND dr.material_type = '$material'
                AND MONTHNAME(d.dropoff_datetime) = '$month'
                AND YEAR(d.dropoff_datetime) = $year";

        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $progress = $data['total'];

        // Current reward
        $sql = "SELECT r.reward
                FROM reward r
                JOIN challenge_reward cr ON r.reward_id = cr.reward_id
                WHERE cr.challenge_id = $challenge_id
                LIMIT 1";

        $result = mysqli_query($conn, $sql);
        $reward = mysqli_fetch_assoc($result);

        // Check claim status
        $result = mysqli_query($conn,
            "SELECT is_claimed FROM user_challenge
             WHERE user_id = '$user_id' AND challenge_id = $challenge_id");

        $record = mysqli_fetch_assoc($result);

        if ($record) {
            $claimed = $record['is_claimed'];
        }

        // Claim reward
        if (isset($_POST['claim_reward']) &&
            $reward &&
            $progress >= $challenge['quota'] &&
            !$claimed) {

            $sql = "INSERT INTO user_challenge
                    (user_id, challenge_id, quantity_collected,
                     is_eligible_reward, is_claimed, is_used)
                    VALUES ('$user_id', $challenge_id, $progress, 1, 1, 0)
                    ON DUPLICATE KEY UPDATE
                    quantity_collected = $progress,
                    is_eligible_reward = 1,
                    is_claimed = 1";

            mysqli_query($conn, $sql);

            header("Location: profile.php?tab=rewards");
            exit();
        }
    }

    // Use voucher
    if (isset($_POST['use_reward'])) {
        $id = (int)$_POST['use_reward'];

        mysqli_query($conn,
            "UPDATE user_challenge
             SET is_used = 1
             WHERE user_id = '$user_id'
             AND challenge_id = $id
             AND is_claimed = 1
             AND is_used = 0");

        header("Location: profile.php?tab=rewards");
        exit();
    }

    // Reward summary
    $result = mysqli_query($conn,
        "SELECT COALESCE(SUM(is_claimed), 0) AS earned,
                COALESCE(SUM(is_used), 0) AS used
         FROM user_challenge
         WHERE user_id = '$user_id'");

    $summary = mysqli_fetch_assoc($result);

    // Unused vouchers
    $sql = "SELECT c.challenge_id, c.month, c.year, r.reward
            FROM user_challenge uc
            JOIN challenge c ON uc.challenge_id = c.challenge_id
            JOIN challenge_reward cr ON c.challenge_id = cr.challenge_id
            JOIN reward r ON cr.reward_id = r.reward_id
            WHERE uc.user_id = '$user_id'
            AND uc.is_claimed = 1
            AND uc.is_used = 0
            ORDER BY c.year DESC, c.challenge_id DESC";

    $vouchers = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Trash Transformers</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<nav class="navbar">
    <div class="logo">
        <a href="../index.php"> <img src="../logo.png" alt="Trash Transformers Logo"> </a>
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


<main class="profile-page">

<?php if ($tab != 'rewards'): ?>

    <div class="profile-card">
        <h2>MY ACCOUNT</h2>
        <p class="description">Manage your account information</p>

        <?php if ($message != ""): ?>
            <p class="message" id="save-message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form method="post" autocomplete="off">

            <label>TP Number</label>
            <input type="text"
                   value="<?php echo htmlspecialchars($user['user_id']); ?>"
                   disabled>

            <label>Full Name</label>
            <input type="text" name="fullname"
                   value="<?php echo htmlspecialchars($user['username']); ?>"
                   maxlength="100" required>

            <label>Nickname</label>
            <input type="text" name="nickname"
                   value="<?php echo htmlspecialchars($user['nickname'] ?? ''); ?>"
                   maxlength="50" autocomplete="off">

            <label>Account Created</label>
            <input type="text"
                   value="<?php echo htmlspecialchars($user['account_made']); ?>"
                   disabled>

            <h3>Change Password</h3>

            <label>Current Password</label>
            <input type="password" name="current_password"
                   value="" autocomplete="off"
                   placeholder="Enter current password">

            <label>New Password</label>
            <input type="password" name="new_password"
                   value="" autocomplete="new-password"
                   maxlength="32"
                   placeholder="Enter new password">

            <button type="submit" name="save_account" class="save-btn">
                Save Changes
            </button>

        </form>

     
<div class="logout-area">
    <button type="button" class="logout-btn" onclick="showLogout()">
        Log Out
    </button>
</div>

<div id="logout-popup" class="logout-overlay">
    <div class="logout-popup">
        <h3>Logout Confirmation</h3>
        <p>Are you sure you want to log out?</p>

        <div class="logout-actions">
            <a href="logout.php" class="confirm-btn">Confirm</a>
            <button type="button" class="cancel-btn" onclick="hideLogout()">
                Cancel
            </button>
        </div>
    </div>
</div>



<?php else: ?>

    <div class="rewards-card">
        <h2>MY REWARDS</h2>

        <h3>Current Reward</h3>

        <div class="current-reward">

            <?php if ($challenge && $reward): ?>

                <div class="voucher-top">
                    <span>TRASH TRANSFORMERS REWARDS</span>

                    <?php if ($progress >= $challenge['quota']): ?>
                        <img src="unlock.png" alt="Unlocked">
                    <?php else: ?>
                        <img src="lock.png" alt="Locked">
                    <?php endif; ?>
                </div>

                <div class="voucher-center">
                    <p>MONTHLY RECYCLING REWARD</p>
                    <h2><?php echo htmlspecialchars($reward['reward']); ?></h2>
                </div>

                <div class="voucher-bottom">

                    <div class="voucher-progress-text">
                        <span>
                            Recycle <?php echo $challenge['quota']; ?> kg of
                            <?php echo htmlspecialchars($challenge['material_required']); ?>
                        </span>

                        <span>
                            <?php echo $progress; ?> /
                            <?php echo $challenge['quota']; ?> kg
                        </span>
                    </div>
                    
                   
                    <div class="voucher-progress-track">
                        <div class="voucher-progress-fill"
                            style="width: <?php echo min(100, ($progress / max(1, $challenge['quota'])) * 100); ?>%;">
                        </div>
                    </div>

                    <p class="voucher-percentage">
                        <?php echo round(min(100, ($progress / max(1, $challenge['quota'])) * 100)); ?>%
                    </p>


                    <?php if ($claimed): ?>
                        <p class="voucher-status">Reward Claimed!</p>

                    <?php elseif ($progress >= $challenge['quota']): ?>
                        <p class="voucher-status">Your reward is unlocked!</p>

                        <form method="post">
                            <button type="submit" name="claim_reward" class="save-btn">
                                Claim Reward
                            </button>
                        </form>

                    <?php else: ?>
                        <p class="voucher-status">
                            Complete the challenge to unlock your reward!
                        </p>
                    <?php endif; ?>

                </div>

            <?php else: ?>
                <p>No reward available this month.</p>
            <?php endif; ?>

        </div>

        <h3>Reward Summary</h3>

        <div class="reward-summary">
            <div>
                <h2><?php echo $summary['earned']; ?></h2>
                <p>Rewards Earned</p>
            </div>

            <div>
                <h2><?php echo $summary['used']; ?></h2>
                <p>Rewards Used</p>
            </div>
        </div>

        <h3>My Vouchers</h3>

        <div class="voucher-grid">

            <?php if ($vouchers && mysqli_num_rows($vouchers) > 0): ?>

                <?php while ($voucher = mysqli_fetch_assoc($vouchers)): ?>

                    <div class="voucher">
                        <h3><?php echo htmlspecialchars($voucher['reward']); ?></h3>

                        <p>
                            Earned from
                            <?php echo htmlspecialchars($voucher['month']); ?>
                            <?php echo $voucher['year']; ?>
                            Recycling Challenge
                        </p>

                        <form method="post"
                              onsubmit="return confirm('Mark this voucher as used?')">

                            <button type="submit" name="use_reward"
                                    value="<?php echo $voucher['challenge_id']; ?>"
                                    class="save-btn">
                                Use Voucher
                            </button>
                        </form>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>
                <p class="empty-message">You have no unused vouchers.</p>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>

</main>

<script>
function toggleProfile() {
    document.querySelector('.profile-menu').classList.toggle('open');
}

setTimeout(function() {
    var message = document.getElementById('save-message');

    if (message) {
        message.style.display = 'none';
    }
}, 3000);


function showLogout() {
    document.getElementById('logout-popup').style.display = 'flex';
}

function hideLogout() {
    document.getElementById('logout-popup').style.display = 'none';
}

</script>

</body>
</html>
