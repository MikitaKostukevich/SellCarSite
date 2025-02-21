<?php
require 'db.php'; // Подключаем базу данных

$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
    <link rel="stylesheet" href="css/news.css">
</head>
<body>
    <div class="container">
        <h1>Новости</h1>
        <div class="news-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="news-card">
                    <img src="uploads/<?= $row['image'] ?>" alt="<?= $row['title'] ?>">
                    <h2><?= $row['title'] ?></h2>
                    <p><?= mb_strimwidth(strip_tags($row['content']), 0, 100, "...") ?></p>
                    <a href="news-details.php?id=<?= $row['id'] ?>" class="btn">Читать далее</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script src="js/news.js"></script>
</body>
</html>
