<?php
$host = "localhost"; // Хост
$user = "LAPTOP-7C3UR1FK\Никита"; // Учетная запись Windows
$password = ""; // Если у пользователя нет пароля
$dbname = "car_market"; // Имя базы данных

// Подключаемся с помощью Windows-авторизации
$conn = new mysqli($host, $user, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

echo "Подключение успешно!";
?>
