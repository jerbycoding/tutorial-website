<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '/laragon/www/tutorial-site/includes/db.php';

// Step 1: Check ID
if (!isset($_GET['id'])) {
    die("❌ No user ID provided.");
}
$id = $_GET['id'];

// Step 2: Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();

    header("Location: manage-users.php");
    exit;
}

// Step 3: Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$user = $result->fetch_assoc()) {
    die("❌ User not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        form { background: #fff; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; box-shadow: 0 0 10px #ccc; }
        label, input { display: block; width: 100%; margin-bottom: 10px; }
        input[type="submit"], a.button {
            background: #28a745; color: white; padding: 10px; border: none;
            text-decoration: none; text-align: center; display: inline-block; border-radius: 5px;
        }
        a.button { background: #ccc; margin-top: 10px; }
    </style>
</head>
<body>
    <form method="post">
        <h2>✏️ Edit User</h2>
        <label>Username:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="submit" value="Update User">
        <a href="index.php" class="button">Cancel</a>
    </form>
</body>
</html>
