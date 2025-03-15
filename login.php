<?php
session_start();
include 'db.php'; // Подключение к базе

$recaptcha_secret_key = "6LcQf_MqAAAAAN-oIcj61jfl84HsY6ceqNr72Seg"; // reCAPTCHA secret key

// Проверяем, есть ли активная сессия или cookie для авто-входа
if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}

// Если пользователь уже авторизован, перенаправляем его
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']); // Проверяем "Запомнить меня"
    $captcha = $_POST['g-recaptcha-response'];

    if (empty($username) || empty($password)) {
        $error_message = "Заполните все поля!";
    } else {
        // Проверяем капчу
        $captcha_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret_key&response=$captcha");
        $captcha_data = json_decode($captcha_response);

        if (!$captcha_data->success) {
            $error_message = "Подтвердите, что вы не робот!";
        } else {
            // Подготовленный запрос для защиты от SQL-инъекций
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Добавляем роль в сессию

                // Если "Запомнить меня" - устанавливаем cookie на 7 дней
                if ($remember) {
                    setcookie("user", $user['username'], time() + (86400 * 7), "/"); // 7 дней
                }

                // Перенаправление
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
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Подключение reCAPTCHA -->
</head>
<body>
<header>
    <div class="login-container">
        <h2>Авторизация</h2>

        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            
            <label>
                <input type="checkbox" name="remember"> Запомнить меня
            </label>

            <div class="g-recaptcha" data-sitekey="6LcQf_MqAAAAAP2lO4CpsKoiQB74B0PNMkP1F_Yz"></div> <!-- reCAPTCHA -->
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>
