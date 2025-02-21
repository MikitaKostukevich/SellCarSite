<?php
include 'db.php';
session_start();

// Проверяем, есть ли сессия аутентификации
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: password.php");
    exit();
}

// Удаление объявления
if (isset($_GET['delete'])) {
    $car_id = $_GET['delete'];

    // Запрос на удаление
    $sql = "DELETE FROM cars WHERE id = $car_id";

    if ($conn->query($sql) === TRUE) {
        echo "Объявление успешно удалено!";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

// Получаем все автомобили для отображения
$result = $conn->query("SELECT * FROM cars ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удаление объявлений</title>
    <link rel="stylesheet" href="css/style_car.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>АвтоМаркет - Удаление объявлений</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="add-car.php">Добавить объявление</a></li>
                    <li><a href="password.php">Выйти</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="car-list-section">
            <div class="container">
                <h2>Список автомобилей</h2>
                <div class="car-list">
                    <?php while ($car = $result->fetch_assoc()) { ?>
                        <div class="car-card">
                            <img src="uploads/<?php echo $car['images']; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>" class="car-image">
                            <div class="car-info">
                                <h3><?php echo $car['brand'] . ' ' . $car['model']; ?></h3>
                                <p><strong>Год:</strong> <?php echo $car['year']; ?></p>
                                <p><strong>Цена:</strong> <?php echo $car['price']; ?> $</p>
                                <a href="delete-cars.php?delete=<?php echo $car['id']; ?>" class="btn" onclick="return confirm('Вы уверены, что хотите удалить это объявление?')">Удалить</a>
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
