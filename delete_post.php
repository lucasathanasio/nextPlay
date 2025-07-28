<?php
include 'config/db.php';

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

    // Verifica se o post pertence ao usuário logado
    $query = $pdo->prepare("SELECT * FROM postnormal WHERE id = ? AND user_id = ?");
    $query->execute([$post_id, $user_id]);
    $post = $query->fetch();

    if ($post) {
        // Exclui os registros relacionados nas tabelas likes e dislikes
        $query = $pdo->prepare("DELETE FROM likes WHERE post_id = ?");
        $query->execute([$post_id]);

        $query = $pdo->prepare("DELETE FROM dislikes WHERE post_id = ?");
        $query->execute([$post_id]);

        // Exclui o post
        $query = $pdo->prepare("DELETE FROM postnormal WHERE id = ?");
        $query->execute([$post_id]);

        // Redireciona para o feed com mensagem de sucesso
        $_SESSION['message'] = "Post excluído com sucesso.";
        header('Location: feed.php');
        exit();
    } else {
        // Redireciona para o feed com mensagem de erro
        $_SESSION['message'] = "Erro ao excluir o post.";
        header('Location: feed.php');
        exit();
    }
} else {
    header('Location: feed.php');
    exit();
}
?>
