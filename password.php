<?php
session_start();


$correct_password = '8081';


if (isset($_POST['password'])) {
    $password = $_POST['password'];


    if ($password == $correct_password) {
        $_SESSION['authenticated'] = true;
        header("Location: delete-cars.php"); 
        exit();
    } else {
        $error = "Неверный пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>АвтоМаркет</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Вход в админ-панель</h2>
            <form action="password.php" method="POST" class="password-form">
                <input type="password" name="password" placeholder="Введите пароль" required>
                <button type="submit">Войти</button>
            </form>

            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 АвтоМаркет. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
