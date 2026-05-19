<?php
require 'config.php';
if (!isUser()) redirect('login.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $text = trim($_POST['text']);
    if ($text) {
        $stmt = $mysqli->prepare("INSERT INTO reviews (user_id, booking_id, text) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $_SESSION['user_id'], $booking_id, $text);
        $stmt->execute();
    }
}
$stmt = $mysqli->prepare("SELECT b.*, r.name AS room_name FROM bookings b JOIN rooms r ON b.room_id=r.id WHERE b.user_id=? ORDER BY b.created_at DESC");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$bookings = $stmt->get_result();
$pageTitle='Личный кабинет'; require 'header.php';
?>
<h2>Личный кабинет</h2>
<p>Здравствуйте, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
<a class="btn" href="booking.php">Оформить новую заявку</a>
<h3>История заявок</h3>
<table>
<tr><th>Помещение</th><th>Дата банкета</th><th>Оплата</th><th>Статус</th><th>Отзыв</th></tr>
<?php while ($b = $bookings->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($b['room_name']) ?></td>
    <td><?= date('d.m.Y H:i', strtotime($b['banquet_date'])) ?></td>
    <td><?= htmlspecialchars($b['payment_method']) ?></td>
    <td><span class="status"><?= htmlspecialchars($b['status']) ?></span></td>
    <td>
        <?php if ($b['status'] === 'Банкет завершен'): ?>
        <form method="post" class="review-form">
            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
            <textarea name="text" placeholder="Ваш отзыв" required></textarea>
            <button type="submit">Отправить</button>
        </form>
        <?php else: ?>Отзыв доступен после завершения<?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php require 'footer.php'; ?>
