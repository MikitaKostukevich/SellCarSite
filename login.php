<?php
session_start();
include 'db.php'; // Подключение к базе

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Заполните все поля!";
    } else {
        // Подготовленный запрос для защиты от SQL-инъекций
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Добавляем роль

            // Если админ, перенаправляем в админку
            if ($user['role'] == 'admin') {
                header('Location: admin/admin.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            $error_message = "Неверное имя пользователя или пароль";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <!-- Подключаем шрифт (если ещё не подключен) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="login-container">
        <h2>Авторизация</h2>

        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>
