<?php
session_start(); 


include 'db.php';


$search = isset($_GET['search']) ? $_GET['search'] : '';
$year_min = isset($_GET['year_min']) ? $_GET['year_min'] : '';
$year_max = isset($_GET['year_max']) ? $_GET['year_max'] : '';
$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';


$sql = "SELECT * FROM cars WHERE 1=1";

if ($search) {
    $sql .= " AND (brand LIKE '%$search%' OR model LIKE '%$search%')";
}
if ($year_min) {
    $sql .= " AND year >= $year_min";
}
if ($year_max) {
    $sql .= " AND year <= $year_max";
}
if ($price_min) {
    $sql .= " AND price >= $price_min";
}
if ($price_max) {
    $sql .= " AND price <= $price_max";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NekitAuto</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>АвтоМаркет</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="profile.php">Личный кабинет</a></li>
                        <li><a href="news.php">Новости</a></li>
                        <li><a href="logout.php">Выйти</a></li>
                        <li><a href="password.php"> Админ-панель</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Войти</a></li>
                        <li><a href="register.php">Регистрация</a></li>
                        <li><a href="news.php">Новости</a></li>
                        <li><a href="password.php"> Админ-панель</a></li>
                    <?php endif; ?>
                </ul>
            </nav>


            <form action="index.php" method="get" class="search-form">
                <input type="text" name="search" placeholder="Поиск по марке или модели" value="<?php echo $search; ?>">
                <button type="submit">Поиск</button>
            </form>
        </div>
    </header>

    <main>
        <section class="car-list-section">
            <div class="container">
                <h2>Список автомобилей</h2>


                <form action="index.php" method="get" class="filter-form">
                    <label for="year_min">Год выпуска с:</label>
                    <input type="number" name="year_min" id="year_min" placeholder="2000" value="<?php echo $year_min; ?>">

                    <label for="year_max">Год выпуска по:</label>
                    <input type="number" name="year_max" id="year_max" placeholder="2025" value="<?php echo $year_max; ?>">

                    <label for="price_min">Цена от:</label>
                    <input type="number" name="price_min" id="price_min" placeholder="1000" value="<?php echo $price_min; ?>">

                    <label for="price_max">Цена до:</label>
                    <input type="number" name="price_max" id="price_max" placeholder="50000" value="<?php echo $price_max; ?>">

                    <button type="submit">Фильтровать</button>
                </form>

                <div class="car-list">
                    <?php while ($car = $result->fetch_assoc()) { ?>
                        <div class="car-card">
                            <?php if (!empty($car['images']) && file_exists("uploads/" . $car['images'])): ?>
                                <img src="uploads/<?php echo $car['images']; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
                            <?php else: ?>
                                <img src="uploads/no-image.jpg" alt="Изображение отсутствует">
                            <?php endif; ?>
                            <div class="car-info">
                                <h3><?php echo $car['brand'] . ' ' . $car['model']; ?></h3>
                                <p><strong>Год:</strong> <?php echo $car['year']; ?></p>
                                <p><strong>Цена:</strong> <?php echo $car['price']; ?> $</p>
                                <a href="car.php?id=<?php echo $car['id']; ?>" class="btn">Подробнее</a>
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
    <script src="js/index.js"></script>
    <script src="js/search.js"></script>
</body>
</html>
