<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];


$result = $conn->query("SELECT * FROM cars WHERE user = '$user'");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <!-- Подключаем шрифт (если ещё не подключен) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <div class="container">
            <h1>Личный кабинет</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="add-car.php">Добавить объявление</a></li>
                    <li><a href="logout.php">Выйти</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="car-list-section">
            <div class="container">
                <h2>Мои объявления</h2>

                <div class="car-list">
                    <?php while ($car = $result->fetch_assoc()) { ?>
                        <div class="car-card">
                     
                            <?php
                                $imagePath = 'uploads/' . $car['images'];
                                if (file_exists($imagePath)) {
                                    echo '<img src="' . $imagePath . '" alt="' . $car['brand'] . ' ' . $car['model'] . '">';
                                } else {
                                    echo '<img src="uploads/default.jpg" alt="default image">'; 
                                }
                            ?>
                            <div class="car-info">
                                <h3><?php echo $car['brand'] . ' ' . $car['model']; ?></h3>
                                <p><strong>Год:</strong> <?php echo $car['year']; ?></p>
                                <p><strong>Цена:</strong> <?php echo $car['price']; ?> $</p>
                                <a href="car.php?id=<?php echo $car['id']; ?>" class="btn">Подробнее</a>
                                <a href="edit-car.php?id=<?php echo $car['id']; ?>" class="btn">Редактировать</a>
                                <a href="delete-car.php?id=<?php echo $car['id']; ?>" class="btn" onclick="return confirm('Вы уверены, что хотите удалить это объявление?');">Удалить</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 АвтоМаркет. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
