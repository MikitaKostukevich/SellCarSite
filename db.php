<?php
$host = "localhost"; 
$user = "LAPTOP-7C3UR1FK\Никита"; 
$password = "";
$dbname = "car_market";


$conn = new mysqli($host, $user, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

echo "Подключение успешно!";
?>
