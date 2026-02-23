<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = (int)$_POST['article_id'];
    $comment_text = trim($_POST['comment_text'] ?? '');
    $user_id = $_SESSION['user_id'];

    if ($comment_text !== '') {
        $stmt = $conn->prepare("INSERT INTO comments (article_id, user_id, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $article_id, $user_id, $comment_text);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: index.php#article-$article_id");
exit;