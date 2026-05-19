<?php
require 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!$login || !$password || !$full_name || !$phone || !$email) {
        $error = 'Заполните все поля.';
    } elseif (!preg_match('/^[A-Za-z0-9]{6,}$/', $login)) {
        $error = 'Логин должен содержать латинские буквы и цифры, минимум 6 символов.';
    } elseif (strlen($password) < 8) {
        $error = 'Пароль должен быть не менее 8 символов.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Введите корректный e-mail.';
    } else {
        $check = $mysqli->prepare("SELECT id FROM users WHERE login=?");
        $check->bind_param('s', $login);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Такой логин уже занят.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO users (login, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $login, $hash, $full_name, $phone, $email);
            $stmt->execute();
            redirect('login.php?registered=1');
        }
    }
}
$pageTitle='Регистрация'; require 'header.php';
?>
<div class="form-box">
    <h2>Регистрация</h2>
    <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" id="registerForm">
        <input name="login" placeholder="Логин" required minlength="6" pattern="[A-Za-z0-9]+">
        <input name="password" type="password" placeholder="Пароль" required minlength="8">
        <input name="full_name" placeholder="ФИО" required>
        <input name="phone" placeholder="Телефон" required>
        <input name="email" type="email" placeholder="E-mail" required>
        <button class="btn" type="submit">Зарегистрироваться</button>
    </form>
    <p><a href="login.php">Уже зарегистрированы? Вход</a></p>
</div>
<?php require 'footer.php'; ?>
