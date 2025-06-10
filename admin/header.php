<!-- header.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding-top: 60px; background: #f0f0f0; }
        nav {
            background: #333;
            color: #fff;
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">🏠 Dashboard</a>
        <a href="manage-tutorial.php">📚 Manage Tutorials</a>
        <a href="manage-users.php">👥 Manage Users</a>
        <a href="logout.php" onclick="return confirm('Logout?')">🚪 Logout</a>
    </nav>

</body>
</html>
