<?php
// db_config.php — настройки базы данных (измените под себя)

define('DB_SERVER',   'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME',     'language_ui_db');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Ошибка подключения к БД: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");