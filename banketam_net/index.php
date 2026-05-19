<?php require 'config.php'; $pageTitle='Главная — Банкетам.Нет'; require 'header.php'; ?>
<section class="hero">
    <h1>Бронирование помещений для банкетов</h1>
    <p>Выберите зал, ресторан, летнюю или закрытую веранду и отправьте заявку администратору.</p>
    <a class="btn" href="booking.php">Начать бронирование</a>
</section>
<section class="cards">
<?php
$result = $mysqli->query("SELECT * FROM rooms ORDER BY id");
while ($room = $result->fetch_assoc()): ?>
    <div class="card">
        <h3><?= htmlspecialchars($room['name']) ?></h3>
        <p><b>Тип:</b> <?= htmlspecialchars($room['type']) ?></p>
        <p><?= htmlspecialchars($room['description']) ?></p>
        <p class="price">от <?= number_format($room['price'], 0, ',', ' ') ?> ₽</p>
    </div>
<?php endwhile; ?>
</section>
<?php require 'footer.php'; ?>
