<?php
require 'config.php';
if (!isUser()) redirect('login.php');
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = intval($_POST['room_id']);
    $banquet_date = $_POST['banquet_date'];
    $payment_method = $_POST['payment_method'];
    if (!$room_id || !$banquet_date || !$payment_method) {
        $error = 'Заполните все поля заявки.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO bookings (user_id, room_id, banquet_date, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiss', $_SESSION['user_id'], $room_id, $banquet_date, $payment_method);
        $stmt->execute();
        $success = 'Заявка создана и отправлена администратору.';
    }
}
$rooms = $mysqli->query("SELECT * FROM rooms ORDER BY name");
$pageTitle='Оформление заявки'; require 'header.php';
?>
<div class="form-box">
<h2>Оформление заявки</h2>
<?php if ($success): ?><div class="alert success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
    <select name="room_id" required>
        <option value="">Выберите помещение</option>
        <?php while ($r = $rooms->fetch_assoc()): ?>
            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?> — <?= htmlspecialchars($r['type']) ?></option>
        <?php endwhile; ?>
    </select>
    <input type="datetime-local" name="banquet_date" required>
    <select name="payment_method" required>
        <option value="">Способ оплаты</option>
        <option>Наличные</option>
        <option>Банковская карта</option>
        <option>Безналичный расчет</option>
    </select>
    <button class="btn" type="submit">Отправить заявку</button>
</form>
</div>
<?php require 'footer.php'; ?>
