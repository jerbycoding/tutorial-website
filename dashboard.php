<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
<a href="logout.php">Logout</a>
<!-- bat ayaw?? -->