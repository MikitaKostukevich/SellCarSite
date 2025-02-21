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
    echo "Вы не можете редактировать это объявление.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "UPDATE cars SET brand='$brand', model='$model', year='$year', price='$price', description='$description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Объявление успешно обновлено.";
        header("Location: car.php?id=$id");
    } else {
        echo "Ошибка при обновлении объявления: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать объявление</title>
    <link rel="stylesheet" href="css/style_addcar.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Редактировать объявление</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <form action="edit-car.php?id=<?php echo $car['id']; ?>" method="POST">
                <input type="text" name="brand" value="<?php echo $car['brand']; ?>" required>
                <input type="text" name="model" value="<?php echo $car['model']; ?>" required>
                <input type="number" name="year" value="<?php echo $car['year']; ?>" required>
                <input type="number" name="price" value="<?php echo $car['price']; ?>" required>
                <textarea name="description" required><?php echo $car['description']; ?></textarea>
                <button type="submit">Обновить</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 АвтоМаркет. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
