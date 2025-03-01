<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];

if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $description = $_POST['description'];


    $image_paths = [];


    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $total_files = count($_FILES['images']['name']);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];  

        for ($i = 0; $i < $total_files; $i++) {
            $image_name = $_FILES['images']['name'][$i];
            $image_tmp = $_FILES['images']['tmp_name'][$i];
            $image_size = $_FILES['images']['size'][$i];
            $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));


            if (in_array($image_ext, $allowed_extensions)) {
                $new_image_name = uniqid() . '.' . $image_ext;
                $target = "uploads/" . $new_image_name;

                if (move_uploaded_file($image_tmp, $target)) {
                    $image_paths[] = $new_image_name;  
                } else {
                    echo "Ошибка при загрузке изображения $image_name.<br>";
                }
            } else {
                echo "Неподдерживаемый формат изображения: $image_name.<br>";
            }
        }
    }


    $image_paths_str = implode(',', $image_paths);


    $sql = "INSERT INTO cars (brand, model, year, price, description, images, user)
            VALUES ('$brand', '$model', '$year', '$price', '$description', '$image_paths_str', '$user')";

    if ($conn->query($sql) === TRUE) {
        echo "Объявление успешно добавлено!";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить авто</title>
    <link rel="stylesheet" href="css/style_addcar.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <!-- Подключаем шрифт (если ещё не подключен) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        function previewImages() {
            const preview = document.querySelector('.image-preview');
            preview.innerHTML = ''; 
            const files = document.querySelector('input[type=file]').files;

            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        preview.appendChild(img);
                    }

                    reader.readAsDataURL(file);
                }
            }
        }


        function addImageField() {
            const container = document.querySelector('.image-fields-container');
            const inputField = document.createElement('div');
            inputField.classList.add('form-group');
            inputField.innerHTML = `
                <input type="file" name="images[]" accept="image/*" onchange="previewImages()">
            `;
            container.appendChild(inputField);
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1>Добавить авто</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="add-car.php">Добавить объявление</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="add-car-section">
            <div class="container">
                <h2>Заполните форму</h2>
                <form action="add-car.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="brand" placeholder="Марка" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="model" placeholder="Модель" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="year" placeholder="Год выпуска" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="price" placeholder="Цена ($)" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="body_type" placeholder="Тип кузова" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="transmission" placeholder="Коробка передач" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="engine_type" placeholder="Тип двигателя" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="drive_type" placeholder="Привод" required>
                    </div>
                    <div class="form-group">
                        <textarea name="description" placeholder="Описание" required></textarea>
                    </div>
                    

                    <div class="form-group image-fields-container">
                        <input type="file" name="images[]" accept="image/*" onchange="previewImages()">
                    </div>
                    

                    <div class="form-group">
                        <button type="button" onclick="addImageField()">Добавить ещё изображения</button>
                    </div>


                    <div class="image-preview"></div>
                    
                    <div class="form-group">
                        <button type="submit" name="submit">Добавить</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 АвтоМаркет. Все права защищены.</p>
        </div>
    </footer>
    <script src="js/add-car.js"></script>
</body>
</html>
