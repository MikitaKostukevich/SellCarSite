<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    $imagePath = 'uploads/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], "../" . $imagePath);

    $conn->query("INSERT INTO news (title, content, image) VALUES ('$title', '$content', '$imagePath')");
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новость</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Добавить новость</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Заголовок" required>
            <textarea name="content" placeholder="Текст новости" required></textarea>
            <input type="file" name="image" required>
            <button type="submit">Добавить</button>
        </form>
    </div>
</body>
</html>
