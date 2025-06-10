<?php
// tutorial.php

    require_once '/laragon/www/tutorial-site/includes/db.php';

// 🔒 Basic check
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    // ✅ Fetch tutorial
    $stmt = $conn->prepare("SELECT * FROM tutorials WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    // ✅ If found, show it
    if ($row = $result->fetch_assoc()) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?= htmlspecialchars($row['title']) ?></title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
                h1 { color: #333; }
                pre {
                    background: #222;
                    color: #0f0;
                    padding: 10px;
                    border-radius: 5px;
                    overflow-x: auto;
                }
                code { font-family: monospace; }
                .content { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                .title-and-nav{display:flex;}
            </style>
        </head>
        <body>
            <div class="content">
                <div class="title-and-nav">
                    <h1><?= htmlspecialchars($row['title']) ?></h1>
                </div>
          
                <?= $row['content'] ?>

            </div>
        </body>
        </html>
        <?php
    } else {
        echo "❌ Tutorial not found.";
    }
} else {
    echo "❌ No slug provided.";
}
?>
