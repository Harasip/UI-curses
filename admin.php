<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db_config.php';

$success = $error = '';

if (isset($_POST['delete_article']) && isset($_POST['article_id'])) {
    $article_id = (int)$_POST['article_id'];
    $stmt = $conn->prepare("UPDATE content SET deleted_at = NOW() WHERE id = ? AND author_id = ?");
    $stmt->bind_param("ii", $article_id, $_SESSION['user_id']);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $success = 'Статья удалена';
    } else {
        $error = 'Ошибка удаления';
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_article'])) {
    $title = trim($_POST['title'] ?? '');
    $body  = trim($_POST['body']  ?? '');
    $author_id = $_SESSION['user_id'];

    if (empty($title) || empty($body)) {
        $error = 'Заполните поля';
    } else {
        $stmt = $conn->prepare("INSERT INTO content (title, body, author_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $body, $author_id);
        if ($stmt->execute()) {
            $success = 'Добавлено';
        } else {
            $error = 'Ошибка';
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
    <title>Админ-панель</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="light-theme">

<header>
    <div class="container">
        <h1>Админ-панель</h1>
        <nav>
            <ul>
                <li><a href="index.php">← Главная</a></li>
                <li><a href="about.php">О проекте</a></li>
                <li><a href="logout.php">Выход</a></li>
            </ul>
            <button id="theme-toggle" aria-label="Переключить тему">🌙</button>
        </nav>
    </div>
</header>

<main class="container admin-section">
    <?php if ($success): ?>
        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <h2>Добавить статью</h2>
    <form method="post">
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="body">Текст</label>
            <textarea id="body" name="body" required></textarea>
            <div id="char-count">0 символов</div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Добавить</button>
    </form>

    <h2 style="margin-top: 3rem;">Ваши статьи</h2>

    <?php
    $result = $conn->query("SELECT * FROM content 
                           WHERE author_id = " . (int)$_SESSION['user_id'] . " 
                           AND deleted_at IS NULL 
                           ORDER BY created_at DESC");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<article class="article">';
            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
            echo '<div class="meta">' . date('d.m.Y H:i', strtotime($row['created_at'])) . '</div>';
            $short = mb_substr($row['body'], 0, 280);
            echo '<p>' . nl2br(htmlspecialchars($short)) . (mb_strlen($row['body']) > 280 ? '...' : '') . '</p>';
            echo '<form method="post" style="margin-top:1rem;" onsubmit="return confirm(\'Удалить?\');">';
            echo '<input type="hidden" name="article_id" value="' . $row['id'] . '">';
            echo '<button type="submit" name="delete_article" class="btn btn-danger">Удалить</button>';
            echo '</form>';
            echo '</article>';
        }
    } else {
        echo '<p class="info-message">Нет статей</p>';
    }
    $conn->close();
    ?>
</main>

<script src="assets/js/main.js"></script>
</body>
</html>