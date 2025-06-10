<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '/laragon/www/tutorial-site/includes/db.php';

$success = "";
$error = "";

// Make sure a slug is provided
if (!isset($_GET['slug'])) {
    die("❌ No tutorial specified for deletion.");
}

$slug = $_GET['slug'];

// Optional: Confirm deletion via URL param
if (isset($_GET['confirm']) && $_GET['confirm'] === "yes") {
    $stmt = $conn->prepare("DELETE FROM tutorials WHERE slug = ?");
    $stmt->bind_param("s", $slug);

    if ($stmt->execute()) {
        $success = "✅ Tutorial deleted successfully.";
    } else {
        $error = "❌ Failed to delete tutorial.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Tutorial</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fefefe; padding: 40px; text-align: center; }
        .message { font-size: 18px; margin: 20px; }
        a.button {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px;
            display: inline-block;
        }
        a.button:hover { background: #c82333; }
        a.cancel {
            background: #6c757d;
        }
    </style>
</head>
<body>
    <?php if ($success): ?>
        <p class="message"><?= $success ?></p>
        <a href="index.php">🔙 Back to tutorials</a>
    <?php elseif ($error): ?>
        <p class="message"><?= $error ?></p>
    <?php else: ?>
        <h2>⚠️ Are you sure you want to delete this tutorial?</h2>
        <a class="button" href="?slug=<?= urlencode($slug) ?>&confirm=yes">Yes, delete it</a>
        <a class="button cancel" href="index.php">Cancel</a>
    <?php endif; ?>
</body>
</html>
