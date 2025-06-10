<?php
session_start();
require_once '/laragon/www/tutorial-site/includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: manage-tutorial.php");
            exit;
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; padding: 50px; text-align: center; }
        form { background: white; padding: 30px; display: inline-block; border-radius: 10px; box-shadow: 0 0 10px #aaa; }
        input { margin: 10px; padding: 10px; width: 200px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>🔐 Admin Login</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
