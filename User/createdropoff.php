
<?php
include "../dbconn.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";

if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = trim($_POST['material'] ?? '');
    $quantity = filter_var($_POST['quantity'] ?? '', FILTER_VALIDATE_INT);
    $collectionpoint_id = filter_var($_POST['collection_point'] ?? '', FILTER_VALIDATE_INT);
    $user_id = $_SESSION['id'];

    if ($item == "" || strlen($item) > 50 ||
        $quantity === false || $quantity < 1 || $quantity > 20 ||
        $collectionpoint_id === false || $collectionpoint_id < 1) {
        $error = "Please enter valid drop-off details.";
    } else {
        $sql = "SELECT collectionpoint_id FROM collectionpoint
                WHERE collectionpoint_id = ? AND is_active = 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $collectionpoint_id);
        $stmt->execute();
        $point = $stmt->get_result()->fetch_assoc();

        if (!$point) {
            $error = "Please select an available collection point.";
        } else {
            $sql = "INSERT INTO dropoff
                    (item, quantity, dropoff_datetime, user_id,
                     collectionpoint_id, is_collected)
                    VALUES (?, ?, NOW(), ?, ?, 0)";

            $challengenow_result = mysqli_query($conn, "
                    SELECT challenge_id FROM challenge
                    WHERE month = MONTHNAME(NOW());
            ");
            $challengenow = mysqli_fetch_row($challengenow_result)[0];

            $challengecheck = mysqli_query($conn, "
                SELECT * FROM user_challenge
                WHERE user_id = '$user_id' AND challenge_id in
                (
                    SELECT challenge_id FROM challenge
                    WHERE month = MONTHNAME(NOW())
                );
            ");

            if (mysqli_num_rows($challengecheck) == 0) {
                $insertchallengerecord = mysqli_query($conn, "
                    INSERT INTO user_challenge (user_id, challenge_id, quantity_collected)
                    VALUES
                    ('$user_id', '$challengenow', 0);
                ");
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisi", $item, $quantity, $user_id, $collectionpoint_id);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Drop-off submitted successfully!";
                header("Location: createdropoff.php");
                exit();
            } else {
                $error = "Could not save the drop-off.";
            } 
        }
    }
}

$sql = "SELECT collectionpoint_id, collectionpoint, is_active
        FROM collectionpoint
        ORDER BY collectionpoint_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Drop-off - Trash Transformers</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="create.css">

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


<main>
    <section class="dropoff-form">
        <h2>Create Drop-off</h2>

        <?php if ($message != ""): ?>
            <div class="popup-message success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error != ""): ?>
            <div class="popup-message error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <p class="form-description">Submit your recyclable materials</p>

        <form action="createdropoff.php" method="POST">
            <div class="form-group">

                <label for="material">Item</label>
                <input type="text" id="material" name="material"
                       placeholder="Enter Item" maxlength="50" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity"
                       min="1" max="20" step="1"
                       placeholder="Enter Quantity" required>

                <label for="collection-point">Collection Point</label>
                <select id="collection-point" name="collection_point" required>
                    <option value="">Choose a Collection Point</option>

                    <?php while ($point = mysqli_fetch_assoc($result)): ?>
    <option value="<?php echo $point['collectionpoint_id']; ?>"
        <?php if ($point['is_active'] == 0) echo 'disabled'; ?>>
        <?php echo htmlspecialchars($point['collectionpoint']); ?>
        <?php if ($point['is_active'] == 0) echo ' (Unavailable)'; ?>
    </option>
<?php endwhile; ?>

                </select>

                <button type="submit">Submit</button>
            </div>
        </form>
    </section>

    <img src="snoopy.png" alt="Snoopy holding a plant" class="snoopy-image">
</main>

<script>
function toggleProfile() {
    document.querySelector('.profile-menu').classList.toggle('open');
}
</script>

</body>
</html>
