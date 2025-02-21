<?php
require 'db.php';
$id = $_GET['id'] ?? 0;
$result = $conn->query("SELECT * FROM news WHERE id = $id");
$news = $result->fetch_assoc();

if (!$news) {
    die("Новость не найдена!");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $news['title'] ?></title>
    <link rel="stylesheet" href="css/news.css">
</head>
<body>
    <div class="container">
        <h1><?= $news['title'] ?></h1>
        <img src="uploads/<?= $news['image'] ?>" alt="<?= $news['title'] ?>">
        <p><?= nl2br($news['content']) ?></p>
        <a href="news.php" class="btn">Назад к новостям</a>
    </div>
</body>
</html>
