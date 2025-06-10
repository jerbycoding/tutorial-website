<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once '/laragon/www/tutorial-site/includes/db.php';

$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
    <title>Manage Users</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #eee; }
        a { color: #007bff; text-decoration: none; margin: 0 5px; }
        .container { background: #fff; padding: 20px; border-radius: 10px;  }
    </style>
</head>
<body>
    <div class="container">
        <h2>👤 Manage Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="edit-user.php?id=<?= $row['id'] ?>">Edit</a> |
                        <a href="delete-user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
