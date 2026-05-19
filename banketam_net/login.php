<?php
require 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === 'Admin26' && $password === 'Demo20') {
        $_SESSION['admin'] = true;
        redirect('admin.php');
    }

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE login=?");
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        redirect('dashboard.php');
    } else {
        $error = 'Неверный логин или пароль. Проверьте данные и попробуйте снова.';
    }
}
$pageTitle='Вход'; require 'header.php';
?>
<div class="form-box">
    <h2>Вход</h2>
    <?php if (isset($_GET['registered'])): ?><div class="alert success">Регистрация успешна. Теперь войдите.</div><?php endif; ?>
    <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
        <input name="login" placeholder="Логин" required>
        <input name="password" type="password" placeholder="Пароль" required>
        <button class="btn" type="submit">Войти</button>
    </form>
    <p><a href="register.php">Еще не зарегистрированы? Регистрация</a></p>
</div>
<?php require 'footer.php'; ?>
