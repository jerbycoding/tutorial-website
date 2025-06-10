<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '/laragon/www/tutorial-site/includes/db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    // Simple validation
    if ($title && $slug && $content) {
        $stmt = $conn->prepare("INSERT INTO tutorials (title, slug, category, content) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $slug, $category, $content);
        if ($stmt->execute()) {
            $success = "✅ Tutorial added successfully!";
        } else {
            $error = "❌ Failed to add tutorial. Slug might already exist.";
        }
    } else {
        $error = "❌ Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Tutorial</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 40px; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; }
        input[type=submit] { background: #007BFF; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background: #0056b3; }
        a{text-decoration: none; color: white; background-color: grey; width: 100%; display: block; text-align: center; padding:  3px 0px; }
        a:hover{ background-color: #f0f0f0; color:black;}
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Add New Tutorial</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <label>Title</label>
        <input type="text" name="title" required>

        <label>Slug (URL name, like php-variables)</label>
        <input type="text" name="slug" required>

        <label>Category (Optional)</label>
        <input type="text" name="category">

        <label>Content (HTML Allowed)</label>

        <textarea name="content" rows="10" required></textarea>

        <input type="submit" value="Update Tutorial"><a href="manage-tutorial.php">Cancel</a>
    </form>
</body>
</html>
