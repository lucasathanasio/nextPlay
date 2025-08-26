<?php
include 'config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['user_id'];

    // Verifica se o comentário pertence ao usuário logado
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
    $stmt->execute([$comment_id, $user_id]);

    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$comment_id]);
    }
}

header('Location: feed.php');
exit();
?>
