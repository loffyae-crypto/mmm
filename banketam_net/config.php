<?php
session_start();
$host = 'localhost';
$db = 'banketam_net';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Ошибка подключения к БД: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

function isUser() {
    return isset($_SESSION['user_id']);
}
function isAdmin() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}
function redirect($url) {
    header("Location: $url");
    exit;
}
?>
