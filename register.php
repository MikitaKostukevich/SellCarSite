<?php
session_start();
include 'db.php';

$recaptcha_secret_key = "6LcQf_MqAAAAAN-oIcj61jfl84HsY6ceqNr72Seg"; // reCAPTCHA secret key

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $captcha = $_POST['g-recaptcha-response'];

    // Проверяем капчу
    $captcha_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret_key&response=$captcha");
    $captcha_data = json_decode($captcha_response);

    if (!$captcha_data->success) {
        $error_message = "Подтвердите, что вы не робот!";
    } else {
        // Проверяем, существует ли уже такой email
        $check_query = "SELECT id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($check_query);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $error_message = "Этот email уже зарегистрирован!";
        } else {
            // Добавляем пользователя
            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                $_SESSION['user'] = $username;
                $_SESSION['role'] = 'user'; // По умолчанию обычный пользователь
                
                // Запоминаем пользователя в cookie на 7 дней
                setcookie("user", $username, time() + (86400 * 7), "/");

                header("Location: index.php");
                exit();
            } else {
                $error_message = "Ошибка при регистрации!";
            }
            $stmt->close();
        }

        $stmt_check->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style_register.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Подключение reCAPTCHA -->
</head>
<body>
    <div class="register-container">
        <h2>Регистрация</h2>
        
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            
            <div class="g-recaptcha" data-sitekey="6LcQf_MqAAAAAP2lO4CpsKoiQB74B0PNMkP1F_Yz"></div> <!-- reCAPTCHA -->
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>
