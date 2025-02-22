<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';
$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Управление новостями</h1>
        <a href="add-news.php" class="btn">Добавить новость</a>
        <a href="edit-news.php?id=<?= $row['id'] ?>" class="btn">Редактировать</a>
        <a href="delete-news.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить новость?')">Удалить</a>

        <div class="news-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="news-card">
                    <h2><?= $row['title'] ?></h2>
                    <a href="edit-news.php?id=<?= $row['id'] ?>" class="btn">Редактировать</a>
                    <a href="delete-news.php?id=<?= $row['id'] ?>" class="btn btn-danger">Удалить</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
