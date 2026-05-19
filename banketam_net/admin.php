<?php
require 'config.php';
if (!isAdmin()) redirect('login.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['booking_id']);
    $status = $_POST['status'];
    if (in_array($status, ['Новая','Банкет назначен','Банкет завершен'])) {
        $stmt = $mysqli->prepare("UPDATE bookings SET status=? WHERE id=?");
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
    }
}
$sql = "SELECT b.*, u.full_name, u.phone, u.email, r.name AS room_name
        FROM bookings b JOIN users u ON b.user_id=u.id JOIN rooms r ON b.room_id=r.id
        ORDER BY b.created_at DESC";
$bookings = $mysqli->query($sql);
$pageTitle='Админ-панель'; require 'header.php';
?>
<h2>Панель администратора</h2>
<table>
<tr><th>Пользователь</th><th>Контакты</th><th>Помещение</th><th>Дата</th><th>Оплата</th><th>Статус</th></tr>
<?php while ($b = $bookings->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($b['full_name']) ?></td>
    <td><?= htmlspecialchars($b['phone']) ?><br><?= htmlspecialchars($b['email']) ?></td>
    <td><?= htmlspecialchars($b['room_name']) ?></td>
    <td><?= date('d.m.Y H:i', strtotime($b['banquet_date'])) ?></td>
    <td><?= htmlspecialchars($b['payment_method']) ?></td>
    <td>
        <form method="post" class="inline-form">
            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
            <select name="status">
                <?php foreach (['Новая','Банкет назначен','Банкет завершен'] as $s): ?>
                    <option <?= $b['status']===$s?'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Сохранить</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php require 'footer.php'; ?>
