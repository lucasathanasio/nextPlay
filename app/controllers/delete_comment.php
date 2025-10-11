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

// Define a página de redirecionamento com base nos campos "from" e "profile_id"
if (isset($_POST['from']) && $_POST['from'] === 'userPerfil' && isset($_POST['profile_id'])) {
    $redirect_page = 'userPerfil.php?id=' . $_POST['profile_id'];
}

// Deletar comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];

    // Verifica se o comentário pertence ao usuário logado
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
    $stmt->execute([$comment_id, $user_id]);

    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$comment_id]);
    }
}

// Redireciona para a página correta
header('Location: ' . $redirect_page);
exit();
?>
