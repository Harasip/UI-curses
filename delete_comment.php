<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = (int)$_POST['comment_id'];
    $article_id = (int)$_POST['article_id'];

    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: index.php#article-$article_id");
exit;