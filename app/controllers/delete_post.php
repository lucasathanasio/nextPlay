<?php
include '../../config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Pega o post e verifica se pertence ao usuário
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$post_id, $user_id]);
    $post = $stmt->fetch();

    if ($post) {
        // Exclui likes e dislikes
        $pdo->prepare("DELETE FROM likes WHERE post_id = ?")->execute([$post_id]);
        $pdo->prepare("DELETE FROM dislikes WHERE post_id = ?")->execute([$post_id]);

        // Exclui comentários
        $pdo->prepare("DELETE FROM comments WHERE post_id = ?")->execute([$post_id]);

        // Exclui da tabela postnormal se for tipo 'normal'
        if ($post['tipo'] === 'normal') {
            $pdo->prepare("DELETE FROM postnormal WHERE post_id = ?")->execute([$post_id]);
        }

        // Exclui da tabela postjogo se for tipo 'jogo'
        if ($post['tipo'] === 'jogo') {
            $pdo->prepare("DELETE FROM postjogo WHERE post_id = ?")->execute([$post_id]);
        }

        // Exclui da tabela principal posts
        $pdo->prepare("DELETE FROM posts WHERE id = ?")->execute([$post_id]);

        $_SESSION['message'] = "Post excluído com sucesso.";
        header('Location: ../views/feed.php');
        exit();
    } else {
        $_SESSION['message'] = "Erro: post não encontrado ou não pertence a você.";
        header('Location: ../views/feed.php');
        exit();
    }
} else {
    header('Location: ../views/feed.php');
    exit();
}
