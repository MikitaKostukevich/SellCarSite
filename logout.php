<?php
session_start();  // Начинаем сессию

// Завершаем сессию и удаляем все данные о пользователе
session_unset();
session_destroy();

// Перенаправляем на главную страницу после выхода
header('Location: index.php');
exit();
?>
