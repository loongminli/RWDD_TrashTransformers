
<?php
require_once 'db_connect.php';

$result = $conn->query("SELECT user_id, username FROM `user`");

while ($row = $result->fetch_assoc()) {
    echo htmlspecialchars($row['user_id']);
    echo " - ";
    echo htmlspecialchars($row['username']);
    echo "<br>";
}
?>

