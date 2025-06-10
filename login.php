<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashedPassword);
        $stmt->fetch();
        
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found.";
    }
}
?>

<h2>Login</h2>
<form method="post">
    Email: <input name="email" type="email" required><br>
    Password: <input name="password" type="password" required><br>
    <button type="submit">Login</button>
</form>
