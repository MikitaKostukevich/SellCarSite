<?php
session_start();
include 'db.php';

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Проверка наличия заголовка и текста
    if (!empty($title) && !empty($content)) {
        $imagePath = null;

        // Проверка загрузки изображения
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
                    $imagePath = $targetFilePath;
                } else {
                    $error = "Ошибка загрузки изображения.";
                }
            } else {
                $error = "Разрешены только JPG, JPEG, PNG и GIF.";
            }
        }

        // Если загрузка изображения успешна или оно не было загружено
        if (!isset($error)) {
            $stmt = $conn->prepare("INSERT INTO news (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $title, $content, $imagePath);
            if ($stmt->execute()) {
                header("Location: news.php");
                exit();
            } else {
                $error = "Ошибка при добавлении новости.";
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
    <title>Добавить новость</title>
    <link rel="stylesheet" href="css/add_news.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <!-- Подключаем шрифт (если ещё не подключен) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h2>Добавить новость</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form action="add-news.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Заголовок" required>
            <textarea name="content" placeholder="Текст новости" required></textarea>

            <div class="upload-area" id="upload-area">
                <p>Перетащите изображение сюда или <span>выберите файл</span></p>
                <input type="file" name="image" id="image-input" accept="image/*">
                <img id="preview-image" src="#" alt="Предпросмотр" style="display: none;">
            </div>

            <button type="submit" class="btn">Добавить</button>
        </form>
        <a href="news.php" class="btn btn-back">Назад</a>
    </div>

    <script src="js/add-news.js"></script>
</body>
</html>
