<?php
require_once 'includes/db.php';
session_start();

// Fetch all tutorials
$result = $conn->query("SELECT * FROM tutorials ORDER BY category ASC, created_at DESC");

$tutorialsByCategory = [];

// Group tutorials by category
while ($row = $result->fetch_assoc()) {
    $category = $row['category'];
    $tutorialsByCategory[$category][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Tutorials</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; margin: 0; padding: 0; }
        .navbar {
            background: #333; color: #fff; padding: 15px;
        }
        .navbar a {
            color: #fff; margin-right: 15px; text-decoration: none;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }
        .category {
            margin-top: 30px;
        }
        .category h2 {
            color: #444;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .tutorial-link {
            display: block;
            padding: 8px;
            margin: 5px 0;
            background: #eee;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: 0.2s;
        }
        .tutorial-link:hover {
            background: #ddd;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="home.php">🏠 Home</a>
    <a href="tutorials.php">📚 Tutorials</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="profile.php">👤 Profile</a>
        <a href="logout.php">🚪 Logout</a>
    <?php else: ?>
        <a href="register.php">🔐 Register</a>
        <a href="login.php">🔑 Login</a>
    <?php endif; ?>
</div>

<div class="container">
    <h1>📘 Tutorials by Category</h1>

    <?php foreach ($tutorialsByCategory as $category => $tutorials): ?>
        <div class="category">
            <h2>📂 <?= htmlspecialchars($category) ?></h2>
            <?php foreach ($tutorials as $tutorial): ?>
                <a class="tutorial-link" href="tutorial.php?slug=<?= urlencode($tutorial['slug']) ?>">
                    <?= htmlspecialchars($tutorial['title']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
