<?php
session_start();
include 'db.php';

// Проверяем, передан ли ID новости
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: news.php");
    exit();
}

$news_id = $_GET['id'];

// Получаем новость из базы
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $news_id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    header("Location: news.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news['title']) ?></title>
    <link rel="stylesheet" href="css/news_detail.css">
</head>
<body>
    <div class="container">
        <article class="news-detail">
            <h1><?= htmlspecialchars($news['title']) ?></h1>
            <p class="news-date">Дата публикации: <?= date('d.m.Y H:i', strtotime($news['created_at'])) ?></p>

            <?php if (!empty($news['image'])): ?>
                <img src="<?= htmlspecialchars($news['image']) ?>" alt="Изображение новости" class="news-image">
            <?php endif; ?>

            <p class="news-content"><?= nl2br(htmlspecialchars($news['content'])) ?></p>

            <a href="news.php" class="btn">Назад к новостям</a>
        </article>
    </div>

    <script src="js/news-detail.js"></script>
</body>
</html>
