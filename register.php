<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include 'db_config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Заполните все поля';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль минимум 6 символов';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Логин занят';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                header("Location: login.php?reg=ok");
                exit;
            } else {
                $error = 'Ошибка регистрации';
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="light-theme">

<header>
    <div class="container">
        <h1>UI онлайн-курсов языков</h1>
        <nav>
            <ul>
                <li><a href="login.php">Вход</a></li>
                <li><a href="index.php">Главная</a></li>
                <li><a href="about.php">О проекте</a></li>
            </ul>
            <button id="theme-toggle" aria-label="Переключить тему">🌙</button>
        </nav>
    </div>
</header>

<div class="auth-container">
    <div class="auth-box">
        <h2>Регистрация</h2>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group password-wrapper">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                <button type="button" class="toggle-password">👁️</button>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
        </form>
    </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>