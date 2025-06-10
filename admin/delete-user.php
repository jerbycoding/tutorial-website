<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '/laragon/www/tutorial-site/includes/db.php';

if (!isset($_GET['id'])) {
    die("❌ No user ID provided.");
}
$id = $_GET['id'];



$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage-users.php");
exit;
