<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проектирование интерфейсов для онлайн-курсов иностранных языков</title>
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
                <li><a href="about.php">О проекте</a></li>
            </ul>
            <button id="theme-toggle" aria-label="Переключить тему">🌙</button>
        </nav>
    </div>
</header>

<main class="container">
    <h1 class="page-title">Проектирование и разработка интерфейсов<br>для онлайн-курсов по изучению иностранных языков</h1>

    <?php
    $result = $conn->query("SELECT c.*, u.username 
                           FROM content c 
                           LEFT JOIN users u ON c.author_id = u.id 
                           WHERE c.deleted_at IS NULL
                           ORDER BY c.created_at DESC");

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $article_id = $row['id'];
            $title = htmlspecialchars($row['title']);
            $meta = 'Автор: ' . htmlspecialchars($row['username'] ?? '—') . ' • ' . date('d.m.Y H:i', strtotime($row['created_at']));
            $body = nl2br(htmlspecialchars($row['body']));
            
            $short_body = mb_substr($row['body'], 0, 250);
            if (mb_strlen($row['body']) > 250) $short_body .= '...';
            $short_body = nl2br(htmlspecialchars($short_body));

            echo '<article class="article" id="article-' . $article_id . '">';
            echo '<h2 class="article-title">';
            echo '<button class="toggle-article" aria-expanded="false" aria-controls="content-' . $article_id . '">';
            echo $title . '<span class="toggle-icon">▼</span>';
            echo '</button>';
            echo '</h2>';
            
            echo '<div class="meta">' . $meta . '</div>';
            echo '<div class="article-preview">' . $short_body . '</div>';
            
            echo '<div class="article-content hidden" id="content-' . $article_id . '">';
            echo '<p>' . $body . '</p>';

            echo '<div class="comments-section">';
            echo '<h3>Комментарии</h3>';

            $comments = $conn->query("SELECT com.*, us.username 
                                     FROM comments com 
                                     JOIN users us ON com.user_id = us.id 
                                     WHERE com.article_id = $article_id 
                                     ORDER BY com.created_at ASC");

            if ($comments->num_rows > 0) {
                while ($com = $comments->fetch_assoc()) {
                    echo '<div class="comment">';
                    echo '<strong>' . htmlspecialchars($com['username']) . '</strong> ';
                    echo '<span class="comment-date">' . date('d.m.Y H:i', strtotime($com['created_at'])) . '</span>';
                    echo '<p>' . nl2br(htmlspecialchars($com['comment_text'])) . '</p>';
                    
                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                        echo '<form method="post" action="delete_comment.php" class="delete-comment-form">';
                        echo '<input type="hidden" name="comment_id" value="' . $com['id'] . '">';
                        echo '<input type="hidden" name="article_id" value="' . $article_id . '">';
                        echo '<button type="submit" class="btn-delete" onclick="return confirm(\'Удалить?\')">Удалить</button>';
                        echo '</form>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<p class="no-comments">Пока нет комментариев.</p>';
            }

            if (isset($_SESSION['user_id'])) {
                echo '<form method="post" action="add_comment.php" class="comment-form">';
                echo '<input type="hidden" name="article_id" value="' . $article_id . '">';
                echo '<textarea name="comment_text" placeholder="Ваш комментарий..." required rows="3"></textarea>';
                echo '<button type="submit" class="btn btn-primary">Отправить</button>';
                echo '</form>';
            } else {
                echo '<p class="login-to-comment"><a href="login.php">Войдите</a>, чтобы комментировать</p>';
            }

            echo '</div>'; // comments-section
            echo '</div>'; // article-content
            echo '</article>';
        }
    } else {
        echo '<p class="info-message">Пока нет материалов. Добавьте их в админ-панели.</p>';
    }

    $conn->close();
    ?>
</main>

<script src="assets/js/main.js"></script>
</body>
</html>