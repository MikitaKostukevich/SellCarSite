<?php
session_start();
include 'db.php';

// Получение списка новостей
$sql = "SELECT * FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
    <link rel="stylesheet" href="css/news.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
    <header>
        <h1>Новости</h1>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="logout.php">Выйти (<?= htmlspecialchars($_SESSION['user']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Войти</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="add-news.php" class="btn add-btn">Добавить новость</a>
        <?php endif; ?>

        <section class="news-list">
            <?php while ($news = $result->fetch_assoc()): ?>
                <div class="news-card">
                    <h2><?= htmlspecialchars($news['title']); ?></h2>
                    <p class="news-date"><?= date('d.m.Y H:i', strtotime($news['created_at'])); ?></p>
                    <p><?= nl2br(htmlspecialchars(mb_strimwidth($news['content'], 0, 150, '...'))); ?></p>
                    <a href="news-details.php?id=<?= $news['id']; ?>" class="btn">Читать далее</a>

                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="edit-news.php?id=<?= $news['id']; ?>" class="btn edit-btn">Редактировать</a>
                        <a href="delete-news.php?id=<?= $news['id']; ?>" 
                           onclick="return confirm('Вы уверены, что хотите удалить эту новость?');" 
                           class="btn delete-btn">Удалить</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </section>
    </main>

    <script src="js/news.js"></script>
</body>
</html>
