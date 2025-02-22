<?php
session_start();
include 'db.php';

// Проверяем авторизацию
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Проверяем, передан ли ID новости
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: news.php");
    exit();
}

$news_id = $_GET['id'];

// Получаем данные новости из базы
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $news_id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    header("Location: news.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = $news['image']; // Сохраняем старый путь к изображению

    if (!empty($title) && !empty($content)) {
        // Если загружено новое изображение
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = 'uploads/news/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $uploadDir . $imageName;
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    // Удаляем старое изображение, если оно есть
                    if (!empty($news['image']) && file_exists($news['image'])) {
                        unlink($news['image']);
                    }
                    $imagePath = $targetFilePath;
                } else {
                    $error = "Ошибка загрузки изображения.";
                }
            } else {
                $error = "Разрешены только JPG, JPEG, PNG и GIF.";
            }
        }

        // Обновляем новость в БД
        if (!isset($error)) {
            $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $content, $imagePath, $news_id);
            if ($stmt->execute()) {
                header("Location: news.php");
                exit();
            } else {
                $error = "Ошибка при редактировании новости.";
            }
        }
    } else {
        $error = "Заполните все поля!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать новость</title>
    <link rel="stylesheet" href="css/edit_news.css">
</head>
<body>
    <div class="container">
        <h2>Редактировать новость</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form action="edit-news.php?id=<?= $news_id ?>" method="post" enctype="multipart/form-data">
            <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" required>
            <textarea name="content" required><?= htmlspecialchars($news['content']) ?></textarea>

            <div class="upload-area" id="upload-area">
                <p>Перетащите изображение сюда или <span>выберите файл</span></p>
                <input type="file" name="image" id="image-input" accept="image/*">
                <img id="preview-image" src="<?= $news['image'] ?: '#' ?>" alt="Предпросмотр" 
                     style="<?= empty($news['image']) ? 'display: none;' : 'display: block;' ?>">
            </div>

            <button type="submit" class="btn">Сохранить</button>
        </form>
        <a href="news.php" class="btn btn-back">Назад</a>
    </div>

    <script src="js/edit-news.js"></script>
</body>
</html>
