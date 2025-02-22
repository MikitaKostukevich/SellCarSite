<?php
session_start();
include 'db.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: news.php");
        exit();
    } else {
        echo "Ошибка при удалении";
    }
} else {
    header("Location: news.php");
}
?>
