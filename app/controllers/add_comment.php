<?php
include '../../config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$redirect_page = '../views/feed.php'; // padrão

// Define a página de redirecionamento com base no campo "from"
if (isset($_POST['from']) && $_POST['from'] === 'userPerfil' && isset($_POST['profile_id'])) {
    $redirect_page = 'userPerfil.php?id=' . $_POST['profile_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $content = trim($_POST['content']);

    if (!empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$post_id, $user_id, $content]);
    }
}

// Redireciona para a página correta
header('Location: ' . $redirect_page);
exit();
?>
