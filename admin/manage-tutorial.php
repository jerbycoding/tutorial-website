<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '/laragon/www/tutorial-site/includes/db.php';

$result = $conn->query("SELECT id, title, slug, category FROM tutorials ORDER BY id DESC");
$where = [];
$params = [];
$types = "";

// Search filter
if (!empty($_GET['search'])) {
    $where[] = "(title LIKE ? OR slug LIKE ?)";
    $params[] = "%" . $_GET['search'] . "%";
    $params[] = "%" . $_GET['search'] . "%";
    $types .= "ss";
}

// Category filter
if (!empty($_GET['category'])) {
    $where[] = "category = ?";
    $params[] = $_GET['category'];
    $types .= "s";
}

$sql = "SELECT * FROM tutorials";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
    <title>Manage Tutorials</title>
    <style>
        body { font-family: Arial; background: #f0f0f0;  margin: 0px 10px }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 10px #ccc; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        a.btn { padding: 6px 10px; text-decoration: none; border-radius: 4px; }
        .view {background-color:  greenyellow; color: white;}
        .edit { background: #007bff; color: white; }
        .delete { background: #dc3545; color: white; }
        .add { background: green; color: white; margin-bottom: 15px; display: inline-block; }
    </style>
</head>
<body>
    <h2>🛠️ Manage Tutorials</h2>
    <div style="display: flex; justify-content: space-between; ">
        <a class="btn add" href="add-tutorial.php">➕ Add New Tutorial</a>

    </div>
    <form method="GET" style="margin-bottom: 20px;" action="manage-tutorial.php">
    <input type="text" name="search" placeholder=" Search title or slug" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />

    <select name="category">
        <option value=""> All Categories</option>
        <option value="html" <?= ($_GET['category'] ?? '') == 'html' ? 'selected' : '' ?>>HTML</option>
        <option value="css" <?= ($_GET['category'] ?? '') == 'css' ? 'selected' : '' ?>>CSS</option>
        <option value="php" <?= ($_GET['category'] ?? '') == 'php' ? 'selected' : '' ?>>PHP</option>

    </select>

    <button type="submit">Filter</button>
</form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['slug']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>
                    <a class="btn view" href="view-tutorial.php?slug=<?= urlencode($row['slug']) ?>" target="_blank"> View</a>
                    <a class="btn edit" href="edit-tutorial.php?slug=<?= urlencode($row['slug']) ?>">Edit</a>
                    <a class="btn delete" href="delete-tutorial.php?slug=<?= urlencode($row['slug']) ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
