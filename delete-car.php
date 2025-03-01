<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

$user = $_SESSION['user'];
$result = $conn->query("SELECT * FROM cars WHERE id = $id");
$car = $result->fetch_assoc();

if ($car['user'] != $user) {
    echo "Вы не можете удалить это объявление.";
    exit();
}


if ($conn->query("DELETE FROM cars WHERE id = $id")) {
    $message = "Объявление успешно удалено.";
    $messageType = "success";
    header("refresh:3; url=index.php"); 
} else {
    $message = "Ошибка при удалении объявления.";
    $messageType = "error";
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удаление объявления</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <!-- Подключаем шрифт (если ещё не подключен) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <div class="container">
            <h1>Удаление объявления</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="logout.php">Выйти</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="message-section">
            <div class="container">
                <div class="message <?php echo $messageType; ?>">
                    <p><?php echo $message; ?></p>
                </div>
                <p>Вы будете перенаправлены на главную страницу через несколько секунд...</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 АвтоМаркет. Все права защищены.</p>
        </div>
    </footer>
    <script src="js/delete-car.js"></script>

</body>
</html>
