<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '/laragon/www/tutorial-site/includes/db.php';

$success = "";
$error = "";

// Check if slug is provided
if (!isset($_GET['slug'])) {
    die("❌ No tutorial selected to edit.");
}

$slug = $_GET['slug'];

// Fetch existing tutorial
$stmt = $conn->prepare("SELECT * FROM tutorials WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    die("❌ Tutorial not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $newSlug = $_POST['slug'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    if ($title && $newSlug && $content) {
        $updateStmt = $conn->prepare("UPDATE tutorials SET title=?, slug=?, category=?, content=? WHERE slug=?");
        $updateStmt->bind_param("sssss", $title, $newSlug, $category, $content, $slug);
        if ($updateStmt->execute()) {
            $success = "✅ Tutorial updated successfully!";
            $slug = $newSlug; // Update current slug if changed
 
        } else {
            $error = "❌ Failed to update tutorial.";
        }
    } else {
        $error = "❌ All required fields must be filled.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tutorial</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 40px; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
        input[type=submit] { background: #28a745; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background: #218838; }
        a{text-decoration: none; color: white; background-color: grey; width: 100%; display: block; text-align: center; padding:  3px 0px; }
        a:hover{ background-color: #f0f0f0; color:black;}
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Edit Tutorial</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>

        <label>Slug</label>
        <input type="text" name="slug" value="<?= htmlspecialchars($row['slug']) ?>" required>

        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($row['category']) ?>">

        <label>Content</label>
        <textarea name="content" rows="10" required><?= htmlspecialchars($row['content']) ?></textarea>

        <input type="submit" value="Update Tutorial"><a href="index.php">Cancel</a>
    </form>
</body>
</html>
