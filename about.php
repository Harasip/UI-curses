<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О проекте</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="light-theme">

<header>
    <div class="container">
        <h1>UI онлайн-курсов языков</h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="admin.php">Админ-панель</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Выход</a></li>
                <?php else: ?>
                    <li><a href="login.php">Вход</a></li>
                    <li><a href="register.php">Регистрация</a></li>
                <?php endif; ?>
                <li><a href="index.php">Главная</a></li>
                <li><a href="about.php" class="active">О проекте</a></li>
            </ul>
            <button id="theme-toggle" aria-label="Переключить тему">🌙</button>
        </nav>
    </div>
</header>

<main class="container">
    <h1 class="page-title">О проекте</h1>

    <section class="about-section">
        <h2>Цель сайта</h2>
        <p>Демонстрация современных подходов к проектированию интерфейсов для онлайн-курсов по изучению иностранных языков.</p>
        <p>Сайт создан как учебный проект и платформа для обсуждения UX/UI трендов 2025–2026 годов.</p>
    </section>

    <section class="about-section">
        <h2>Контакты</h2>
        <ul class="contact-list">
            <li><strong>Email:</strong> test@email.com</li>
            <li><strong>Telegram:</strong> @test</li>
            <li><strong>Номер телефона:</strong> +7800553535<li>
        </ul>
    </section>

    <section class="about-section">
        <h2>Технологии</h2>
        <ul>
            <li>PHP 8+ + MySQL</li>
            <li>HTML5, CSS3 (переменные, clamp, dark mode)</li>
            <li>Vanilla JavaScript</li>
            <li>Адаптивный дизайн, доступность</li>
        </ul>
    </section>
</main>

<script src="assets/js/main.js"></script>
</body>
</html>