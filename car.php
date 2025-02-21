<?php
include 'db.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM cars WHERE id = $id");
$car = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car['brand'] . ' ' . $car['model']; ?></title>
    <link rel="stylesheet" href="css/style_car.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>АвтоМаркет</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="add-car.php">Добавить объявление</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="car-details-section">
            <div class="container">
                <div class="car-card">
                <img src="uploads/<?php echo $car['images']; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>" class="car-image">

                    <div class="car-info">
                        <h2><?php echo $car['brand'] . ' ' . $car['model']; ?></h2>
                        <p><strong>Год выпуска:</strong> <?php echo $car['year']; ?></p>
                        <p><strong>Цена:</strong> <?php echo $car['price']; ?> $</p>
                        <p><strong>Описание:</strong> <?php echo $car['description']; ?></p>
                        <a href="index.php" class="btn">Назад</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 АвтоМаркет. Все права защищены.</p>
        </div>
    </footer>
    <script src="js/car-details.js"></script>

</body>
</html>
