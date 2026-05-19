<?php if (!isset($pageTitle)) $pageTitle = 'Банкетам.Нет'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="top">
    <a class="logo" href="index.php">Банкетам.Нет</a>
    <nav>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Админ-панель</a>
            <a href="logout.php">Выход</a>
        <?php elseif (isUser()): ?>
            <a href="dashboard.php">Личный кабинет</a>
            <a href="booking.php">Новая заявка</a>
            <a href="logout.php">Выход</a>
        <?php else: ?>
            <a href="login.php">Вход</a>
            <a href="register.php">Регистрация</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
